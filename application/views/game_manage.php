<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  </head>
  <body>
    <h1>ゲーム管理画面</h1>
    <?php if ($game_start_error > 0) { ?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<strong>ゲームがスタートできませんでした(<?php echo $game_start_error?>)</strong>
		</div>
	<?php } ?>
	<?php if ($game_start_success) { ?>
		<div class="alert alert-info alert-dismissible fade in" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<strong>ゲームがスタートしました！</strong>
		</div>
	<?php } ?>

    <div>
      <dl>
        <dt>現在のステータス</dt>
        <dd>
          <?php if ($now_game_id == 0) { ?>
            開催していません
          <?php }else {?>
            <?php if ($game) {?>
                現在のゲームIDは「<?php echo $game->game_id?>」、ターンは<?php $game->game_now_turn_number?>ターン目です。<br>
            <?php } ?>
            <?php if ($parent) { ?>
            	親は<?php echo html_escape($parent->cus_name)?>さんです。<br>
            <?php } ?>
            <?php if ($catalog) { ?>
            	カタログは<?php echo html_escape($catalog->cl_name)?>です。<br>
            <?php } ?>
          <?php }?>
        </dd>
        <dt>現在の参加者</dt>
        <dd>
        </dd>
      </dl>
    </div>
    <?php if ($now_game_id == 0) { ?>
      <a class="btn btn-default btn-lg btn-block" href="<?php echo site_url('game/start')?>" role="button">ゲームを開始する</a>
    <?php } else { ?>
      <a class="btn btn-default btn-lg btn-block" href="<?php echo site_url('game/nextgame')?>" role="button">ゲームをすすめる</a>
    <?php } ?>
    <a class="btn btn-default btn-lg btn-block" href="<?php echo site_url('examples/customers_management')?>" role="button">データを確認する</a>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>