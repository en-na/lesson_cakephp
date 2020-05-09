<h2>「<?=$biditem->name ?> 」の情報</h2>
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
	<th scope="row">商品説明</th>
	<td><?= h($biditem->description) ?></td>
</tr>
<tr>
    <th scope="row">商品画像</th>
	<td><?= $this->Html->image($biditem->image, array('height' => 150, 'width' => 150)) ?></td>
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
<tr>
	<th scope="row"><?= __('終了した？') ?></th>
	<td><?= $biditem->finished ? __('Yes') : __('No'); ?></td>
</tr>
</table>

<!-- 以下カウントダウンタイマーのコード -->

<?php if ($biditem->finished == 0 && new \DateTime('now') < $biditem->endtime): ?>
    <p>終了まで残り
        <span id="days"></span>日
        <span id="hours"></span>時間
        <span id="minutes"></span>分
        <span id="seconds"></span>秒
    </p>
<?php endif; ?>
    
<script>
function getResult() {
        var endTime = new Date("<?= h($biditem->endtime) ?>");
        var now = Date.now()
        var diff = (endTime - now) / 1000;

        var d = Math.floor(diff / 60 / 60 / 24);
        diff = diff - 60 * 60 * 24 * d;
        var h = Math.floor(diff / 60 / 60);
        diff = diff - 60 * 60 * h;
        var m = Math.floor(diff / 60);
        diff = diff - 60 * m;
        var s = Math.floor(diff);

        document.getElementById('days').innerHTML = d;
        document.getElementById('hours').innerHTML = h;
        document.getElementById('minutes').innerHTML = m;
        document.getElementById('seconds').innerHTML = s;

        setTimeout(function() {
            getResult();
        }, 200);
    }
    getResult();
</script>

<!-- 以上カウントダウンタイマーのコード -->

<div class="related">
	<h4><?= __('落札情報') ?></h4>
	<?php if (!empty($biditem->bidinfo)): ?>
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
	<?php else: ?>
	<p><?='※落札情報は、ありません。' ?></p>
	<?php endif; ?>
</div>
<div class="related">
	<h4><?= __('入札情報') ?></h4>
	<?php if (!$biditem->finished): ?>
	<h6><a href="<?=$this->Url->build(['action'=>'bid', $biditem->id]) ?>">《入札する！》</a></h6>
	<?php if (!empty($bidrequests)): ?>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th scope="col">入札者</th>
		<th scope="col">金額</th>
		<th scope="col">入札日時</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bidrequests as $bidrequest): ?>
	<tr>
		<td><?= h($bidrequest->user->username) ?></td>
		<td><?= h($bidrequest->price) ?>円</td>
		<td><?=$bidrequest->created ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php else: ?>
	<p><?='※入札は、まだありません。' ?></p>
	<?php endif; ?>
	<?php else: ?>
	<p><?='※入札は、終了しました。' ?></p>
	<?php endif; ?>
</div>