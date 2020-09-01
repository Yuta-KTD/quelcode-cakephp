<?php

use function PHPSTORM_META\type;
?>
<h2><?= h($bidinfo->biditem->name) ?>の取引における評価を入力</h2>
<?= $this->Form->create($bidrating) ?>
<fieldset>
    <legend>※評価とコメントを入力：</legend>

    <?php
    echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo['id']]);
    echo $this->Form->hidden('rate_user_id', ['value' => $authuser['id']]);
    //「評価をうける」ユーザーを識別する
    if ($login_user_id === $bidinfo['user_id']) {
        echo $this->Form->hidden('is_rated_user_id', ['value' => $bidinfo->biditem['user_id']]);
    } elseif ($login_user_id === $bidinfo->biditem['user_id']) {
        echo $this->Form->hidden('is_rated_user_id', ['value' => $bidinfo['user_id']]);
    }
    echo '<p><strong>USER: ' . $authuser['username'] . '</strong></p>';
    echo '1（低）〜 5（高）の5段階評価';
    echo $this->Form->control('rating');
    echo 'コメント（1000文字以内）';
    echo $this->Form->textarea('comment');

    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
