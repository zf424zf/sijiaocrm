<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
 */
include_once("../WxPayPubHelper.php");

//使用jsapi接口
$jsApi = new JsApi_pub();

//=========步骤1：网页授权获取用户openid============
$openid = 'oteIUs7tB_WmV61GSmSBLbLbthk4';
//=========步骤2：使用统一支付接口，获取prepay_id============
//使用统一支付接口
$unifiedOrder = new UnifiedOrder_pub();

//设置统一支付接口参数
//设置必填参数
//appid已填,商户无需重复填写
//mch_id已填,商户无需重复填写
//noncestr已填,商户无需重复填写
//spbill_create_ip已填,商户无需重复填写
//sign已填,商户无需重复填写
$unifiedOrder->setParameter("openid", "$openid");//商品描述
$unifiedOrder->setParameter("body", "贡献一分钱");//商品描述
//自定义订单号，此处仅作举例
$timeStamp = time();
$out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
$unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
$unifiedOrder->setParameter("total_fee", "1");//总金额
$unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL);//通知地址
$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
//非必填参数，商户可根据实际情况选填
//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
//$unifiedOrder->setParameter("device_info","XXXX");//设备号
//$unifiedOrder->setParameter("attach","XXXX");//附加数据
//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
//$unifiedOrder->setParameter("openid","XXXX");//用户标识
//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

$prepay_id = $unifiedOrder->getPrepayId();
//=========步骤3：使用jsapi调起支付============
$jsApi->setPrepayId($prepay_id);

$jsApiParameters = $jsApi->getParameters();
//echo $jsApiParameters;
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '', // 必填，公众号的唯一标识
            timestamp:, // 必填，生成签名的时间戳
            nonceStr: '', // 必填，生成签名的随机串
            signature: '',// 必填，签名，见附录1
            jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        //调用微信JS api 支付
        function jsApiCall() {
            wx.chooseWXPay({
                timestamp: <?php echo $jsApiParameters['timeStamp'];?>, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                nonceStr: '<?php echo $jsApiParameters['nonceStr'];?>', // 支付签名随机串，不长于 32 位
                package: '<?php echo $jsApiParameters['package'];?>', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                paySign: '<?php echo $jsApiParameters['paySign'];?>', // 支付签名
                success: function (res) {
                    // 支付成功后的回调函数
                    alert(res);
                }
            });
        }

        function callpay() {
            jsApiCall();
        }
    </script>
</head>
<body>
</br></br></br></br>
<div align="center">
    <button
        style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
        type="button" onclick="callpay()">贡献一下
    </button>
</div>
</body>
</html>