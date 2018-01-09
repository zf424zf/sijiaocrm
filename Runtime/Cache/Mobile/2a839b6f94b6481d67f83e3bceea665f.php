<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录</title>

    <link href="/Public/Front/css/ui-base.css" type="text/css" rel="stylesheet">
    <link href="/Public/Front/css/common.css" type="text/css" rel="stylesheet">

    <script src="/Public/Front/js/vendor/jquery-1.9.0.min.js" type="text/javascript"></script>

</head>

<body style="position: fixed;">
<div class="login p_a_v p_a_c">
    <div class="inner-bg p_a_v p_a_c">
        <p class="login-logo"><img src="/Public/Front/img/login-logo.png" /></p>
        <div class="login-type clearfix">
            <!--刷卡登录 begin-->
            <div class="swipe-pos">
                <p class="name">刷卡登录</p>
                <div class="pos-area"><img src="/Public/Front/img/pos.png" /><p class="txt">可刷卡直接登录</p></div>
            </div>
            <!--刷卡登录 end-->
            <!--用户名登录 begin-->
            <div class="user-name-login">
                <p class="name">用户名登录</p>
                <form action="<?php echo U('/Mobile/Front/login');?>" name="form1" method="post">
                    <div class="enter">
                        <input type="text" name="username" class="input un" placeholder="请输入用户名" />
                        <input type="password" name="password" class="input psw" placeholder="请输入密码" />
                        <p class="t_r"><a class="forget" onclick="alert('请联系管理员')">忘记密码？</a></p>
                        <button class="login-btn">登录</button>
                    </div>
                </form>
            </div>
            <!--用户名登录 end-->
        </div>

    </div>
    <img src="/Public/Front/img/logo.png" class="hsb-logo" />

</div>

</body>
</html>