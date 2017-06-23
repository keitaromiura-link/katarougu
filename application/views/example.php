<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
	<div>
		<a href='<?php echo site_url('game/manage')?>'>ゲーム管理</a> |
		<a href='<?php echo site_url('examples/customers_management')?>'>参加者</a> |
		<a href='<?php echo site_url('examples/catalog_management')?>'>カタログ</a> |
		<a href='<?php echo site_url('examples/catalog_item_management')?>'>カタログ品</a> |
		<a href='<?php echo site_url('examples/game')?>'>ゲーム</a> |
		<a href='<?php echo site_url('examples/turn')?>'>ターン</a> |
	</div>
	<div style='height:20px;'></div>
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
