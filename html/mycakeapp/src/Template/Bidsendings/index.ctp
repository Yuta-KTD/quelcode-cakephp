<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidsending[]|\Cake\Collection\CollectionInterface $bidsendings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bidsending'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bidsendings index large-9 medium-8 columns content">
    <h3><?= __('Bidsendings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bidinfo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_sent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bidsendings as $bidsending): ?>
            <tr>
                <td><?= $this->Number->format($bidsending->id) ?></td>
                <td><?= $this->Number->format($bidsending->bidinfo_id) ?></td>
                <td><?= h($bidsending->name) ?></td>
                <td><?= h($bidsending->address) ?></td>
                <td><?= h($bidsending->phone_number) ?></td>
                <td><?= h($bidsending->is_sent) ?></td>
                <td><?= h($bidsending->is_received) ?></td>
                <td><?= h($bidsending->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bidsending->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bidsending->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bidsending->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidsending->id)]) ?>
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
