<h2>「<?= $bidinfo->biditem->name ?>」の配送・受取</h2>
<?php
//落札者のみに(出品者から見て)発送先入力フォーム表示
if ($login_user_id === $receive_user_id) :
?>
    <?php if (is_null($bidsending_info)) : ?>
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
    <?php else : ?>
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
        elseif (($bidsending_info->is_sent) === true && ($bidsending_info->is_received) === true) :
        ?>
            <!-- 評価 -->
            <?//= $this->Html->link(__('出品者評価'), ['action' => 'rating', $bidinfo->id]) ?>

            <a href="<?= $this->Url->build(['controller' => 'Bidratings', 'action' => 'add', $bidinfo->id]); ?>">出品者評価</a>


        <?php endif; ?>
    <?php endif; ?>
<?php
elseif ($login_user_id === $sent_user_id) :
    //出品者にのみ配送完了ボタンを表示
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
    <!-- 配送完了ボタン -->
    <?php
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
    elseif (($bidsending_info->is_sent) === true && ($bidsending_info->is_received) === true) :
    ?>
        <!-- 評価ボタン -->
        <a href="<?= $this->Url->build(['controller' => 'Bidratings', 'action' => 'add', $bidinfo->id]); ?>">落札者評価</a>
        <?//= $this->Html->link(__('落札者評価'), ['action' => 'rating', $bidinfo->id]) ?>

    <?php
    endif;
    ?>
<?php
endif;
?>
