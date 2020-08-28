<h2>「<?= $bidinfo->biditem->name ?>」の配送・受取</h2>
<?php
//落札者の側の画面
if ($login_user_id === $receive_user_id) :
?>
    <?php
    //受取先情報を入力するフォーム作成
    if (is_null($bidsending_info)) :
    ?>
        <?= $this->Form->create($bidsending) ?>
        <fieldset>
            <legend>※商品の受け取り先情報を入力：</legend>
            <?php
            echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo['id']]);
            echo '<p><strong>USER: ' . $authuser['username'] . '</strong></p>';
            echo "宛名";
            echo $this->Form->control('name');
            echo "住所";
            echo $this->Form->control('address');
            echo "電話番号";
            echo $this->Form->control('phone_number');
            echo $this->Form->hidden('is_sent', ['value' => 0]);
            echo $this->Form->hidden('is_received', ['value' => 0]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit', ['name' => 'save_all'])) ?>
        <?= $this->Form->end() ?>
    <?php
    //受取先入力後の処理
    else :
    ?>
        <!--配送先の表示-->
        <h3><?= $bidinfo->user->username . '様の配送先情報' ?></h3>
        <table class="vertical-table">
            <tr>
                <th scope="row">宛名</th>
                <td><?= h($bidsending_info->name) ?></td>
            </tr>
            <tr>
                <th scope="row">住所</th>
                <td><?= $bidsending_info->address ?></td>
            </tr>
            <tr>
                <th scope="row">電話番号</th>
                <td><?= h($bidsending_info->phone_number) ?></td>
            </tr>
        </table>
        <?php
        //受取完了ボタン入力画面
        if (($bidsending_info->is_sent) === true && ($bidsending_info->is_received) === false) :
        ?>
            <?= $this->Form->create($bidsending) ?>
            <?php
            echo $this->Form->hidden('id', ['value' => $bidsending_info['id']]);
            echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo['id']]);
            echo $this->Form->hidden('name', ['value' => $bidsending_info['name']]);
            echo $this->Form->hidden('address', ['value' => $bidsending_info['address']]);
            echo $this->Form->hidden('phone_number', ['value' => $bidsending_info['phone_number']]);
            echo $this->Form->hidden('is_sent', ['value' => $bidsending_info['is_sent']]);
            echo '受取済みの場合はチェックをつけて「受取完了」ボタンを押してください。';
            echo $this->Form->control('is_received', ['value' => true]);
            ?>
            <?= $this->Form->button(__('受取完了')) ?>
            <?= $this->Form->end() ?>
        <?php
        //受取完了後の取引相手評価フォーム表示
        elseif (($bidsending_info->is_sent) === true && ($bidsending_info->is_received) === true) :
        ?>
            <a href="<?= $this->Url->build(['controller' => 'Bidratings', 'action' => 'add', $bidinfo->id]); ?>">[出品者を評価する]</a>
        <?php endif; ?>
    <?php endif; ?>
<?php
//出品者にのみ配送完了ボタンを表示
elseif ($login_user_id === $sent_user_id) :
?>
    <h3><?= $bidinfo->user->username . '様の配送先情報' ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row">宛名</th>
            <td><?= h($bidsending_info->name) ?></td>
        </tr>
        <tr>
            <th scope="row">住所</th>
            <td><?= $bidsending_info->address ?></td>
        </tr>
        <tr>
            <th scope="row">電話番号</th>
            <td><?= h($bidsending_info->phone_number) ?></td>
        </tr>
    </table>
    <?php
    //配送完了ボタン入力画面
    if (($bidsending_info->is_sent) === false && ($bidsending_info->is_received) === false) :
    ?>
        <?= $this->Form->create($bidsending) ?>
        <?php
        echo $this->Form->hidden('id', ['value' => $bidsending_info['id']]);
        echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo['id']]);
        echo $this->Form->hidden('name', ['value' => $bidsending_info['name']]);
        echo $this->Form->hidden('address', ['value' => $bidsending_info['address']]);
        echo $this->Form->hidden('phone_number', ['value' => $bidsending_info['phone_number']]);
        echo $this->Form->hidden('is_received', ['value' => 0]);
        echo '配送済みの場合はチェックをつけて「配送完了」ボタンを押してください。';
        echo $this->Form->control('is_sent', ['hiddenField' => false, 'value' => true]);
        ?>
        <?= $this->Form->button(__('配送完了', ['name' => 'save_sent'])) ?>
        <?= $this->Form->end() ?>
    <?php
    //評価画面へ
    elseif (($bidsending_info->is_sent) === true && ($bidsending_info->is_received) === true) :
    ?>
        <a href="<?= $this->Url->build(['controller' => 'Bidratings', 'action' => 'add', $bidinfo->id]); ?>">[落札者を評価する]</a>
    <?php
    endif;
    ?>
<?php
endif;
?>
