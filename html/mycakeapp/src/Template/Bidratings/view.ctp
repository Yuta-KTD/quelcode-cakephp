<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidrating $bidrating
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bidrating'), ['action' => 'edit', $bidrating->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bidrating'), ['action' => 'delete', $bidrating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidrating->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bidratings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bidrating'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bidinfo'), ['controller' => 'Bidinfo', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bidinfo'), ['controller' => 'Bidinfo', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bidratings view large-9 medium-8 columns content">
    <h3><?= h($bidrating->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bidinfo') ?></th>
            <td><?= $bidrating->has('bidinfo') ? $this->Html->link($bidrating->bidinfo->id, ['controller' => 'Bidinfo', 'action' => 'view', $bidrating->bidinfo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $bidrating->has('user') ? $this->Html->link($bidrating->user->id, ['controller' => 'Users', 'action' => 'view', $bidrating->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($bidrating->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bidrating->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate User Id') ?></th>
            <td><?= $this->Number->format($bidrating->rate_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td><?= $this->Number->format($bidrating->rating) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($bidrating->created) ?></td>
        </tr>
    </table>
</div>
