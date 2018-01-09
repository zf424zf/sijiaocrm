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

    <style>
        .schedule{float: left; height: auto; width: 100%; padding: 0; padding-top: 8px;}
    </style>
    <div style="position: relative;">
        <ul style="margin: 0; padding: 0;">
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="list-style: none;">
                <div class="schedule">
                    <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"><br/><?php echo ($vo["classtype"]); ?></div>
                    <div class="schedule_detail">
                        <div><span class="schedule_title"><?php echo ($vo["title"]); ?></span><span class="schedule_num">（<?php if($vo['num_min'] == $vo['num_max']): echo ($vo["num_min"]); else: echo ($vo["num_min"]); ?>-<?php echo ($vo["num_max"]); endif; ?>人）</span><span style="float: right; color: #EE4236"><span style="color: #949597; font-size: 14px; padding-right: 5px;"><?php if($vo["type"] == 1): ?>续班<?php endif; ?></span>￥<?php echo ($vo["realamount"]); ?></span></div>
                        <div>编号：<span style="font-weight: bold;"><?php echo ($vo["number"]); ?></span></div>
                        <div>课次：<?php echo ($vo["nums"]); ?>次课&nbsp;&nbsp;<?php echo ($vo["weekinfo"]); ?>&nbsp;&nbsp;<?php echo ($vo["hour_s"]); ?>-<?php echo ($vo["hour_e"]); ?></div>
                        <div>开课：<?php echo ($vo["startdate"]); ?></div>
                        <div>招生：<?php echo ($vo["students"]); ?></div>
                        <div>备注：<?php echo ($vo["mark"]); ?></div>
                        <?php if($vo["status"] > 0): ?><div>体验券：<?php if($vo["isget"] == 0): ?>未领取（请至体育馆前台领取）<?php else: ?>已领取<?php endif; ?></div><?php endif; ?>
                        <div style="border-top: solid 1px #BDBEC0; margin-top: 6px; padding-top: 6px;">
                            <?php if($vo["status"] == 0): ?><div class="order_status_nopay"><a href="/index.php/Mobile/Order/confirm/?number=<?php echo ($vo["number"]); ?>">去支付</a></div>
                                <?php elseif($vo["status"] == 1): ?>
                                <div class="order_status_payed">开课中</div>
                                <?php elseif($vo["status"] == 2): ?>
                                <div class="order_status_payed">待开课</div><?php endif; ?>
                            学生：<?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php if($vo["sex"] == 0): ?>男<?php else: ?>女<?php endif; ?>&nbsp;&nbsp;<?php echo ($vo["birthinfo"]); ?><br/>
                            电话：<?php echo ($vo["phone"]); ?>
                        </div>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>

	<!-- /主体 -->

    <!-- 底部 -->
    
<script>window.jQuery || document.write('<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
<script src="/Public/Mobile/js/vendor/html5shiv.min.js"></script>
</script>
    <!-- /底部 -->
</body>
</html>