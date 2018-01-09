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

    <div class="schedule_mark" style="position: fixed; top: 0px; width: 100%;"><a href="<?php echo U('/Mobile/Schedule/notice');?>" style="color: red; font-weight: bold;">报名须知&nbsp;&nbsp;</a></div>
    <div class="classtype" style="margin-top: 41px;">
        <ul>
            <?php if(is_array($classtype)): $i = 0; $__LIST__ = $classtype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="classtype_<?php echo ($vo["id"]); ?>" <?php if($i == 1): ?>class="on"<?php endif; ?>><?php echo ($vo["classtype"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="my-schedule" style="margin-top: 41px;">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvo): $mod = ($i % 2 );++$i;?><ul id="schedule_<?php echo ($key); ?>" <?php if($i > 1): ?>style="display:none;"<?php endif; ?>>
            <?php if(is_array($vvo)): $i = 0; $__LIST__ = $vvo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"></div>
                <div class="schedule_detail">
                    <div><span class="schedule_title"><?php echo ($vo["title"]); ?></span><span class="schedule_num">（剩余<?php echo ($vo["count"]); ?>个名额）</span></div>
                    <div>课次：<?php echo ($vo["nums"]); ?>次课&nbsp;&nbsp;</div>
                    <div>开课：<?php echo ($vo["startdate"]); ?></div>
                    <div>招生：<?php echo ($vo["students"]); ?></div>
                    <div>备注：<?php echo ($vo["mark"]); ?></div>
                    <div class="schedule_amount">
                        <div style="float: left;">
                        <?php if($vo["type"] == 1): ?>首次￥<?php echo ($vo["amount"]); ?>&nbsp;&nbsp;续班￥<?php echo ($vo["amount_follow"]); ?>
                            <?php else: ?>
                            ￥<?php echo ($vo["amount"]); ?><br/><?php endif; ?>
                        </div>
                        <a href="<?php echo U('/Mobile/Schedule/scheduledetail/id/'.$vo['id']);?>"><div class="schedule_sel">选择时间段</div></a>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <script>
        $(function(){
            $(".classtype ul li").on("touchstart",function(){
                $(".classtype ul li").removeClass('on');
                $(this).attr('class','on');

                var id = $(this).attr("id");
                var ids = id.split('_');
                var id = ids[1];
                $(".my-schedule ul").hide();
                $("#schedule_"+id).show();
            });
        })
    </script>

	<!-- /主体 -->

    <!-- 底部 -->
    
<script>window.jQuery || document.write('<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
<script src="/Public/Mobile/js/vendor/html5shiv.min.js"></script>
</script>
    <!-- /底部 -->
</body>
</html>