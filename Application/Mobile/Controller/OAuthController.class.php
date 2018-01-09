<?php
namespace Mobile\Controller;
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
        $url = $Wechat->getOauthRedirect(getBaseUrl() . '/Mobile/OAuth/wxCode', $act, 'snsapi_base');
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
        $url = $Wechat->getOauthRedirect(getBaseUrl() .  U('/Mobile/OAuth/wxCode/wxappid/'.$appid), $state, 'snsapi_userinfo');
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
    public function wxCode(){
        $code  = I('get.code');
        $act   = I("state");
        Log::write('获取用户信息：'.json_encode($_GET));

        if (!empty($code)) {
            $Wechat = $this->getWechat();
            $token  = $Wechat->getOauthAccessToken();
            if (!empty($token)) {//判断用户信息是否存在 不存在 用户全面授权
                $token['updatetime'] = time();
                M('weixinusertoken')->add($token, null, true);
                $openid              = $token['openid'];
                $WeixinUserModel     = D('weixinuser');

                if ($token['scope'] == 'snsapi_base') {
                    $user = $WeixinUserModel->findByOpenid($openid);//查询用户信息
                    if (empty($user) || empty($user['nickname']) || empty($user['headimgurl'])) {
                        Log::write('新用户第一次打开页面，获取用户详细信息');
                        echo("<script>window.location.href = 'http://192.168.3.10/crmapi/Mobile/OAuth/wxUserInfo/state/".$act."';</script>");
                    }
                }else if ($token['scope'] == 'snsapi_userinfo') {
                    $user = $Wechat->getOauthUserinfo($token['access_token'], $openid);//更新用户信息
                    $this->checkEmpty($user, '用户信息获取失败！');
                    $WeixinUserModel->saveOne($user,$openid);
                } else {
                    $this->error('登录状态错误！');
                }
                $_SESSION['openid'] = $openid;
                $_SESSION['reurl']  = $act;

                if($act == 'enroll'){
                    echo("<script>window.location.href='http://crmapi.24parking.com.cn/Mobile/Enroll/index/';</script>");
                }else{
                    echo("<script>window.location.href='http://192.168.3.10/crmapi/Mobile/Api/getoauthinfo';</script>");
                }
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