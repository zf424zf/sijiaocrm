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
        <div class="schedule">
            <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"><br/><?php echo ($data["classtype"]); ?></div>
            <div class="schedule_detail">
                <div><span class="schedule_title"><?php echo ($data["title"]); ?></span><span class="schedule_num">（<?php echo ($data["count"]); ?>个名额）</span></div>
                <div>课次：<?php echo ($data["nums"]); ?>次课&nbsp;&nbsp;</div>
                <div>开课：<?php echo ($data["startdate"]); ?></div>
                <div>招生：<?php echo ($data["students"]); ?></div>
                <div>备注：<?php echo ($data["mark"]); ?></div>
            </div>
        </div>
        <div class="schedule_select">选择时间段：</div>
        <div class="schedule_times">
            <ul>
                <?php if(is_array($datelist)): $i = 0; $__LIST__ = $datelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="<?php echo ($vo["id"]); ?>">
                    <span class="schedule_hidden_num"><?php echo ($vo["num"]); ?></span>
                    <span class="schedule_isbook"><?php echo ($vo["isbook"]); ?></span>
                    <span style="float: left;"><span class="schedule_li_week"><?php echo ($vo["weekinfo"]); ?></span><br/><?php echo ($vo["startdate"]); ?>开班</span>
                    <span style="float: left; padding-left: 30px;">
                        <span class="schedule_li_times"><?php echo ($vo["hour_s"]); ?>-<?php echo ($vo["hour_e"]); ?></span><br/>
                        <?php if($vo["num"] == 0): ?>已满
                        <?php else: ?>
                            <?php if($vo["isbook"] == 1): ?>已报名
                            <?php else: ?>
                                剩余名额：<span class="schedule_li_nums"><?php echo ($vo["num"]); ?></span><?php endif; endif; ?>
                    </span>

                    <div style="<?php if($vo["num"] == 0 OR $vo["isbook"] == 1): ?>border-color:#949599;<?php endif; ?> font-family:'宋体';">√</div>
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
                var isbook = $(this).find(".schedule_isbook").html();
                if(isbook == 1){
                    return false;
                }
                var sel_id = $("#sel_id").val();
                var id = $(this).attr('id');

                $(".schedule_times ul li").find(".schedule_li_times").css({'color':'#58595B'});
                $(".schedule_times ul li").find(".schedule_li_week").css({'color':'#58595B'});
                $(".schedule_times ul li").find("div").css({'backgroundColor':'white'});
                $("#sel_id").val('');

                if(sel_id == '' || sel_id != id){
                    $("#sel_id").val(id);
                    $(this).find(".schedule_li_times").css({'color':'#24B25C'});
                    $(this).find(".schedule_li_week").css({'color':'#24B25C'});
                    $(this).find("div").css({'backgroundColor':'#24B25C'});
                }
            })

            $(".schedule_order div").on("touchstart",function(){
                var sel_id = $("#sel_id").val();
                if(sel_id > 0){
                    window.location.href = "/Mobile/Schedule/scheduleconfirm/id/" + sel_id;
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