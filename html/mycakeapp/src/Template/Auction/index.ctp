<h2>ミニオークション!</h2>
<h3>※出品されている商品</h3>
<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th class="main" scope="col"><?= $this->Paginator->sort('name') ?></th>
			<th scope="col"><?= $this->Paginator->sort('finished') ?></th>
			<th scope="col"><?= $this->Paginator->sort('endtime') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($auction as $biditem) : ?>
			<tr>
				<td><?= h($biditem->name) ?></td>
				<td><?= h($biditem->finished ? 'Finished' : '') ?></td>
				<td><?= h($biditem->endtime) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $biditem->id]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->first('<< ' . __('first')) ?>
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('next') . ' >') ?>
		<?= $this->Paginator->last(__('last') . ' >>') ?>
	</ul>
</div>

<h3>※今までの取引評価一覧</h3>
<?php if (!is_null($bidrate_average)) : ?>
	<h4>平均評価点 : <?= $bidrate_average ?></h4>
<?php endif; ?>
<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th class="main" scope="col"><?= $this->Paginator->sort('name') ?></th>
			<th scope="col"><?= $this->Paginator->sort('username') ?></th>
			<th scope="col"><?= $this->Paginator->sort('comment') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($bidratings_paginate as $bidrating) : ?>
			<tr>
				<td><?= h($bidrating->bidinfo->biditem->name) ?></td>
				<td><?= h($bidrating['rate_user']->username) ?></td>
				<td><?= h($bidrating->comment) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->first('<< ' . __('first')) ?>
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('next') . ' >') ?>
		<?= $this->Paginator->last(__('last') . ' >>') ?>
	</ul>
</div>
