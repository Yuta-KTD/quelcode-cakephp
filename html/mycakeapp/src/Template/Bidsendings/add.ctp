<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidsending $bidsending
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Bidsendings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="bidsendings form large-9 medium-8 columns content">
    <?= $this->Form->create($bidsending) ?>
    <fieldset>
        <legend><?= __('Add Bidsending') ?></legend>
        <?php
            echo $this->Form->control('bidinfo_id');
            echo $this->Form->control('name');
            echo $this->Form->control('address');
            echo $this->Form->control('phone_number');
            echo $this->Form->control('is_sent');
            echo $this->Form->control('is_received');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
