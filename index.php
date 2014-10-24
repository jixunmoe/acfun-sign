<?php include 'tpl/header.php'; include 'init.php'; ?>
<h1>AcFun 自动签到近况 <small class="pull-right">By Jixun</small></h1>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>用户名</th>
			<th>签到日期</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $db -> query ('SELECT `id`, `user`, `lastSign` from `ac_sign`') as $row) : ?>
			<tr>
				<td><?= $row['id'] 			?></td>
				<td><?= $row['user'] 		?></td>
				<td><?= $row['lastSign'] 	?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php include 'tpl/footer.php'; ?>