<?php
namespace Mobile\Controller;
use Think\Controller;
use Think\Log;

class CommonController extends Controller
{
    private $_openid;

    public function _initialize()
    {
        //$_SESSION['uid'] = null;
        //$_SESSION['openid'] = 'or-Ynw-Q-EwyOpZgmMTdgHFbcaCo';
        //$_SESSION['openid'] = null;
        /*if(!is_login()){
            $this->baseCheck();
        }*/

        $this->baseInfo();

        /*if(ACTION_NAME != 'refound'){
            $this->baseCheck();
        }*/
    }

    public function baseInfo()
    {
        if (1 > 0 || strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            $this->baseCheck();
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
     * 基本检查
     */
    public function baseCheck()
    {
        //必须给出微信标示
        $openid = I('get.openid');
        $openid = !empty($openid) ? $openid : $_SESSION['openid'];

        if (empty($openid)) {
            //跳转到用户登录授权
            $this->getWxLogin();
            //exit('禁止您的本次访问！仅支持从微信用户访问！');
        } else {
            $this->_openid = $openid;
            if (!strlen($this->_openid) == 28) {// || $this->regex($this->_openid, '/^[A-Za-z_-]+$/')
                $this->goToLogin();
            } else {
                $_SESSION['openid'] = $openid;
                $userinfo = M("userinfo")->where("openid = '".$openid."'")->find();
                if($userinfo){
                    $_SESSION['uid'] = $userinfo['id'];
                }
            }
        }
    }



    /**
     * 跳转到登陆页面
     */
    public function goToLogin()
    {
        //Session::clear();
        //Session::destroy();
        $_SESSION = null;
        $this->getWxLogin();
    }

    /**
     * 获取用户信息
     */
    public function getUser()
    {
        $user = D('User')->findByOpenId($this->_openid);
        $this->assign('userInfo', $user);
        return $user;
    }

    /**
     * 获取当前用户是否是绑定用户信息
     */
    public function getBindUser()
    {
        $user = $this->getUser();
        $this->checkEmpty($user, '您还没有绑定手机号码！请先绑定手机号码！', U('/Mobile/Bind/user'));
        return $user;
    }

    /**
     * 跳转到微信授权登陆
     */
    public function getWxLogin()
    {
        Log::write('用户访问信息getWxLogin：'.json_encode($_GET));
        $act = I("act");
        //$this->redirect('http://suzhou.24parking.com.cn/index.php/Mobile/Userinfo/index/act/train.html');
        echo("<script>window.location.href = 'http://cloud.24parking.com.cn/index.php/Mobile/Userinfo/index/act/crmapi.html'</script>");
    }

    /**
     * 通过授权获取用户openid
     * @return mixed
     */
    public function getOpenid()
    {
        if($this->_openid){
            return $this->_openid;
        }else{
            return $_SESSION['openid'];
        }
    }

    /**
     * 封装post方法
     * @param $url
     * @param $body
     * @return Requests_Response
     */
    public function post($url, $body)
    {
        import('@.ORG.Net.Requests');
        $request = new Requests();
        $request::register_autoloader();
        $headers = array('Content-Type' => 'application/json');
        $response = $request::post($url, $headers, json_encode($body));
        return $response->body;
    }


    /**
     * 根据订单编号获取判断订单信息
     * @param $fcomegono
     */
    public function wxPayOrderForm($fcomegono){
        import('@.ORG.WxPay.WxPay');
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        //使用统一支付订单查询接口
        $orderQuery_pub = new \OrderQuery_pub();
        $orderQuery_pub->setParameter('out_trade_no',$fcomegono);
        $xml = $orderQuery_pub->createXml();
        Log::write('微信订单查询结果:' . $xml);
    }

    /**
     * 支付订单支付生成内容
     * @param $money
     * @param $fcomegono
     * @param $body 支付内容描述
     */
    public function wxPay($money, $fcomegono, $body = '您的缴费信息')
    {
        import('@.ORG.WxPay.WxPay');
        $jsApi = new JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        $openid = Session::get('openid');

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid", $openid);
        $unifiedOrder->setParameter("body", $body);//商品描述
        //自定义订单号，此处仅作举例
        $unifiedOrder->setParameter("out_trade_no", $fcomegono);//商户订单号
        $unifiedOrder->setParameter("total_fee", $money * 100);//总金额 转化为分
        $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型

        $prepayResult = $unifiedOrder->getPrepayResult();
        Log::write('微信订单支付生成结果:' . json_encode($prepayResult));
        if ($prepayResult['result_code'] == 'SUCCESS') {
            //=========步骤3：使用jsapi调起支付============
            $jsApi->setPrepayId($prepayResult['prepay_id']);
        } else if($prepayResult['err_code_des'] == ''){
            Log::write('微信订单支付成功');
            $this->wxPayOrderForm($fcomegono);
        }else{
            Log::write('微信订单支付成功1');
            $this->wxPayOrderForm($fcomegono);
            //$this->error($prepayResult['err_code_des']);
        }
        $jsApiParameters = $jsApi->getParameters();
       // dump($jsApiParameters);
        $this->assign('payApi', $jsApiParameters);
        $this->assign('fcomegono', $fcomegono);
    }

    /**
     * 支付订单支付生成内容
     * @param $money
     * @param $fcomegono
     * @param $body 支付内容描述
     */
    public function wxPayPost($money, $out_trade_no, $body = '卓赢健身')
    {
        import('@.ORG.WxPay.WxPay');
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        $openid = $this->getOpenid();

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid", $openid);
        $unifiedOrder->setParameter("body", $body);//商品描述
        //自定义订单号，此处仅作举例
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
        $unifiedOrder->setParameter("total_fee", $money * 100);//总金额 转化为分
        $unifiedOrder->setParameter("notify_url", "http://crmapi.24parking.com.cn/index.php/Mobile/WxPay/notify");//通知地址//WxPayConf_pub::NOTIFY_URL
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型

        $prepayResult = $unifiedOrder->getPrepayResult();

        Log::write('微信订单支付生成条件:'.json_encode($unifiedOrder));
        Log::write('微信订单支付生成结果:' . json_encode($prepayResult));
        if ($prepayResult['result_code'] == 'SUCCESS') {
            //=========步骤3：使用jsapi调起支付============
            $jsApi->setPrepayId($prepayResult['prepay_id']);
        } else if($prepayResult['err_code_des'] == ''){
            Log::write('微信订单支付生成结果成功');
            $this->wxPayOrderForm($out_trade_no);
        }else{
            Log::write('微信订单支付成功1');
            $this->wxPayOrderForm($out_trade_no);
            //$this->error($prepayResult['err_code_des']);
        }

        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }


    public function wxRefundPost($money, $out_trade_no){
        import('@.ORG.WxPay.WxPay');
        $refundpub = new \Refund_pub();
        //自定义订单号，此处仅作举例
        $out_refund_no = date('YmdHis').$this->getRandChar(4);
        $refundpub->setParameter("out_trade_no", $out_trade_no);//商户订单号
        $refundpub->setParameter("out_refund_no", $out_refund_no);//商户订单号
        $refundpub->setParameter("total_fee", $money * 100);//总金额 转化为分
        $refundpub->setParameter("refund_fee", $money * 100);//退款金额 转化为分
        $refundpub->setParameter("op_user_id", "MCHID");//
        //$unifiedOrder->setParameter("notify_url", "http://suzhou.24parking.com.cn/index.php/Mobile/WxPay/notify");//通知地址//WxPayConf_pub::NOTIFY_URL
        //$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型

        $refundResult = $refundpub->getResult();

        Log::write('微信订单退款生成条件:'.json_encode($refundpub));
        Log::write('微信订单退款生成结果:' . json_encode($refundResult));
        if ($refundResult['result_code'] == 'SUCCESS') {
            $flag = M("order")->where("number = ".$out_trade_no)->save(array('refundnumber'=>$out_refund_no));
            Log::write('微信订单退款申请提交成功，订单更新结果：'.$flag.'，SQL:'.M()->getLastSql());
            return true;
        }else{
            Log::write('微信订单退款申请提交失败');
            return false;
        }
    }

    /**
     * 获取随机数`
     */
    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
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
     * 获取验证码随机数
     */
    public function getValidateCode($openid){
        $str = null;
        $strPol = "0123456789";
        $max = strlen($strPol)-1;

        for($i=0;$i<6;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        S("code_".$openid,$str,10 * 60);//有效期10分钟
        return $str;
    }

    function _ini2array( $params )
    {
        if($params == '') return false;
        $data = array();
        $params = explode("\n", $params);
        foreach( $params as $v )
        {
            if($v != '' && $v != '[\]') {
                $tmp = explode('=', $v);
                $data[$tmp[0]] = $tmp[1];
            }
        }
        return $data;
    }

    function _array2ini($array)
    {
        if(!$array || !is_array($array)) return '';
        $ini = "[\]";
        foreach ($array as $k => $v) {
            $ini .= "\n".strtoupper($k)."=".$v;
        }
        return $ini;
    }


    /**
     * 使用正则验证数据
     * @access public
     * @param string $value 要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    public function regex($value, $rule)
    {
        $validate = array(
            'require' => '/.+/',
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency' => '/^\d+(\.\d+)?$/',
            'number' => '/^\d+$/',
            'zip' => '/^\d{6}$/',
            'integer' => '/^[-\+]?\d+$/',
            'double' => '/^[-\+]?\d+(\.\d+)?$/',
            'english' => '/^[A-Za-z]+$/',
        );
        // 检查是否有内置的正则表达式
        if (isset($validate[strtolower($rule)]))
            $rule = $validate[strtolower($rule)];
        return preg_match($rule, $value) === 1;
    }

    /**
     * S通过电话号码判断用户是否已注册
     * @param $phone
     * @return bool
     */
    public function checkUserByPhone($phone){
        $result = D("Userinfo")->findByPhone($phone);
        if(is_array($result)){
            return true;
        }else{
            return false;
        }
    }


    //发送短信验证码
    public  function sendCode($phone, $type =  ''){
        $openid   = $this->getOpenid();
        $code     = $this->getValidateCode($openid);//获取验证码
        if($type == 'reg'){
            if($this->checkUserByPhone($phone)){
                $res = array(
                    'status' => 202,
                    'msg'    => '您已是会员，请直接登录'
                );
                echo(json_encode($res));
                exit();
            }
        }

        $post_data              = array();
        $post_data['userid']    = 1103;
        $post_data['account']   = 'HSBXX';
        $post_data['password']  = 'Heisenberg2016';
        $post_data['content']   = '【海森堡】您的短信验证码为'.$code.'，有效时间10分钟，请尽快输入。';
        $post_data['mobile']    = $phone;
        $post_data['sendtime']  = '';
        $url                    = 'http://115.29.242.32:8888/sms.aspx?action=send';
        $o  = '';
        foreach ($post_data as $k => $v){
            $o.= "$k=".urlencode($v).'&';
        }
        $post_data  = substr($o,0,-1);
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
        $result = curl_exec($ch);
        $xml    = @simplexml_load_string($result,NULL,LIBXML_NOCDATA);
        $data   = json_decode(json_encode($xml),TRUE);
        if($data['returnstatus'] == 'Success'){
            $res = array(
                'status' => 200,
                'msg'    => '发送成功'
            );
        }else{
            $res = array(
                'status' => 201,
                'msg'    => '发送失败'
            );
        }
        echo(json_encode($res));
    }

}