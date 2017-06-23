<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>MyPage</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  </head>
  <body>

    <h1><?php echo html_escape($my->cus_name)?>さん参加ありがとうございます</h1>
    <div>
      <dl>
        <dt>現在のステイタス</dt>
        <dd>
        <?php if ($now_game_id == 0) {?>
            現在開催待ちです。<br>
            しばらくお待ち下さい。
        <?php } else { ?>
            <?php if ($game) {?>
                現在のゲームIDは「<?php echo $game->game_id?>」、ターンは<?php $game->game_now_turn_number?>ターン目です。<br>
            <?php } ?>
            <?php if ($parent) { ?>
            	親は<?php echo html_escape($parent->cus_name)?>さんです。<br>
            <?php } ?>
            <?php if ($catalog) { ?>
            	カタログは<?php echo html_escape($catalog->cl_name)?>です。<br>
            <?php } ?>
        <?php } ?>
        </dd>
      </dl>
    </div>

    <a class="btn btn-default btn-lg btn-block" href="<?php echo site_url('top/mypage')?>" role="button">更新する</a>

    <h2>あなたの情報</h2>
    <div>
    	<dl class="dl-horizontal">
    		<dt>お名前</dt>
  			<dd><?php echo html_escape($my->cus_name)?></dd>
  			<dt>再ログインurl</dt>
  			<dd><a><?php echo site_url('top/login')?>/<?php echo html_escape($my->cus_id)?></a></dd>
		</dl>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>