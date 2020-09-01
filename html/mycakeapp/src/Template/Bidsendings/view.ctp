<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidsending $bidsending
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bidsending'), ['action' => 'edit', $bidsending->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bidsending'), ['action' => 'delete', $bidsending->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidsending->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bidsendings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bidsending'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bidsendings view large-9 medium-8 columns content">
    <h3><?= h($bidsending->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($bidsending->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($bidsending->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone Number') ?></th>
            <td><?= h($bidsending->phone_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bidsending->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bidinfo Id') ?></th>
            <td><?= $this->Number->format($bidsending->bidinfo_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($bidsending->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Sent') ?></th>
            <td><?= $bidsending->is_sent ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Received') ?></th>
            <td><?= $bidsending->is_received ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
