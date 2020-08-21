<h2>「<?= $biditem->name ?>」の情報</h2>
<table class="vertical-table">
	<tr>
		<th class="small" scope="row">出品者</th>
		<td><?= $biditem->has('user') ? $biditem->user->username : '' ?></td>
	</tr>
	<tr>
		<th scope="row">商品名</th>
		<td><?= h($biditem->name) ?></td>
	</tr>
	<tr>
		<th scope="row">商品ID</th>
		<td><?= $this->Number->format($biditem->id) ?></td>
	</tr>
	<tr>
		<th scope="row">終了時間</th>
		<td><?= h($biditem->endtime) ?></td>
	</tr>
	<tr>
		<th scope="row">投稿時間</th>
		<td><?= h($biditem->created) ?></td>
	</tr>
	<!-- 商品詳細 -->
	<tr>
		<th scope="row">商品詳細</th>
		<td>
			<?php
			if (is_null($biditem->description)) :
			?>
				<?= $this->Form->create($biditem) ?>
				<?php
				echo "詳細を入力してください。";
				echo $this->Form->textarea('description');
				?>
				<?= $this->Form->button(__('Submit')) ?>
				<?= $this->Form->end() ?>
			<?php
			else :
			?>
				<?= h($biditem->description) ?>
			<?php
			endif;
			?>
		</td>
	</tr>
	<!-- 商品画像 -->
	<tr>
		<th scope="row">商品画像</th>
		<td>
			<?= $this->Html->image(
				"Auction/" . pathinfo($biditem->image_path, PATHINFO_BASENAME),
				array(
					'width' => '100',
					'height' => '100',
					'alt' => h($biditem->name)
				)
			); ?>
		</td>
	</tr>
	<!-- カウントダウンタイマー -->
	<tr>
		<th scope="row">終了まで</th>
		<td id="result">
			<script type="text/javascript">
				var endDate = <?= json_encode($endDate, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
				var nowDate = <?= json_encode($nowDate, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
			</script>
		</td>
		<?= $this->Html->script('auction', array('inline' => false)); ?>
	</tr>
	<tr>
		<th scope="row"><?= __('終了した？') ?></th>
		<td><?= $biditem->finished ? __('Yes') : __('No'); ?></td>
	</tr>
</table>
<div class="related">
	<h4><?= __('落札情報') ?></h4>
	<?php if (!empty($biditem->bidinfo)) : ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col">落札者</th>
				<th scope="col">落札金額</th>
				<th scope="col">落札日時</th>
			</tr>
			<tr>
				<td><?= h($biditem->bidinfo->user->username) ?></td>
				<td><?= h($biditem->bidinfo->price) ?>円</td>
				<td><?= h($biditem->endtime) ?></td>
			</tr>
		</table>
	<?php else : ?>
		<p><?= '※落札情報は、ありません。' ?></p>
	<?php endif; ?>
</div>
<div class="related">
	<h4><?= __('入札情報') ?></h4>
	<?php if (!$biditem->finished) : ?>
		<h6><a href="<?= $this->Url->build(['action' => 'bid', $biditem->id]) ?>">《入札する！》</a></h6>
		<?php if (!empty($bidrequests)) : ?>
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th scope="col">入札者</th>
						<th scope="col">金額</th>
						<th scope="col">入札日時</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bidrequests as $bidrequest) : ?>
						<tr>
							<td><?= h($bidrequest->user->username) ?></td>
							<td><?= h($bidrequest->price) ?>円</td>
							<td><?= $bidrequest->created ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else : ?>
			<p><?= '※入札は、まだありません。' ?></p>
		<?php endif; ?>
	<?php else : ?>
		<p><?= '※入札は、終了しました。' ?></p>
	<?php endif; ?>
</div>
