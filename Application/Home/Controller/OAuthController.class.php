<?php
namespace Home\Controller;
use Think\Controller;
use Think\Log;
/**
 * 微信授权登陆
 * Class OAuthAction
 */
class OAuthController extends Controller
{
    public function index()
    {
    }

    /**
     * 用户基本信息
     */
    public function wxUserBase()
    {
        Log::write('用户访问信息wxUserBase：'.json_encode($_GET));
        $act = I("state");
        $Wechat = $this->getWechat();
        $url = $Wechat->getOauthRedirect(getBaseUrl() . U('/Home/OAuth/wxCode'), $act, 'snsapi_base');
        Log::write('weixin-snsapi_base: ' . $url);
        redirect($url);
    }

    /**
     * 用户详细信息
     */
    public function wxUserInfo()
    {
        Log::write('用户访问信息wxUserInfo：'.json_encode($_GET));
        $state = I('get.state');
        $appid = I('get.wxappid');
        $Wechat = $this->getWechat();
        $url = $Wechat->getOauthRedirect(getBaseUrl() .  U('/Home/OAuth/wxCode/wxappid/'.$appid), $state, 'snsapi_userinfo');
        Log::write('weixin-snsapi_userinfo: ' . $url);
        redirect($url);
    }

    /**
     * 用户同意授权后
     *
     * 如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数redirect_uri?state=STATE
     *
     * code说明 ：
     * code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     */
    public function wxCode()
    {
        $code  = I('get.code');
        $act   = I("state");
        Log::write('获取用户信息：'.json_encode($_GET));

        if (!empty($code)) {
            $Wechat = $this->getWechat();
            $token  = $Wechat->getOauthAccessToken();
            //记录用户数据
            if (!empty($token)) {//判断用户信息是否存在 不存在 用户全面授权
                $token['updatetime'] = time();
                M('WeixinUserToken')->add($token, null, true);
                $openid              = $token['openid'];
                $WeixinUserModel     = D('WeixinUser');
                $_SESSION['openid']  = $openid;
                $uid                 = D("userinfo")->loginByOpenid($openid);

                if ($token['scope'] == 'snsapi_base') {
                    $user = $WeixinUserModel->findByOpenid($openid);//查询用户信息
                    if (empty($user) || empty($user['nickname']) || empty($user['headimgurl'])) {
                        Log::write('新用户第一次打开页面，获取用户详细信息');
                        $this->redirect('/Home/OAuth/wxUserInfo/state/'.$act);//获取用户信息
                    }
                }else if ($token['scope'] == 'snsapi_userinfo') {
                    $user = $Wechat->getOauthUserinfo($token['access_token'], $openid);//更新用户信息
                    $this->checkEmpty($user, '用户信息获取失败！');
                    $WeixinUserModel->saveOne($user,$openid);
                } else {
                    $this->error('登录状态错误！');
                }

                if($uid == 0){//表明是新用户，自动注册账户
                    if($act == 'bindphone'){//为老用户提供绑定功能
                        $this->redirect('/Home/Userinfo/bindphone/?t='.time());
                    }else{
                        $user   = $WeixinUserModel->findByOpenid($openid);
                        $number = $this->createUserNumber();
                        $uid    = D("userinfo")->register('',$user['nickname'],$openid,$user['headimgurl'],$number);
                    }
                }

                if($act == 'userinfo'){
                    $this->redirect('/Home/Userinfo/index/?t='.time());
                }elseif($act == 'orderList'){
                    $this->redirect('/Home/Order/orderList/?t='.time());
                }elseif($act == 'suzhou'){//苏州场馆打开运动馆列表页
                    $this->redirect('/Home/Index/sportHall/id/1/?t='.time());
                }elseif($act == 'suzhou_ticket'){//散票购买页面
                    $this->redirect('/Home/Ticket/sportHall/id/1?t='.time());
                }elseif($act == 'consume_ticket'){//默认打开核销界面
                    $this->redirect('/Home/Consume/index?t='.time());
                }elseif($act == 'parking'){//打开停车场页面
                    $url = 'http://parking.iceinto.com/Home/WxOrderForm/caches/appid/wxee976956731c3004/fComeGoNo/wx/sourceopenid/'.$openid;
                    echo('<script>window.location.href = "'.$url.'";</script>');
                    //$this->redirect($url);
                }elseif($act == 'coupon'){
                    $this->redirect('/Home/Order/getParkingNumber/number/1478674561176079?t='.time());
                }else{
                    //$this->redirect('/Home/Index/?t='.time());
                    $this->redirect('/Home/Index/sportHall/id/1/?t='.time());
                }
                //跳转页面
            } else {
                $this->error($Wechat->errCode . ' ' . $Wechat->errMsg);
            }
        } else {
            $this->error('授权失败！');
        }
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