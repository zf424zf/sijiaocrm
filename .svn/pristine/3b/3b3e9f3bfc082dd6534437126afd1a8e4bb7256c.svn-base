<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wxca9f8b3aca843c06';
	//受理商ID，身份标识
	const MCHID = '1490319682';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = '6Pn7vmIz9Mb05V8so2B4IDenL1uQ3h6r';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '2c9c5a83411668bb86aa7416405b5d4e';



    /*const APPID = 'wxc3dcf04341b7c5ad';
    //受理商ID，身份标识
    const MCHID = '1245194802';
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    const KEY = 'QiBzIDeRVIzVMnngvmhxrisoPPqtbjJJ';
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    const APPSECRET = 'f63c4b97f2c47a2ec6bccc0a8dffab1b';*/



	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = 'http://crm_api.24parking.com.cn/index.php/Mobile/OAuth/wxCode';
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = '/var/www/train/Application/Mobile/ORG/WxPay/cert/apiclient_cert.pem';
	const SSLKEY_PATH = '/var/www/train/Application/Mobile/ORG/WxPay/cert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://crm_api.24parking.com.cn/index.php/Mobile/WxPay/notify';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}
	
?>