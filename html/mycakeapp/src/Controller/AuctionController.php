<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event; // added.
use Exception; // added.

class AuctionController extends AuctionBaseController
{
	// デフォルトテーブルを使わない
	public $useTable = false;

	// 初期化処理
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Paginator');
		// 必要なモデルをすべてロード
		$this->loadModel('Users');
		$this->loadModel('Biditems');
		$this->loadModel('Bidrequests');
		$this->loadModel('Bidinfo');
		$this->loadModel('Bidmessages');
		// ログインしているユーザー情報をauthuserに設定
		$this->set('authuser', $this->Auth->user());
		// レイアウトをauctionに変更
		$this->viewBuilder()->setLayout('auction');
	}

	// トップページ
	public function index()
	{
		// ページネーションでBiditemsを取得
		$auction = $this->paginate('Biditems', [
			'order' => ['endtime' => 'desc'],
			'limit' => 10
		]);
		$this->set(compact('auction'));
	}

	// 商品情報の表示
	public function view($id = null)
	{
		// $idのBiditemを取得
		$biditem = $this->Biditems->get($id, [
			'contain' => ['Users', 'Bidinfo', 'Bidinfo.Users']
		]);
		// オークション終了時の処理
		if ($biditem->endtime < new \DateTime('now') and $biditem->finished == 0) {
			// finishedを1に変更して保存
			$biditem->finished = 1;
			$this->Biditems->save($biditem);
			// Bidinfoを作成する
			$bidinfo = $this->Bidinfo->newEntity();
			// Bidinfoのbiditem_idに$idを設定
			$bidinfo->biditem_id = $id;
			// 最高金額のBidrequestを検索
			$bidrequest = $this->Bidrequests->find('all', [
				'conditions' => ['biditem_id' => $id],
				'contain' => ['Users'],
				'order' => ['price' => 'desc']
			])->first();
			// Bidrequestが得られた時の処理
			if (!empty($bidrequest)) {
				// Bidinfoの各種プロパティを設定して保存する
				$bidinfo->user_id = $bidrequest->user->id;
				$bidinfo->user = $bidrequest->user;
				$bidinfo->price = $bidrequest->price;
				$this->Bidinfo->save($bidinfo);
			}
			// Biditemのbidinfoに$bidinfoを設定
			$biditem->bidinfo = $bidinfo;
		}
		//カウントダウンタイマー用の時刻を取得
		$endTimeStamp = new \DateTimeImmutable($biditem->endtime);
		$endDate = $endTimeStamp->getTimestamp();

		$nowTimeStamp = new \DateTimeImmutable();
		$nowDate = $nowTimeStamp->getTimestamp();
		$this->set(compact('endDate', 'nowDate'));

		// Bidrequestsからbiditem_idが$idのものを取得
		$bidrequests = $this->Bidrequests->find('all', [
			'conditions' => ['biditem_id' => $id],
			'contain' => ['Users'],
			'order' => ['price' => 'desc']
		])->toArray();
		// オブジェクト類をテンプレート用に設定
		$this->set(compact('biditem', 'bidrequests'));
	}

	// 出品する処理
	public function add()
	{
		//画像保存参考URL:https://qiita.com/kurosu93/items/239e14df7ea20091a53b
		// Biditemインスタンスを用意
		$biditem = $this->Biditems->newEntity();
		// POST送信時の処理
		if ($this->request->is('post')) {
			//image_pathは配列なので先に取り出す。
			$image_data = $this->request->getData('image_path');
			//ファイル名のみ取得
			$image_name = $image_data['name'];
			// $biditemにフォームの送信内容を反映（image_pathは後で更新する）
			$biditem = $this->Biditems->patchEntity($biditem, [
				'user_id' => $this->request->getData('user_id'),
				'name' => $this->request->getData('name'),
				'endtime' => $this->request->getData('endtime'),
				'finished' => $this->request->getData('finished'),
				'description' => $this->request->getData('description'),
				'image_path' => $image_name,
			]);
			// $biditemを保存する
			if ($this->Biditems->save($biditem)) {
				//画像保存名（ファイルパス)の作成
				//画像拡張子のみを取得
				$imageExtention = pathinfo($image_name, PATHINFO_EXTENSION);
				//保存先BiditemのID
				$biditem_id = $biditem->id;
				//webroot/img/Auctionからの絶対パスを取得 参考：https://blog.s-giken.net/323.html
				$webroot_path = realpath(WWW_ROOT . "img/Auction");
				$file_path = $webroot_path . "/" . $biditem_id . "." . $imageExtention;
				//これをすでに一度保存したimage_pathに上書き
				$data = $this->Biditems->patchEntity($biditem, [
					'image_path' => $file_path
				]);
				$this->Biditems->save($data);
				//画像をファイルに保存
				move_uploaded_file($image_data['tmp_name'], $file_path);
				// 成功時のメッセージ
				$this->Flash->success(__('保存しました。'));
				// トップページ（index）に移動
				return $this->redirect(['action' => 'index']);
			}
			// 失敗時のメッセージ
			$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
		}
		// 値を保管
		$this->set(compact('biditem'));
	}

	// 入札の処理
	public function bid($biditem_id = null)
	{
		// 入札用のBidrequestインスタンスを用意
		$bidrequest = $this->Bidrequests->newEntity();
		// $bidrequestにbiditem_idとuser_idを設定
		$bidrequest->biditem_id = $biditem_id;
		$bidrequest->user_id = $this->Auth->user('id');
		// POST送信時の処理
		if ($this->request->is('post')) {
			// $bidrequestに送信フォームの内容を反映する
			$bidrequest = $this->Bidrequests->patchEntity($bidrequest, $this->request->getData());
			// Bidrequestを保存
			if ($this->Bidrequests->save($bidrequest)) {
				// 成功時のメッセージ
				$this->Flash->success(__('入札を送信しました。'));
				// トップページにリダイレクト
				return $this->redirect(['action' => 'view', $biditem_id]);
			}
			// 失敗時のメッセージ
			$this->Flash->error(__('入札に失敗しました。もう一度入力下さい。'));
		}
		// $biditem_idの$biditemを取得する
		$biditem = $this->Biditems->get($biditem_id);
		$this->set(compact('bidrequest', 'biditem'));
	}

	// 落札者とのメッセージ
	public function msg($bidinfo_id = null)
	{
		// Bidmessageを新たに用意
		$bidmsg = $this->Bidmessages->newEntity();
		// POST送信時の処理
		if ($this->request->is('post')) {
			// 送信されたフォームで$bidmsgを更新
			$bidmsg = $this->Bidmessages->patchEntity($bidmsg, $this->request->getData());
			// Bidmessageを保存
			if ($this->Bidmessages->save($bidmsg)) {
				$this->Flash->success(__('保存しました。'));
			} else {
				$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
			}
		}
		try { // $bidinfo_idからBidinfoを取得する
			$bidinfo = $this->Bidinfo->get($bidinfo_id, ['contain' => ['Biditems']]);
		} catch (Exception $e) {
			$bidinfo = null;
		}
		// Bidmessageをbidinfo_idとuser_idで検索
		$bidmsgs = $this->Bidmessages->find('all', [
			'conditions' => ['bidinfo_id' => $bidinfo_id],
			'contain' => ['Users'],
			'order' => ['created' => 'desc']
		]);
		$this->set(compact('bidmsgs', 'bidinfo', 'bidmsg'));
	}

	// 落札情報の表示
	public function home()
	{
		// 自分が落札したBidinfoをページネーションで取得
		$bidinfo = $this->paginate('Bidinfo', [
			'conditions' => ['Bidinfo.user_id' => $this->Auth->user('id')],
			'contain' => ['Users', 'Biditems'],
			'order' => ['created' => 'desc'],
			'limit' => 10
		])->toArray();
		$this->set(compact('bidinfo'));
	}

	// 出品情報の表示
	public function home2()
	{
		// 自分が出品したBiditemをページネーションで取得
		$biditems = $this->paginate('Biditems', [
			'conditions' => ['Biditems.user_id' => $this->Auth->user('id')],
			'contain' => ['Users', 'Bidinfo'],
			'order' => ['created' => 'desc'],
			'limit' => 10
		])->toArray();
		$this->set(compact('biditems'));
	}

	//商品の発送に関するページ
	public function sending($bidinfo_id = null)
	{
		$this->loadModel("Bidsendings");
		// $idのBidinfoを取得
		$bidinfo = $this->Bidinfo->get($bidinfo_id, [
			'contain' => ['Users', 'Biditems', 'Biditems.Users', 'Bidsendings']
		]);
		$this->set(compact('bidinfo'));
		//出品者または落札者でない時はindexページに戻るようアクセス制限をかける
		//ログインユーザーのID
		$login_user_id = $this->Auth->user('id');
		//受け取るユーザー(落札者)のユーザーID
		$receive_user_id = $bidinfo->user_id;
		//出品者のユーザーID
		$sent_user_id = $bidinfo->biditem->user_id;

		$this->set(compact('login_user_id', 'receive_user_id', 'sent_user_id'));

		if (!($login_user_id === $receive_user_id) && !($login_user_id === $sent_user_id)) {
			//アクセス認証NGの場合
			//メッセージ
			$this->Flash->set(__('該当商品の出品者または落札者以外使用できないページです。'));
			// トップページにリダイレクト
			return $this->redirect(['action' => 'index']);
		}
		//発送に関する情報の登録
		// Bidsendingインスタンスを用意


		$bidsending_info = $bidinfo->bidsending;
		// POST送信時の処理

		//落札者の最初のフォーム登録
		if (is_null($bidsending_info)) {
			$bidsending = $this->Bidsendings->newEntity();
			if ($this->request->is('post')) {
				//$bidsendingに送信フォームの内容を反映する
				$bidsending = $this->Bidsendings->patchEntity($bidsending, $this->request->getData());
				// $bidsendingを保存する
				if ($this->Bidsendings->save($bidsending)) {
					//成功時メッセージ
					$this->Flash->success(__('お客様情報を登録しました。出品者が送付するまでお待ちください。'));
					// トップページ（index）に移動
					return $this->redirect(['action' => 'index']);
				}
				// 失敗時のメッセージ
				$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
			}
		} else {
			$bidsending_info_id = $bidsending_info->id;
			//$bidsendingに送信フォームの内容を反映するp175
			$bidsending = $this->Bidsendings->get($bidsending_info_id);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$bidsending_post = $this->request->getData();
				//出品者の受取連絡
				$bidsending = $this->Bidsendings->patchEntity($bidsending, $bidsending_post);
				// $bidsendingを保存する
				/*
				try {
					$this->Bidsendings->saveOrFail($bidsending);
				} catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
					echo $e;
					echo $e->getEntity();
					return '500(Save Failed)';
				}
				return '200(Save Success)';
				*/

				if ($this->Bidsendings->save($bidsending)) {
					//成功時メッセージ
					$this->Flash->success(__('通知を受け付けました。'));
					// トップページ（index）に移動
					return $this->redirect(['action' => 'index']);
				}
				// 失敗時のメッセージ
				$this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
			}
		}




		$this->set(compact('bidsending_info', 'bidsending'));
	}
}
