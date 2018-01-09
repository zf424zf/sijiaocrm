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
                <div><span class="schedule_title"><?php echo ($data["title"]); ?></span><span class="schedule_num">（<?php if($data['num_min'] == $data['num_max']): echo ($data["num_min"]); else: echo ($data["num_min"]); ?>-<?php echo ($data["num_max"]); endif; ?>人）</span></div>
                <div>课次：<?php echo ($data["nums"]); ?>次课&nbsp;&nbsp;</div>
                <div>开课：<?php echo ($data["startdate"]); ?></div>
                <div>招生：<?php echo ($data["students"]); ?></div>
                <div>备注：<?php echo ($data["mark"]); ?></div>
            </div>
        </div>

        <div class="sel_startdate">
            上课时间段：<span><?php echo ($data["weekinfo"]); ?>&nbsp;&nbsp;<?php echo ($data["hour_s"]); ?>-<?php echo ($data["hour_e"]); ?></span>
        </div>

        <div class="ordermaount">
            <span>学费：</span><span style="float: right; color: #EE4236; font-weight: bold;">￥<?php echo ($amount); ?></span><span style="float: right; color: #58595D; font-size: 14px; padding-right: 5px;"><?php if($type == 0): ?>首次<?php else: ?>续班<?php endif; ?></span>
        </div>

        <div class="reducecode">
            优惠码：<input type="text" name="reducecode" id="reducecode" placeholder="请输入6位优惠码">
            <span class="reducecode_msg"></span>
            <input type="hidden" name="reduceamount" id="reduceamount">
        </div>

        <!--支付方式 begin-->
        <div class="payfor-type" style="margin-bottom: 30px;">
            <p class="title">支付方式</p>
            <ul>
                <li style="display: none;">
                    <a>
                        <i class="ipass-icon"></i>
                        <span>一卡通</span>
                        <font>(余额0元)</font>
                        <i class="radio-btn" id="vipcard"></i>
                    </a>
                </li>
                <li>
                    <a>
                        <i class="wechart-icon"></i>
                        <span>微信支付</span>
                        <i class="radio-btn on" id="wxpay"></i>
                    </a>
                </li>
                <li style="display: none;">
                    <a>
                        <i class="bank-icon"></i>
                        <span>银行卡支付</span>
                        <i class="radio-btn" id="bankcard"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!--支付方式 end-->
        <div style="height: 110px;">&nbsp;</div>
        <div class="schedule_confirm_order">
            <div class="confirm_amount">
                <span style="float: left; padding-left: 8px;">合计费用：</span>
                <span class="confirm_amount_list" style="float: right; padding-right: 8px;"><span class="confirm_price">￥<?php echo ($amount); ?></span></span>
            </div>
            <div class="confirm_btn"><div id="confirm">确认支付</div></div>
        </div>
    </div>

    <input type="hidden" name="number" id="number" value="<?php echo ($number); ?>">
    <input type="hidden" name="amount" id="amount" value="<?php echo ($amount); ?>">
    <input type="hidden" name="timeStamp" id="timeStamp" value="<?php echo ($paypost["timeStamp"]); ?>">
    <input type="hidden" name="nonceStr" id="nonceStr" value="<?php echo ($paypost["nonceStr"]); ?>">
    <input type="hidden" name="packages" id="packages" value="<?php echo ($paypost["package"]); ?>">
    <input type="hidden" name="paySign" id="paySign" value="<?php echo ($paypost["paySign"]); ?>">
    <input type="hidden" name="paystatus" id="paystatus" value="0">

    <script type="text/javascript" language="javascript" src="/Public/Mobile/js/vendor/zepto.min.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/Mobile/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/Mobile/js/pay.js"></script>

    <script type="text/javascript">
        $(function(){
            wxpay();

            $("#reducecode").bind('blur',function(){
                var reducecode = $(this).val();
                var number     = $("#number").val();
                if(reducecode != '' &&( isNaN(reducecode) || reducecode.length != 6)){
                    $(".reducecode_msg").html("请输入6位优惠码").show();
                    return false;
                }else{
                    $(".reducecode_msg").hide();
                }
                $.ajax({
                    url:"<?php echo U('/Mobile/Order/checkreduce');?>",
                    type:'post',
                    datatype:'json',
                    data:{'reducecode':reducecode,'number':number},
                    success:function(data){
                        var result = eval('('+data+')');
                        if(result.status == 200){
                            $("#reduceamount").val(result.reduce);
                            $(".reducecode_msg").html("优惠金额：￥"+result.reduce).show();
                            var amount = $("#amount").val() -  result.reduce;
                            if(parseInt(amount) < 0){
                                amount = 0;
                            }
                            $(".confirm_price").html("￥"+amount);
                        }else if(result.status == 201){
                            $(".reducecode_msg").html("优惠码不存在").show();
                            $(".confirm_price").html("￥"+$("#amount").val());
                        }else if(result.status == 202){
                            $(".reducecode_msg").html('').hide();
                            $(".confirm_price").html("￥"+$("#amount").val());
                        }

                        $("#timeStamp").val(result.paypost.timeStamp);
                        $("#nonceStr").val(result.paypost.nonceStr);
                        $("#packages").val(result.paypost.package);
                        $("#paySign").val(result.paypost.paySign);
                    }
                })
            });

            /*确认支付*/
            $( '#confirm' ).bind( 'touchstart' , function() {
                if($("#paystatus").val() == 1){
                    return false;
                }else{
                    /*var timestamp = Date.parse(new Date()) * 0.001;
                    var timenow   = parseInt($("#ordertime").val());

                    if(timenow + 15 * 60 < timestamp){
                        alert("您已超时15分钟未支付，请重新预定");
                        window.history.go(-1);
                        return false;
                    }*/

                    $("#confirm").html("支付处理中...");
                    $("#paystatus").val(1);
                }

                var paytype = $(".payfor-type").find('.on').attr('id');
                if(paytype == 'vipcard'){
                    $( '.enter-psw' ).show();
                }else if(paytype  == 'wxpay'){
                    jsApiCall();
                }else if(paytype  == 'bankcard'){
                    alert('暂未开通，请使用其他支付方式');
                    $("#confirm").html("确认支付");
                    $("#paystatus").val(0);
                    return false;
                }
            });

            /*选择支付方式*/
            $( '.payfor-type ul li' ).bind( 'touchend' , function() {
                $( this ).find( '.radio-btn' ).addClass( 'on' );
                $( this ).siblings().find( '.radio-btn' ).removeClass( 'on' );
            });

            //输入密码
            var $input = $(".fake-box input");
            $("#pwd-input").on("input", function() {
                var pwd = $(this).val().trim();
                for (var i = 0, len = pwd.length; i < len; i++) {
                    $input.eq("" + i + "").val(pwd[i]);
                }
                $input.each(function() {
                    var index = $(this).index();
                    if (index >= len) {
                        $(this).val("");
                    }
                });
                if (len == 6) {
                    var oid    = $("#oid").val();
                    var number = $("#number").val();
                    var type   = $("#type").val();
                    var param  = {pwd:pwd,oid:oid,number:number,type:type};
                    $.ajax({
                        url:'<?php echo U("/Mobile/Order/payOrderByAjax");?>',
                        type:'post',
                        datatype:'json',
                        data:param,
                        success:function(data){
                            var result = eval("("+data+")");
                            $('.cd-popup').removeClass('is-visible');
                            if(result.status == 200){
                                window.location.href = '<?php echo U("/Mobile/Order/success?amount=".$amount."&number=".$number."&type=".$type);?>';
                            }else{
                                alert(result.msg);
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>

	<!-- /主体 -->

    <!-- 底部 -->
    
<script>window.jQuery || document.write('<script src="/Public/Mobile/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
<script src="/Public/Mobile/js/vendor/html5shiv.min.js"></script>
</script>
    <!-- /底部 -->
</body>
</html>