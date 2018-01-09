<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html>
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo ($title); ?></title>
<meta name="description" content="">
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<link rel="stylesheet" href="/Public/Mobile/css/schedule.css">
<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"></script>
<!--[if lt IE 9]>
<script src="/Public/Mobile/assets/js/html5shiv.js"></script>
<![endif]-->
</head>
<body>
	<!-- 主体 -->
	<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

    <div class="my-schedule">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="schedule">
                <a href="<?php echo U('/Home/Mobile/scheduledetail/id/'.$vo['id']);?>">
                <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"></div>
                <div class="schedule_detail">
                    <div><span class="schedule_title"><?php echo ($vo["title"]); ?></span><span class="schedule_num">（<?php echo ($vo["num_min"]); ?>-<?php echo ($vo["num_max"]); ?>人）</span></div>
                    <div><?php echo ($vo["startdate"]); ?> - <?php echo ($vo["enddate"]); ?></div>
                    <div>周<?php echo ($vo["weekinfo"]); ?></div>
                    <div><?php echo ($vo["nums"]); ?>课时 <?php echo ($vo["content"]); ?></div>
                </div>
                <div class="schedule_amount">
                    <?php if($vo["type"] == 1): ?>首次￥<?php echo ($vo["amount"]); ?><br/>续班￥<?php echo ($vo["amount_follow"]); ?>
                    <?php else: ?>
                        ￥<?php echo ($vo["amount"]); ?><br/><?php endif; ?>
                </div>
                </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

	<!-- /主体 -->

    <!-- 底部 -->
    
<script>window.jQuery || document.write('<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
<script src="/Public/Mobile/js/vendor/html5shiv.min.js"></script>
</script>
    <!-- /底部 -->
</body>
</html>