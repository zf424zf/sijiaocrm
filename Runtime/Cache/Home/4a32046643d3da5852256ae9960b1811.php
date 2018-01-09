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
        <div class="schedule" style="height: 120px;">
            <div class="schedule_img"><img src="/Public/Mobile/img/youyong.png"></div>
            <div class="schedule_detail">
                <div><span class="schedule_title"><?php echo ($data["title"]); ?></span><span class="schedule_num">（<?php echo ($data["num_min"]); ?>-<?php echo ($data["num_max"]); ?>人）</span></div>
                <div><?php echo ($data["startdate"]); ?> - <?php echo ($data["enddate"]); ?></div>
                <div>周<?php echo ($data["weekinfo"]); ?></div>
                <div><?php echo ($data["nums"]); ?>课时 <?php echo ($data["content"]); ?></div>
                <div>
                    上课时段：<?php echo ($data["hour_s"]); ?>-<?php echo ($data["hour_e"]); ?>
                </div>
            </div>
        </div>

        <div class="userinfo">
            <ul>
                <li>学员姓名：<input type="text" name="name" placeholder="请输入学员姓名"></li>
                <li class="userinfo_sex">
                    <span>学员性别：</span>
                    <div class="userinfo_sex_select">
                        <div class="userinfo_sex_female" id="1">女</div>
                        <div class="userinfo_sex_male sex_sel" id="0">男</div>
                    </div>
                    <input type="hidden" name="sex" id="sex" value="0">
                </li>
                <li>出生年月：
                    <select name="birth_year">
                        <?php if(is_array($birth_year)): $i = 0; $__LIST__ = $birth_year;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>&nbsp;年&nbsp;
                    <select name="birth_month">
                        <?php if(is_array($birth_month)): $i = 0; $__LIST__ = $birth_month;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>&nbsp;月
                </li>
                <li>联系电话：<input type="text" name="phone" placeholder="请输入联系电话"></li>
                <li class="userinfo_level"><span>学员水平：</span>
                    <span><div id="level_1" style="background-color: #24B25C;">√</div>&nbsp;初学</span>
                    <span><div id="level_2">√</div>&nbsp;提高</span>
                </li>
            </ul>
        </div>

        <input type="hidden" name="mark" id="mark" value="level_1">

        <div class="schedule_confirm_order">
            <div class="confirm_amount">
                <span style="float: left; padding-left: 8px;">费用：</span>
                <span><div id="amount_<?php echo ($data["amount"]); ?>">√</div>&nbsp;<span class="confirm_price">￥<?php echo ($data["amount"]); ?></span><span class="confirm_times">首次</span></span>
                <?php if($data["amount_follow"] > 0): ?><span><div id="amount_<?php echo ($data["amount_follow"]); ?>">√</div>&nbsp;<span class="confirm_price">￥<?php echo ($data["amount_follow"]); ?></span><span class="confirm_times">续班</span></span><?php endif; ?>
                <input type="hidden" name="amount" id="amount">
            </div>
            <div class="confirm_btn"><div>确认报名</div></div>
        </div>
    </div>

    <script>
        $(function(){
            $(".userinfo_sex_select div").on('click', function(){
                var sex = $("#sex").val();
                var sel = $(this).attr('id');
                if(sex != sel){
                    $("#sex").val(sel);
                    if(sel == 0){
                        $(".userinfo_sex_male").attr("class","userinfo_sex_male sex_sel");
                        $(".userinfo_sex_female").attr("class","userinfo_sex_female unsex_sel");
                    }else if(sel == 1){
                        $(".userinfo_sex_female").attr("class","userinfo_sex_female sex_sel");
                        $(".userinfo_sex_male").attr("class","userinfo_sex_male unsex_sel");
                    }
                }
            });

            $(".userinfo_level div").on('click',function(){
                $(".userinfo_level div").css("backgroundColor","#F4F4F4");
                $(this).css("backgroundColor","#24B25C");
                var id = $(this).attr("id");
                if(id == "level_1"){
                    $("#mark").val('初学');
                }else if(id == "level_2"){
                    $("#mark").val('提高');
                }
            });

            $(".confirm_btn div").on('click',function(){
                if($("input[name='name']").val() == ''){
                    alert("学员姓名不能为空");
                    return;
                }
                if($("input[name='phone']").val() == ''){
                    alert("联系电话不能为空");
                    return;
                }else if(!isPhoneNo($("input[name='phone']").val())){
                    alert("手机号码输入错误");
                    return;
                }
            });
        })
        // 验证手机号
        function isPhoneNo(phone) {
            var pattern = /^1[34578]\d{9}$/;
            return pattern.test(phone);
        }
    </script>

	<!-- /主体 -->

    <!-- 底部 -->
    
<script>window.jQuery || document.write('<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
<script src="/Public/Mobile/js/vendor/html5shiv.min.js"></script>
</script>
    <!-- /底部 -->
</body>
</html>