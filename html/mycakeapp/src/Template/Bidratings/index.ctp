<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidrating[]|\Cake\Collection\CollectionInterface $bidratings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bidrating'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bidinfo'), ['controller' => 'Bidinfo', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bidinfo'), ['controller' => 'Bidinfo', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bidratings index large-9 medium-8 columns content">
    <h3><?= __('Bidratings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bidinfo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_rated_user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rating') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bidratings as $bidrating) : ?>
                <tr>
                    <td><?= $this->Number->format($bidrating->id) ?></td>
                    <td><?= $bidrating->has('bidinfo') ? $this->Html->link($bidrating->bidinfo->id, ['controller' => 'Bidinfo', 'action' => 'view', $bidrating->bidinfo->id]) : '' ?></td>
                    <td><?= $this->Number->format($bidrating->rate_user_id) ?></td>
                    <td><?= $bidrating->has('user') ? $this->Html->link($bidrating->user->id, ['controller' => 'Users', 'action' => 'view', $bidrating->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($bidrating->rating) ?></td>
                    <td><?= h($bidrating->comment) ?></td>
                    <td><?= h($bidrating->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bidrating->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bidrating->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bidrating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidrating->id)]) ?>
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
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
