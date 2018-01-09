<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 苦咖啡
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;
use Think\Log;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class MobileController extends CommonController {
    /**
     * s课程列表页
     */
    public function schedulelist(){
        $openid = $this->getOpenid();
        $openid_get = '';
        if(empty($openid)){
            $openid_get = I("openid");
        }
        if(empty($openid_get)){
            $this->redirect('http://suzhou.24parking.com.cn/index.php/Mobile/Userinfo/index/act/train.html');
            exit();
        }else{
            $_SESSION['openid']  = $openid_get;
            $this->setOpenid($openid_get);
        }
        $data = M("schedule")->where("isdel = 0")->group("title,startdate,enddate")->order("id asc")->select();
        $this->assign("data", $data);
        $this->assign("title",'选课');
        $this->display();
    }

    /**
     * s课程详情页
     */
    public function scheduledetail(){
        $openid = $this->getOpenid();
        echo($openid);
        $id                 = I("id");
        $map['isdel']       = 0;
        $map['id']          = $id;
        $data               = M("schedule")->where($map)->find();

        $map                = array();
        $map['title']       = $data['title'];
        $map['startdate']   = $data['startdate'];
        $map['enddate']     = $data['enddate'];
        $map['isdel']       = 0;
        $datelist           = M("schedule")->field("id,hour_s,hour_e,num_min,num_max,reserve")->where($map)->select();
        $model = M("order");
        foreach($datelist as &$v){
            $map            = array();
            $map['sid']     = $v['id'];
            $map['status']  = 1;
            $map['isdel']   = 0;
            $tmp            = $model->where($map)->count();
            if($tmp){
                $v['num']   = $v['num_max'] - $v['reserve'] - $tmp;
            }else{
                $v['num']   = $v['num_max'] - $v['reserve'];
            }
        }

        $this->assign("data", $data);
        $this->assign("datelist", $datelist);
        $this->assign("title",'课程详情');
        $this->display();
    }

    /**
     * s确认课程页
     */
    public function scheduleconfirm(){
        $id                 = I("id");
        $map['isdel']       = 0;
        $map['id']          = $id;
        $data               = M("schedule")->where($map)->find();

        $year = date('Y') - 7;
        for($i = $year; $i > 1960; $i--){
            $birth_year[] = $i;
        }
        for($i = 1; $i <= 12; $i++){
            $birth_month[] = $i;
        }


        $this->assign("birth_year",$birth_year);
        $this->assign("birth_month",$birth_month);
        $this->assign("data",$data);
        $this->assign("title","确认报名");
        $this->display();
    }


    /**
     * s生成订单
     */
    public function createorder(){
        $id         = I("id");
        $name       = I("name");
        $phone      = I("phone");
        $sex        = I("sex");
        $birthinfo  = I("birthinfo");
        $amount     = I("amount");
        $mark       = I("mark");
        if($mark == 'level_1'){
            $mark = '初学';
        }elseif($mark == 'level_2'){
            $mark = '提高';
        }

        M()->startTrans();
        $openid     = $this->getOpenid();
        $userinfo   = M("user")->field("nickname,headimgurl")->where("openid='".$openid."'")->find();
        if($userinfo){
            $nickname = $userinfo['nickname'];
            $headimg  = $userinfo['headimgurl'];
        }else{
            $openid   = '';
            $nickname = '';
            $headimg  = '';
        }
        $number      = date('Ym').$this->getRandCharNum(4);
        $cardnum     = date('md').$this->getRandCharNum(4);
        $result_stu  = D("student")->addStudent($number, $cardnum, $name, $sex, $birthinfo, $phone, $openid, $nickname, $headimg, $mark);
        $number      = date('YmdHis').$this->getRandCharNum(4);
        $schedule    = M("schedule")->field("amount,amount_follow")->find($id);
        $result_status = 1;
        if($schedule['amount_follow'] == $amount){
            $type    = 0;
        }elseif($schedule['amount'] == $amount){
            $type    = 1;
        }else{
            //无效订单
            $result_status = 0;
        }
        $result_order = D("order")->addOrder($number, $result_stu, $id, '', $amount, $type, $mark);
        if($result_stu && $result_order && $result_status){
            M()->commit();
            $res['status'] = 100;
            $res['id']     = $result_order;
        }else{
            Log::write("用户下单：student:".$result_stu.',order:'.$result_order.',status:'.$result_status);
            M()->rollback();
            $res['status'] = 101;
        }
        echo(json_encode($res));
    }

    /**
     * s确认课程页
     */
    public function orderconfirm(){
        $id             = I("id");
        $orderinfo      = M("order")->where("isdel = 0")->find($id);
        $map['isdel']   = 0;
        $map['id']      = $orderinfo['sid'];
        $data           = M("schedule")->where($map)->find();

        $amount  = $orderinfo['amount'];
        $number  = $orderinfo['number'];
        $body    = '苏州市市民健身中心游泳培训班报名费用';
        $paypost = $this->wxPayPost($amount, $number, $body);
        $this->assign("paypost",$paypost);

        $this->assign("data",$data);
        $this->assign("title","确认支付");
        $this->display();
    }
}