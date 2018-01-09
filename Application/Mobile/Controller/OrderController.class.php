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
use Think\Log;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class OrderController extends MobileController {
    /**
     * s生成订单
     */
    public function createorder(){
        $id         = I("id");
        $name       = I("name");
        $phone      = I("phone");
        $sex        = I("sex");
        $birthinfo  = I("birthinfo");
        //$amount     = I("amount");
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

        $map['name'] = $name;
        $map['phone']= $phone;
        $map['isdel']= 0;
        $tmpuser     = M("student")->where($map)->find();
        if($tmpuser){
            $result_stu = $tmpuser['id'];
        }else{
            $number      = $this->getStudentNumber();
            $cardnum     = $this->getCardNumber();
            $result_stu  = D("student")->addStudent($number, $cardnum, $name, $sex, $birthinfo, $phone, $openid, $nickname, $headimg, $mark);
        }
        $number      = $this->getOrderNumber();
        $schedule    = M("schedule")->field("amount,amount_follow")->find($id);
        $tmporder    = D("order")->checkFollow($result_stu);
        if($tmporder){
            if(time() < strtotime('2017-06-20 00:00:00')){
                $amount = $this->getReduceByLast($schedule['amount']);
                $type   = 2;
            }else if($schedule['amount_follow'] > 0){
                $amount = $schedule['amount_follow'];
                $type   = 1;
            }
        }else{
            $amount   = $schedule['amount'];
            $type     = 0;
        }

        $result_order = D("order")->addOrder($number, $result_stu, $id, '', $amount, $type, $mark);
        if($result_stu && $result_order){
            M()->commit();
            $res['status'] = 100;
            $res['data']   = $number;
        }else{
            Log::write("用户下单：student:".$result_stu.',order:'.$result_order);
            M()->rollback();
            $res['status'] = 101;
        }
        echo(json_encode($res));
    }

    /**
     * s确认课程页
     */
    public function confirm(){
        $hour = date('H');
        if($hour <= 5 || $hour >= 21){
            echo("<script>alert('系统定期维护期间(21:00-05:00)无法预订，敬请见谅。'); window.location.href = '/index.php/Mobile/Order/orderList';</script>");
            exit;
        }
        $number         = I("number");
        $orderinfo      = M("order")->where("isdel = 0 and number = '".$number."'")->find();
        if($orderinfo['status'] == 1){
            $this->redirect('orderlist');
        }
        $map['isdel']   = 0;
        $map['id']      = $orderinfo['sid'];
        $data           = M("schedule")->where($map)->find();

        $amount         = $orderinfo['amount'];
        $number         = $orderinfo['number'];

        $paypost        = $this->prewxpay($orderinfo['id'], $amount);//
        $this->assign("type",$orderinfo['type']);
        $this->assign("paypost",$paypost);
        $this->assign("amount",$amount);
        $this->assign("number",$number);
        $this->assign("data",$data);
        $this->assign("title","确认支付");
        $this->display();
    }


    public function success(){
        $number  = I("number");
        $order   = D("order")->getOrderByNumber($number);

        $this->assign('number',$number);
        $this->assign('amount',$order['realamount']);
        $this->assign("title","支付成功");
        $this->display();
    }

    public function detail(){
        $number           = I("number");
        $type             = I("type");
        $uid              = $_SESSION['uid'];
        $where['uid']     = $uid;
        $where['number']  = $number;
        $parkingnum       = 0;
        $ispay            = 0;
        if($type == 'order'){
            $order    = M("order")->where($where)->find();
            if(!is_array($order)){
                $this->error('订单不存在');
            }
            $ispay    = $order['ispay'];
        }elseif($type == 'ticket'){
            $order    = M("orderTicketList")->where($where)->find();
            if(!is_array($order)){
                $this->error('订单不存在');
            }else{
                /*$ispay       = $order['ispay'];
                $ticketlist  = D("orderTicketList")->getListByOtid($order['id']);
                $ticketModel = M("guestTicket");
                foreach($ticketlist as &$v){
                    $ticketinfo    = $ticketModel->find($v['gtid']);
                    $v['datezone'] = $this->getDateZone($ticketinfo['timetype'],$ticketinfo['date_s'],$ticketinfo['date_e']);
                    $v['timezone'] = $this->getTimeZone($ticketinfo['timezone_s'],$ticketinfo['timezone_e']);
                    $v['tag']      = $ticketinfo['tag'];
                }
                $order = $ticketlist;*/
                $parkingnum    = $order['count'] - $order['usenum'];
                $ticketinfo    = M("guestTicket")->find($order['gtid']);
                $order['datezone'] = $this->getDateZone($ticketinfo['timetype'],$ticketinfo['date_s'],$ticketinfo['date_e']);
                $order['timezone'] = $this->getTimeZone($ticketinfo['timezone_s'],$ticketinfo['timezone_e']);
                $order['icon'] = $ticketinfo['tag'];
                $ispay = $order['ispay'];

            }
            /*$order    = M("orderTicket")->where($where)->find();
            if(!is_array($order)){
                $this->error('订单不存在');
            }else{
                $ispay       = $order['ispay'];
                $ticketlist  = D("orderTicketList")->getListByOtid($order['id']);
                $ticketModel = M("guestTicket");
                foreach($ticketlist as &$v){
                    $ticketinfo    = $ticketModel->find($v['gtid']);
                    $v['datezone'] = $this->getDateZone($ticketinfo['timetype'],$ticketinfo['date_s'],$ticketinfo['date_e']);
                    $v['timezone'] = $this->getTimeZone($ticketinfo['timezone_s'],$ticketinfo['timezone_e']);
                    $v['tag']      = $ticketinfo['tag'];
                }
                $order = $ticketlist;
            }*/
        }

        $userinfo = D("userinfo")->find($uid);
        $this->assign("userinfo",$userinfo);
        $this->assign("order",$order);
        $this->assign("type",$type);
        $this->assign("number",$number);
        $this->assign("ispay",$ispay);

        $filename = $number.'.png';//生成订单二维码
        $path = $this->createQrcode($number,$filename);

        $this->assign("parkingnum",$parkingnum);
        $this->assign("path",$path);
        $this->assign("title","订单详情");
        $this->display();
    }

    public function orderlist(){
        $openid         = $this->getOpenid();
        $userinfo       = M("student")->where("openid='".$openid."'")->find();

        $map['train_order.isdel']   = 0;
        $map['train_order.uid']     = $userinfo['id'];
        $data = M("order")
            ->field("train_order.id,train_order.uid,train_order.type,train_order.amount,train_order.reducecode,train_order.status,train_order.isget,train_order.number,train_order.realamount,train_schedule.title,train_schedule.classtype,train_schedule.sportid,train_schedule.startdate,train_schedule.enddate,train_schedule.weekinfo,train_schedule.hour_s,train_schedule.hour_e,train_schedule.students,train_schedule.num_min,train_schedule.num_max,train_schedule.nums,train_schedule.mark")
            ->join("train_schedule on train_order.sid = train_schedule.id")
            ->where($map)->order("train_order.id desc")
            ->select();

        $studentmodel = M("student");
        foreach($data as &$v){
            if($v['status'] == 1){
                if(date('Y.m.d') < $v['startdate']){
                    $v['status'] = 2;
                }
            }
            $tmp = $studentmodel->find($v['uid']);
            $v['name'] = $tmp['name'];
            $v['sex']  = $tmp['sex'];
            $v['birthinfo'] = str_replace('-','年',$tmp['birthinfo']).'月';
            $v['phone'] = $tmp['phone'];
            if(!empty($v['reducecode']) && $v['status'] == 0){
                $flag = D("order")->updateReduceOff($v['number']);
                if($flag){
                    $v['realamount'] = $v['amount'];
                }
            }
        }

        $this->assign("data",$data);
        $this->assign("title","我的报名");
        $this->display();
    }

    /**
     * s订单退订操作（已支付，需退款）
     */
    public function refound(){
        $oid = I("oid");
        if($oid > 0){
            $map['status'] = 1;
            $map['oid']    = $oid;
            $order = M("wxpayOrder")->where($map)->find();
            if($order){
                $amount = $order['amount'];//订单金额
                $fee    = 0;//手续费，即不可退的金额
                $refound= 0.01;//$amount - $fee;//总费用 - 手续费 = 可退金额

                //退钱
                if(1> 0 || $order['paytype'] == '微信支付'){
                    $flagUser = $this->wxRefundPost($refound, $order['number']);
                }else{
                    $flagUser = D("Userinfo")->refundBalance($order['uid'], $refound, '订单'.$oid.'，编号：'.$order['number'].'，退款金额：'.$refound.'，手续费：'.$fee);
                }
                //更改订单状态
                $flagOrder = D("Order")->updateOrderRefound($oid);
                //更新片区状态
                $flagOrderPlace = D("OrderPlace")->updateOrderRefound($oid);
                if($flagUser == 200 && $flagOrder && $flagOrderPlace){
                    $result['status'] = 200;
                    $result['msg']    = '退订成功';
                }else{
                    $result['status'] = 201;
                    $result['msg']    = '退订失败';
                }
            }else{
                $result['status'] = 302;
                $result['msg']    = '订单不存在';
            }
        }else{
            $result['status'] = 301;
            $result['msg']    = '订单编号不能为空';
        }

        echo(json_encode($result));
    }


    /**
     * S取消订单（未支付，无需退款）
     */
    public function cancelOrder(){
        $oid = I("oid");
        if($oid > 0){
            $order = D("order")->getNoPayOrderById($oid);
            if($order){
                //更改订单状态
                $flagOrder = D("Order")->updateOrderRefound($oid);
                //更新片区状态
                $flagOrderPlace = D("OrderPlace")->updateOrderRefound($oid);
                if($flagOrder && $flagOrderPlace){
                    $result['status'] = 200;
                    $result['msg']    = '取消成功';
                }else{
                    $result['status'] = 201;
                    $result['msg']    = '取消失败';
                }
            }else{
                $result['status'] = 302;
                $result['msg']    = '订单不存在';
            }
        }else{
            $result['status'] = 301;
            $result['msg']    = '订单编号不能为空';
        }

        echo(json_encode($result));
    }

    /**
     * s查看停车优惠券二维码
     */
    public function parkingnum(){
        $number = I("number");
        $openid = $this->getOpenid();
        if($number && $openid){
            $map = array();
            $map['number'] = $number;
            $map['parkingnum'] = array('gt', 1);
            $map['addtime'] = array(
                array('egt',strtotime(date('Y-m-d').' 00:00:00')),
                array('elt',strtotime(date('Y-m-d').' 23:59:59'))
            );
            $consumehistory = M("consumeHistory")->where($map)->find();
            if(empty($consumehistory)){
                $this->error('停车优惠券不存在或已失效，仅当天有效');
            }else{
                $parkingnumber = $consumehistory['parkingnumber'];
                $filename = $parkingnumber.'.png';//生成订单二维码

                $host = 'http://'.$_SERVER['SERVER_NAME'];
                if($_SERVER["SERVER_PORT"] != 80){
                    $host .= ':'.$_SERVER["SERVER_PORT"];
                }

                $parkingnumber = $host.U('/Mobile/Order/getParkingNumber/number/'.$parkingnumber);
                $path = $this->createQrcode($parkingnumber,$filename);
                $this->assign("path",$path);
                $this->display();
            }
        }else{
            $this->error('参数错误');
        }
    }

    /**
     * s领取停车优惠编码
     */
    public function getParkingNumber(){
        $openid = $this->getOpenid();
        $number = I("number");
        if(!empty($number)){
            $map = array();
            $map['parkingnumber'] = $number;
            if($number != '1478674561176079'){
                $map['addtime'] = array(//确保是核销的优惠券
                    array('egt',strtotime(date('Y-m-d').' 00:00:00')),
                    array('elt',strtotime(date('Y-m-d').' 23:59:59'))
                );
            }

            $consumehistory = M("consumeHistory")->field('parkingnum')->where($map)->find();
            if(empty($consumehistory)){
                $this->error('领取失败，停车优惠券不存在或已失效，仅当天有效');
            }else{
                $parkingnum = $consumehistory['parkingnum'];//总可用张数
                $map = array();
                $map['number'] = $number;
                $count = M('consumeParking')->where($map)->count();//已领用张数
                if($parkingnum <= $count){
                    $this->error('领取失败，停车优惠券共计'.$parkingnum.'张，已领取'.$count.'，无可用停车优惠券。');
                }else{
                    $userinfo = D("userinfo")->findByOpenId($openid);
                    $parking['number']  = $number;
                    $parking['uid']     = $userinfo['id'];
                    $parking['addtime'] = array(//确保是当天有效的优惠券
                        array('egt',strtotime(date('Y-m-d').' 00:00:00')),
                        array('elt',strtotime(date('Y-m-d').' 23:59:59'))
                    );
                    $isexist = M("consumeParking")->where($parking)->find();
                    $url = 'http://parking.iceinto.com/Mobile/WxOrderForm/pay/?appid=wxee976956731c3004&fComeGoNo=wx&t='.time().'&sourceopenid='.$openid;
                    if(empty($isexist)){//表明没有领取过
                        $parking['addtime'] = time();
                        $flag = M("consumeParking")->add($parking);
                        if($flag){
                            echo("<script>alert('领取成功，点击跳转'); window.location.href = '".$url."';</script>");//javascript:window.opener=null;window.open('','_self');window.close();
                            //http://suzhou.24parking.com.cn/index.php/Mobile/Index/parking/act/parking
                        }else{
                            $this->error('领取失败，网络错误');
                        }
                    }else{
                        echo("<script>alert('每人只能领取一次，点击跳转'); window.location.href = '".$url."';</script>");
                    }
                }
            }
        }else{
            $this->error('领取失败，参数错误');
        }
    }
}