<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Mobile\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class UserinfoController extends MobileController {
    /**
     * s用户中心页面
     */
    public function index(){
        $openid = $this->getOpenid();
        $act    = I("act");
        if($act == 'train'){
            $url = 'http://train.24parking.com.cn/Home/Mobile/schedulelist/openid/'.$openid;
            echo("<script>window.location.href = '".$url."';</script>");
            exit();
        }
        if(!$_SESSION['uid']){
            $this->redirect('Mobile/Userinfo/login/');
        }
        $userinfo = M("userinfo")->find($_SESSION['uid']);
        if($userinfo['phone']!=null){
            $uptel = '修改手机号';
        }else{
            $uptel = '绑定手机号';
        }
        $this->assign("vo",$userinfo);
        $this->assign("title",'个人信息');
        $this->assign("uptel",$uptel);
        $this->display();
    }

    /**
     * s查看二维码页面
     */
    public function myqrcode(){
        if(!$_SESSION['uid']){
            $this->redirect('Mobile/Userinfo/login/');
        }
        $userinfo = M("userinfo")->find($_SESSION['uid']);
        $number   = $userinfo['number'];
        $filename = $number.'.png';//生成个人信息二维码
        $path = $this->createQrcode($number,$filename);

        $this->assign("path",$path);
        $this->assign("vo",$userinfo);
        $this->assign("title",'我的二维码');
        $this->display();
    }

    /* 注册页面 */
    public function register(){
        $openid     = $this->getOpenid();
        $weixinUser = D("weixinUser")->findByOpenid($openid);
        $nickname   = $weixinUser['nickname'];
        $this->assign('username',$nickname);
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
        if(IS_POST){ //注册用户
            $phone  = I("phone");
            if(!preg_match("/^1[3578]{1}[0-9]{9}$/",$phone)){
                $this->error('手机号码格式错误');
            }

            $code   = I("code");
            if(!empty($phone) && !empty($code)){
                if($code != S("code_".$openid)){
                    $this->error('验证码错误');
                }else{//验证成功，销毁验证码
                    S("code_".$openid,null);
                }
            }else{
                $this->error('手机号码和验证码不能为空');
            }
            $number = $this->createUserNumber();
            $headimg = $weixinUser['headimgurl'];
            $uid    = D("userinfo")->register($phone,$nickname,$openid,$headimg,$number);

            if(0 < $uid){ //注册成功
                redirect(U('Mobile/Userinfo/success?number='.$number.'&phone='.$phone));
            } else { //注册失败，显示错误信息
                $this->error("注册失败");
            }

        } else { //显示注册表单
            $this->display();
        }
    }

    /**
     * 注册成功页
     */
    public function success(){
        $phone = I("phone");
        $number = I("number");
        $this->assign("nickname",$_SESSION['nickname']);
        $this->assign("openid",$_SESSION['openid']);
        $this->assign("phone",$phone);
        $this->assign("number",$number);
        $this->display();
    }

    /* 登录页面 */
    public function login(){
        if($_SESSION['uid']){
            $this->redirect('Mobile/Userinfo/index/');
        }

        header("Content-type: text/html; charset=utf-8");
        $openid     = $this->getOpenid();
        $weixinUser = D("weixinUser")->findByOpenid($openid);
        $nickname   = $weixinUser['nickname'];
        $this->assign('username',$nickname);
        if(IS_POST){ //登录验证
            $phone = I("phone");//电话号码或者编号
            $code  = I("code");
            if(!empty($phone) && !empty($code)){
                if($code != S("code_".$openid)){
                    echo('<script>alert("验证码错误"); window.location.href="/Mobile/Userinfo/login";</script>');
                    exit();
                    //$this->error('验证码错误');
                }else{//验证成功，销毁验证码
                    S("code_".$openid,null);
                }
            }else{
                $this->error('手机号码和验证码不能为空');
            }
            $uid   = D("userinfo")->login($phone);
            if(0 < $uid){
                redirect(U("/Mobile/Userinfo/index"));
            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }

        } else { //显示登录表单
            $this->assign('title','用户登录');
            $this->display();
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            $this->success('退出成功！', U('Userinfo/login'));
        } else {
            $this->redirect('Userinfo/login');
        }
    }

    public function sendValidateCode(){
        $phone = I("phone");
        $type  = I("type");
        if($type == ''){
            $type = 'login';
        }
        if($phone){
            $this->sendCode($phone, $type);
        }else{
            $result = array(
                'status' => 202,
                'msg'    => '手机号码不能为空'
            );
            echo(json_encode($result));
        }
    }

    public function updatetel(){
        $openid = $this->getOpenid();
        $user = D("userinfo");
        $uid = $_SESSION['uid'];
        $userinfo = $user->find($_SESSION['uid']);
        $nickname = $userinfo['nickname'];

        $this->assign('username',$nickname);
        if($userinfo['phone']!=null){
            $title = '修改手机号';
            $this->assign('oldphone',$userinfo['phone']);
        }else{
            $title = '绑定手机号';
        }
//        print_r($nickname);die;

        if(IS_POST){ //修改手机号
            $phone  = I("phone");
            if(!preg_match("/^1[3578]{1}[0-9]{9}$/",$phone)){
                $this->error('手机号码格式错误');
            }
            $code   = I("code");
            if(!empty($phone) && !empty($code)){
                if($code != S("code_".$openid)){
                    $this->error('验证码错误');
                }else{//验证成功，销毁验证码
                    S("code_".$openid,null);
                }
            }else{
                $this->error('手机号码和验证码不能为空');
            }
            $user->phone = $phone;
            $res = $user->where('id=' . $uid)->save();

            if($res){ //修改成功
                redirect(U('Mobile/Userinfo/uptelsuccess?title='.$title.'&phone='.$phone));
            } else { //修改失败，显示错误信息
                $this->error("注册失败");
            }

        } else { //显示注册表单
            $this->assign('title',$title);
            $this->display();
        }
    }

    public function charge(){
        $this->display();
    }


    public function uptelsuccess(){
        $title = I('title');
        $phone = I('phone');
        $user = D("userinfo");
        $uid = $_SESSION['uid'];
        $userinfo = $user->find($_SESSION['uid']);
        $nickname = $userinfo['nickname'];
        $number = $userinfo['number'];
        $this->assign('title',$title);
        $this->assign('nickname',$nickname);
        $this->assign('phone',$phone);
        $this->assign('number',$number);
        $this->display();
    }

    public function adduserinfo(){
        if(IS_POST){
            $flag = 1;
            $user['realname'] = I("realname");
            if(empty($user['realname'])){
                $flag = 0;
            }
            $user['phone'] = I("phone");
            if(empty($user['phone'])){
                $flag = 0;
            }
            if($flag == 0){
                $this->error('用户姓名或联系方式不能为空');
            }
            $user['id']       = $_SESSION['uid'];
            $user['realname'] = I("realname");
            $user['address']  = I("address");
            $user['email']    = I("email");
            $user['idtype']   = I("idtype");
            $user['birthday'] = I("birthday");
            $user['idnumber'] = I("idnumber");
            $user['degree']   = I("degree");
            $user['img']      = I("img");
            $flag             = D("userinfo")->save($user);
            if($flag){
                echo("<script>alert('保存成功，首次使用时请带齐相关证件至前台查验。'); window.location.href='/Mobile/Userinfo/index';</script>");
                //$this->redirect('/Mobile/Userinfo/index');
            }else{
                echo("<script>alert('保存失败，请确保填写的信息无误。'); window.history.go(-1);</script>");
            }
        }else{
            $source = I("source");
            $yearcard = 0;
            if($source == 'yearcard'){
                $yearcard = 1;
            }
            $openid = $this->getOpenid();
            $userinfo = D("userinfo")->findByOpenId($openid);
            $this->assign("yearcard",$yearcard);
            $this->assign("userinfo", $userinfo);
            $this->display();
        }
    }


    public function uploadPhoto(){
        if(IS_POST){
            $base64 = I("img");
            $img    = base64_decode($base64);
            $path   = './Uploads/Picture/';
            $pic    = $path.$this->createUserNumber().'.jpg';
            file_put_contents($pic, $img);//返回的是字节数
            $pic    = substr($pic, 1);
            echo($pic);
        }
    }

    public function bindphone(){
        $openid = $this->getOpenid();
        $user   = D('WeixinUser')->findByOpenid($openid);
        if(IS_POST){
            $number = I("number");
            if($number){
                $map['openid']  = $openid;
                $where['number'] = $number;
                M("userinfo")->where($where)->save($map);
                echo("<script>alert('绑定成功'); window.location.href = '/index.php/Mobile/Userinfo/bindphone';</script>");
            }else{
                echo("<script>alert('手机号码不能为空');</script>");
            }
        }else{
            $this->assign("user", $user);
            $this->display();
        }
    }
}