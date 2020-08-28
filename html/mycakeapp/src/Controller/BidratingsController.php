<?php

namespace App\Controller;

use App\Controller\AppController;


use Cake\Event\Event; // added.
use Exception; // added.
/**
 * Bidratings Controller
 *
 * @property \App\Model\Table\BidratingsTable $Bidratings
 *
 * @method \App\Model\Entity\Bidrating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class BidratingsController extends AuctionBaseController
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
        //$this->loadModel('Bidrequests');
        $this->loadModel('Bidinfo');
        //$this->loadModel('Bidmessages');
        //追加モデル
        $this->loadModel("Bidsendings");
        $this->loadModel("Bidratings");
        // ログインしているユーザー情報をauthuserに設定
        $this->set('authuser', $this->Auth->user());
        // レイアウトをbidratingsに変更
        $this->viewBuilder()->setLayout('bidratings');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bidinfo', 'Users'],
        ];
        $bidratings = $this->paginate($this->Bidratings);

        $this->set(compact('bidratings'));
    }

    /**
     * View method
     *
     * @param string|null $id Bidrating id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bidrating = $this->Bidratings->get($id, [
            'contain' => ['Bidinfo', 'Users'],
        ]);

        $this->set('bidrating', $bidrating);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($bidinfo_id)
    {


        //$bidinfo_idのBidinfoを取得
        $bidinfo = $this->Bidinfo->get($bidinfo_id, [
            'contain' => ['Users', 'Biditems', 'Biditems.Users']
        ]);
        //ログインユーザーのID
        $login_user_id = $this->Auth->user('id');
        $this->set(compact('bidinfo', 'login_user_id'));
        //今までログインユーザーが登録した評価一覧
        $my_bidratings_id = $this->Bidratings->find('all', [
            'conditions' => ['Bidratings.rate_user_id' => $this->Auth->user('id')],
        ])->toArray();
        $my_bidinfo_id = array_column($my_bidratings_id, 'bidinfo_id');
        //評価入力済みの場合(ログインユーザーIDと取引IDがテーブル内のエンティティと一致した場合)
        foreach ($my_bidinfo_id as $bidinfo_id) {
            if ($bidinfo_id === $bidinfo->id) {
                //メッセージ
                $this->Flash->set(__('本取引の評価は入力済みです。'));
                // トップページにリダイレクト
                return $this->redirect($this->request->referer());
            }
        }
        //評価の登録
        $bidrating = $this->Bidratings->newEntity();
        if ($this->request->is('post')) {
            $bidrating = $this->Bidratings->patchEntity($bidrating, $this->request->getData());
            if ($this->Bidratings->save($bidrating)) {
                $this->Flash->success(__('評価を保存しました。'));

                return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
            }
            $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
        }
        $this->set(compact('bidrating', 'my_bidinfo_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bidrating id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bidrating = $this->Bidratings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bidrating = $this->Bidratings->patchEntity($bidrating, $this->request->getData());
            if ($this->Bidratings->save($bidrating)) {
                $this->Flash->success(__('The bidrating has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidrating could not be saved. Please, try again.'));
        }
        $bidinfo = $this->Bidratings->Bidinfo->find('list', ['limit' => 200]);
        $users = $this->Bidratings->Users->find('list', ['limit' => 200]);
        $this->set(compact('bidrating', 'bidinfo', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bidrating id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bidrating = $this->Bidratings->get($id);
        if ($this->Bidratings->delete($bidrating)) {
            $this->Flash->success(__('The bidrating has been deleted.'));
        } else {
            $this->Flash->error(__('The bidrating could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
