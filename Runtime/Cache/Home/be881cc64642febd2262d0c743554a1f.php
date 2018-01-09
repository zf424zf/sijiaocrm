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

    <div style="position: relative;">
        <div class="schedule_mark"><a href="#">报名须知</a></div>
        <div class="schedule">
            <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"></div>
            <div class="schedule_detail">
                <div><span class="schedule_title"><?php echo ($data["title"]); ?></span><span class="schedule_num">（<?php echo ($data["num_min"]); ?>-<?php echo ($data["num_max"]); ?>人）</span></div>
                <div><?php echo ($data["startdate"]); ?> - <?php echo ($data["enddate"]); ?></div>
                <div>周<?php echo ($data["weekinfo"]); ?></div>
                <div><?php echo ($data["nums"]); ?>课时 <?php echo ($data["content"]); ?></div>
            </div>
            <div class="schedule_amount">
                <?php if($data["type"] == 1): ?>首次￥<?php echo ($data["amount"]); ?><br/>续班￥<?php echo ($data["amount_follow"]); ?>
                    <?php else: ?>
                    ￥<?php echo ($data["amount"]); ?><br/><?php endif; ?>
            </div>
        </div>
        <div class="schedule_select">选择时间段：</div>
        <div class="schedule_times">
            <ul>
                <?php if(is_array($datelist)): $i = 0; $__LIST__ = $datelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="<?php echo ($vo["id"]); ?>">
                    <span class="schedule_hidden_num"><?php echo ($vo["num"]); ?></span>
                    <span class="schedule_li_times"><?php echo ($vo["hour_s"]); ?>-<?php echo ($vo["hour_e"]); ?></span>
                    <?php if($vo["num"] == 0): ?>已满
                    <?php else: ?>
                        剩余名额：<span class="schedule_li_nums"><?php echo ($vo["num"]); ?></span><?php endif; ?>
                    <div <?php if($vo["num"] == 0): ?>style="border-color:#949599;"<?php endif; ?>>√</div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <input type="hidden" name="sel_id" id="sel_id" value="">

        <div class="schedule_order">
            <div>报&nbsp;&nbsp;名</div>
        </div>
    </div>

    <script>
        $(function(){
            $(".schedule_times ul li").on("click",function(){
                var num = $(this).find(".schedule_hidden_num").html();
                if(num == 0){
                    return false;
                }
                var sel_id = $("#sel_id").val();
                var id = $(this).attr('id');

                $(".schedule_times ul li").find(".schedule_li_times").css({'color':'#58595B'});
                $(".schedule_times ul li").find("div").css({'backgroundColor':'white'});
                $("#sel_id").val('');

                if(sel_id == '' || sel_id != id){
                    $("#sel_id").val(id);
                    $(this).find(".schedule_li_times").css({'color':'#24B25C'});
                    $(this).find("div").css({'backgroundColor':'#24B25C'});
                }
            })

            $(".schedule_order div").on("click",function(){
                var sel_id = $("#sel_id").val();
                if(sel_id > 0){
                    window.location.href = "/Home/Mobile/scheduleconfirm/id/" + sel_id;
                }else{
                    alert('请选择具体时间段');
                }
            })
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