<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Mobile\Controller;
use Think\Controller;
use Think\Log;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IntefaceController extends Controller {

    public function index()
    {
        /*ob_clean();
        echo($_GET['echostr']);
        exit();*/
        $Wechat = $this->getWechat();

        $revData = $Wechat->getRevData();
        $this->log($revData);
        if (APP_DEBUG) {
            $Wechat->valid();
        }
        //回复变量声明
        $content = null;
        $data = null;
        //信息提示
        $type = $Wechat->getRev()->getRevType();
        $this->log($type, '平台发送类型：');

        //是否首次关注
        $openid = $Wechat->getRevFrom();

        Log::write($type);
        switch ($type) {
            case $Wechat::MSGTYPE_TEXT:
                $content = $Wechat->getRevContent();
                Log::write('文本：'.$openid.',内容：'.$content);
                if ($content == 'openid') {
                    $data = $openid;
                } else {
                    $data = $this->returnText($Wechat, $content);
                }
                break;
            case $Wechat::MSGTYPE_EVENT:
                $event = $Wechat->getRevEvent();
                Log::write('事件：'.json_encode($event));
                $data = $this->returnEvent($Wechat, $event);
                break;
            case $Wechat:: MSGTYPE_VOICE:
                break;
            default:
                Log::write('其他：'.$_GET['echostr']);
                /*Log::write(json_encode(var_dump($Wechat->checkSignature())));
                if($Wechat->checkSignature()){
                    echo($_GET['echostr']);
                    exit();
                }*/
                break;
        }
        //进入信息处理
        if (empty($data) && !empty($content)) {
            $data = $this->helpStr($content);
        }
        //返回给微信
        if (!empty($data)) {
            Log::write('公共平台回复内容：' . json_encode($data));
            if (is_string($data)) {
                $Wechat->text($data)->reply();
            }elseif(!empty($data[0]['PicUrl']) && empty($data[0]['title']) && empty($data[0]['content']) && empty($data[0]['url'])){
                //$result = $Wechat->image("hWsAxXwHFDZGfEO1td7naKcZX5imRPY_uTtoW5fCvTtV9vKgVPymiAbJ7lFAy4G8");
                $result = $Wechat->image("g7cnt4pcMDkUikv-031fvMOxXPyStDfz3GhlwqfQCA8");
                Log::write("wechat_image:".json_encode($result));
                $result->reply();
            }elseif (is_array($data)) {
                $Wechat->news($data)->reply();
            }
        } else {
            //多客服
            $Wechat->transfer_customer_service('xiaozhuomei001')->reply();
        }
    }


    /***
     * 处理文字自动回复
     * @param $content
     */
    private function returnText($Wechat, $content)
    {
        $data = array();
        $revDate = $Wechat->getRevData();
        //$this->addMsg($revDate);

        return $data;
    }

    /**
     * 微信子
     * @param $Wechat
     * @param $event
     */
    public function returnEvent($Wechat, $event)
    {
        $data = '';
        $revDate = $Wechat->getRevData();
        $openId = $Wechat->getRevFrom();
        //根据信息获取
        $eventName = strtolower($event['event']);
        switch ($eventName) {
            case 'subscribe':
                $WeixinUserModel    = D('weixinuser');
                $weixinuser         = $WeixinUserModel->findByOpenid($openId);
                if(empty($weixinuser)){
                    $user['openid']     = $openId;
                    $user['nickname']   = '';
                    $user['headimgurl'] = '';
                    $user['subscribe']  = 1;
                    $user['updatetime'] = time();
                    $flag   = $WeixinUserModel->addOne($user);
                }

                $data = $this->helpStr('关注');//关注后提示消息
                break;
            case 'unsubscribe':
                //接触绑定
                break;
            case 'click':
                $data = $this->helpStr($event['key']);
                break;
            case 'scan':
                //扫描带参数二维码事件  用户已关注时的事件推送
                break;
            case 'location'://上报地理位置事件
                $weixin_user['latitude']  = $revDate['Latitude'];
                $weixin_user['longitude'] = $revDate['Longitude'];
                $flag   = M("weixinUser")->where('openid = "'.$openId.'"')->save($weixin_user);//更新用户地理位置
                Log::write('地理位置：'.json_encode($revDate).'，更新用户位置：'.M()->getLastSql().',结果：'.$flag);
                break;
            default:
                break;
        }
        //记录时间
        //$this->addEvent($eventName, $revDate);
        return $data;
    }


    /**
     * 帮助关键字自动回复
     * @param $content
     * @param $isTo 是否强制不进行查看公共信息
     */
    public function helpStr($content, $isTo = false)
    {
        if (strtoupper($content) == 'HELP' || $content == '帮助') {
            $content = '帮助';
        }
        $map = array();
        $items = array();
        $map['keyword'] = $content;
        $WeixinKeywordModel = M('weixinkeyword');
        $count = $WeixinKeywordModel->where($map)->count();
        if ($count == 1) {
            $help = $WeixinKeywordModel->where($map)->find();
            if (!empty($help)) {
                $item = array();
                if (!empty($help['title']) && $help['type'] == 1) {
                    $item['Title'] = $help['title'];
                    $item['Description'] = $help['content'];
                    $item['PicUrl'] = $help['picUrl'];
                    $item['Url'] = $help['url'];
                    $items[] = $item;
                }elseif(!empty($help['picUrl'])){
                    $item['PicUrl'] = $help['picUrl'];
                    $items[] = $item;
                } else {
                    return $help['content'];
                }
            }
        } else if ($count > 1) {
            $helps = $WeixinKeywordModel->where($map)->limit('10')->order('orders')->select();
            if (!empty($helps)) {
                $item = array();
                foreach ($helps as $help) {
                    if (!empty($help['title'])) {
                        $item['title'] = $help['title'];
                        $item['description'] = $help['content'];
                        $item['pic'] = $help['picUrl'];
                        $item['url'] = $help['url'];
                        $items[] = $item;
                    }
                }
            }
        }


        if (empty($items)) {
            return false;
        } else {
            return $items;
        }
    }

    /**
     * 日志记录
     * @param $data
     * @param $title
     * @param string $type
     */
    protected function log($data, $title = 'weixin：', $type = Log::INFO)
    {
        Log::write($title . json_encode($data), $type);
    }

    /**
     * 返回微信类
     * @return Wechat
     */
    public function getWechat()
    {
        import('@.ORG.Wx.Wx');
        $options = array(
            'token' => C('WEIXIN_TOKEN'), //填写你设定的key
            'appid' => C('WXAPPID'), //填写高级调用功能的app id
            'appsecret' => C('WXAPPSECRET'), //填写高级调用功能的密钥
            'debug' => true,
        );
        $Wechat = new \TPWechat($options);
        return $Wechat;
    }



    /**
     * 根据指定长度生成随机数
     * @param $length
     * @return null|string
     */
    public function getRandCharNum($length){
        $str = null;
        $strPol = "0123456789";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }


    /**
     * 生成用户编号
     */
    public function createUserNumber(){
        $str = time();
        $str .= $this->getRandCharNum(4);
        return $str;
    }

}