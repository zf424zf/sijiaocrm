<?php
namespace Mobile\Controller;
use OT\DataDictionary;
use Think\Log;
/**
 * 微信处理类
 * Class WeiXinAction
 */
class WeiXinController extends MobileController
{

    public function index()
    {
    }

    /**
     * 封装可以返回微信返回的错误
     * @param $wechat
     * @param $data
     */
    private function wxRetJson($wechat, $data)
    {
        if (empty($data)) {
            $this->retJson($wechat->errMsg, $wechat->errCode);
        } else {
            $this->retJson($data, 200);
        }
    }

    /**
     * 获取微信AccessToken 必须是白名单中的IP地址才可以通过
     */
//    public function getAccessToken()
//    {
//        $Wechat = $this->getWechat();
//        $accessToken = $Wechat->checkAuth();
//        $this->wxRetJson($Wechat, $accessToken);
//    }

    /**
     * 获取 JsApi 使用签名
     */
    public function getJsSign()
    {
        $url = $_GET['url'];
        $this->checkEmpty($url, '链接地址！');
        $Wechat = $this->getWechat();
        $signPackage = $Wechat->getJsSign($url);
        $this->wxRetJson($Wechat, $signPackage);
    }

    /**
     * 获取 JsTicket
     */
    public function getJsTicket()
    {
        $Wechat = $this->getWechat();
        $jsTicket = $Wechat->getJsTicket();
        $this->wxRetJson($Wechat, $jsTicket);
    }
}