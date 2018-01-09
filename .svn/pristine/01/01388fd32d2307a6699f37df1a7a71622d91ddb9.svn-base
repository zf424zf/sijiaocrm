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
class WxPayController extends Controller {

    /**
     * 异步提示
     */
    public function notify()
    {
        Log::write("微信支付成功后返回响应如下：");
        Log::write(serialize($_POST));
        Log::write(serialize($_GET));
        $xml = file_get_contents("php://input");
        Log::write('微信返回值' . $xml);
        $xmlValue     = simplexml_load_string($xml);
        $openid       = (string)$xmlValue->openid;//这里返回的依然是个SimpleXMLElement对象
        $out_trade_no = (string)$xmlValue->out_trade_no;
        $total_fee    = 0.01 * (int)$xmlValue->total_fee;//转换为元

        //获取订单号对应的账单
        $model = M();
        $model->startTrans();//启动事务处理

        $numLen = strlen($out_trade_no);
        $where['number'] = $out_trade_no;
        $where['status'] = 0;
        if($numLen == 15){//用户预订课程
            $wxpayorder  = M("wxpayorder")->where($where)->find();
            if($wxpayorder && $wxpayorder['amount'] == $total_fee){
                $data['id']         = $wxpayorder['id'];
                $data['status']     = 1;
                $data['paytime']    = time();
                $flagwx             = M("wxpayorder")->save($data);
                $flagwxsql          = M()->getLastSql();

                $data               = array();
                $data['id']         = $wxpayorder['oid'];
                $data['ispay']      = 1;
                $data['paytype']    = 1;//表明是微信支付
                $data['paytime']    = time();
                $data['status']     = 1;
                $flagorder          = M("order")->save($data);
                $flagordersql       = M()->getLastSql();

                $order              = M("order")->find($wxpayorder['oid']);
                $arraycourse        = array();
                for($i = 0; $i < $order['totalhours']; $i++){
                    $course                 = M("course")->find($order['cid']);
                    $courselog['cid']       = $order['cid'];
                    $courselog['ctitle']    = $course['name'];
                    $courselog['content']   = $course['content'];

                    $courselog['shid']      = $order['shid'];
                    $courselog['orderid']   = $order['id'];
                    $courselog['uid']       = $order['uid'];
                    $courselog['coid']      = $order['coid'];
                    $courselog['totalhours'] = $order['totalhours'];
                    $courselog['addtime']   = time();
                    $courselog['number']    = time().$this->getRandCharNum(4);
                    $courselog['currenthours'] = $i + 1;
                    $arraycourse[]          = $courselog;
                }
                $flagcourselog      = M("courselog")->addAll($arraycourse);
                $flagcourselogsql   = M()->getLastSql();

                $course                 = M("course")->find($order['cid']);
                $operate['uid']         = $order['uid'];
                $operate['coid']        = $order['coid'];
                $operate['class_name']  = $course['name'];
                $operate['type']        = 1;
                $operate['addtime']     = time();
                $operate['isdel']       = 0;
                $flagoperate            = M("operatelog")->add($operate);//添加用户操作日志
                $flagoperatesql         = M()->getLastSql();

                if($flagwx && $flagorder && $flagcourselog && $flagoperate){
                    Log::write('微信支付成功，订单号：'.$out_trade_no);
                    $model->commit();
                }else{
                    Log::write('微信支付失败，订单号：'.$out_trade_no);
                    Log::write("flagwx:".$flagwxsql);
                    Log::write("flagorder:".$flagordersql);
                    Log::write("flagcourselog:".$flagcourselogsql);
                    Log::write("flagoperate:".$flagoperatesql);
                    $model->rollback();
                }
            }else{
                Log::write('微信支付失败，买订单号：'.$out_trade_no.',订单不存在或金额错误，需退款，SQL:'.M()->getLastSql());
            }
        }elseif($numLen == 14){//9.9秒杀
            $enroll  = M("enroll")->where($where)->find();
            Log::write("秒杀活动微信支付通知：".M()->getLastSql().json_encode($enroll));
            if($enroll){
                $enroll['status'] = 1;
                $flag = M("enroll")->save($enroll);
                if($flag){
                    $model->commit();
                }else{
                    $model->rollback();
                }
                Log::write("秒杀活动微信支付通知处理结果：".$flag.'，sql:'.M()->getLastSql());
            }
        }
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
}