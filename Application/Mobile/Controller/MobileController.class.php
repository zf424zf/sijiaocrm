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
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class MobileController extends CommonController{

    /* 空操作，用于输出404页面 */
    public function _empty(){
        $this->redirect('Index/index');
    }


    public function _initialize(){
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers:X-Requested-With, accept, content-type, xxxx');
        header('Access-Control-Allow-Methods:GET, HEAD, POST, PUT, DELETE, TRACE, OPTIONS, PATCH');
        header('Access-Control-Allow-Origin: http://127.0.0.1:8080');
//        header('Access-Control-Allow-Origin:http://fit.24parking.com.cn');

        if(CONTROLLER_NAME != 'Front'){
            //parent::_initialize();
        }
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置
    }

    /* 用户登录检测 */
    public function login(){
        /* 用户登录检测 */
        is_login() || $this->error('您还没有登录，请先登录！', U('Userinfo/login'));
    }



    /**
     * 生成用户编号
     */
    public function createUserNumber(){
        $str = time();
        $str .= $this->getRandChar(4);
        return $str;
    }

    /**
     * s生成停车优惠编码
     * @return int|string
     */
    public function createParkingNumber(){
        $str = time();
        $str .= $this->getRandChar(6);
        return $str;
    }

    /**
     * s根据日期算出是星期几
     * @param $date
     * @return mixed
     */
    public function getWeekByDate($date){
        $weekarray = array("日","一","二","三","四","五","六");
        /*$date      = str_replace('年','-',$date);
        $date      = str_replace('月','-',$date);
        $date      = str_replace('日','',$date);*/
        $result    = '周'.$weekarray[date("w",$date)];
        return $result;
    }


    /**
     * 生成二维码
     * @param $data
     * @param $filename
     * @return string
     */
    public function createQrcode($data,$filename){
        include_once("phpqrcode.php");
        $path = '/Uploads/Qrcode/'.$filename;
        \QRcode::png($data, '.'.$path, 'H',6, 1);
        return $path;
    }

    /**
     * 通过查询订单详情表来确定片区的指定时间段是否已被预订
     * @param $placeid
     * @param $dateinfo
     * @param $timeinfo
     * @param int $oid s等于0时表示是改签的订单，把之前的订单占用的片区作废
     * @return int
     */
    public function checkExist($cid, $date, $time_s, $time_e){
        $time_now    = time();
        $time_value  = strtotime($date.' '.$time_e.":00");
        if($time_now < $time_value){
            $where           = array();
            $where['date_s'] = array("elt", $date);
            $where['date_e'] = array("egt", $date);
            $where['time_s'] = array('elt', $time_s);
            $where['time_e'] = array('gt', $time_e);
            $where['cid']    = $cid;
            $schedule        = M("coachnoschedule")->where($where)->select();
            if($schedule){
                $flag = 0;
            }else{
                $where                  = array();
                $where['coachid']       = $cid;
                $where['orderdate']     = array(array("elt", $date), array("egt", $date));
                $where['ordertime_s']   = array('elt', $time_s);
                $where['ordertime_e']   = array('gt', $time_e);
                $where['status']        = array('neq', 0);
                $userschedule           = M("userschedule")->where($where)->select();
                if($userschedule){
                    $flag = 0;
                }else{
                    $flag = 1;
                }
            }
        }else{//如果已过期，则直接设置为不可预约
            $flag = 0;
        }

        return $flag;
    }

    protected function lists ($model,$where=array(),$order='',$base = array('status'=>array('egt',0)),$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){
            $model  =   M($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
            if($val===''||$val===null){
                return false;
            }else{
                return true;
            }
        });
        if( empty($options['where'])){
            unset($options['where']);
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = 20;//C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new \Think\Page($total, $listRows, $REQUEST);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;

        $model->setProperty('options',$options);

        return $model->field($field)->select();
    }

    /**
     * s获取每天的时间点
     * @return mixed
     */
    protected function getTimes($time_s = 9,$time_e = 23){
        $j = 0;
        $times = array();
        for($i = $time_s; $i <= $time_e; $i++){
            if(ceil($i) == $i){//表明是整点
                if($i < 10){
                    $i = '0'.$i;
                }
                $times[$j++] = $i.':00';
                if($i != $time_e){
                    $times[$j++] = $i.':30';
                }
            }else{
                $times[$j++] = floor($i).':30';
                $times[$j++] = ceil($i).':00';
            }
        }
        return $times;
    }

    /**
     * s获取未来指定天数的星期和日期信息，默认取一周时间
     * @param int $days
     * @return mixed
     */
    protected function getWeekAndDate($days = 7){
        for($i = 0; $i < $days; $i++){
            $day = strtotime('+'.$i.' days');
            $date[$i]['date'] = date('m月d日',$day);
            if($i == 0){
                $date[$i]['week'] = '今天';
            }else{
                $date[$i]['week'] = $this->getWeekByDate($day);
            }
        }
        return $date;
    }

    public function think_ucenter_md5($str, $key = 'ThinkUCenter'){
        return '' === $str ? '' : md5(sha1($str) . $key);
    }


    /**
     * s散票根据时间设置显示作用范围
     * @param $type
     * @param $date_s
     * @param $time_e
     * @return string
     */
    public function getDateZone($type,$date_s,$date_e){
        $date = '';
        if($type == 0){//不限
            $date = '每天';
        }elseif($type == 1){//指定星期
            $weekarray = array("日","一","二","三","四","五","六");
            if($date_s == 7){
                $date_s = 0;
            }
            if($date_e == 7){
                $date_e = 0;
            }
            $date = '周'.$weekarray[$date_s].' 至 '.'周'.$weekarray[$date_e];
        }elseif($type == 2){
            $date = '每月'.$date_s.'日 至 '.$date_e.'日';
        }elseif($type == 3){
            $date = date("Y-m-d", $date_s).' 至 '.date("Y-m-d",$date_e);;
        }
        return $date;
    }

    /**
     * s根据设置的时间显示时间范围
     * @param $time_s
     * @param $time_e
     * @return string
     */
    public function getTimeZone($time_s,$time_e){
        $time = '';
        if($time_s < 10){
            $time .= '0';
        }
        if(ceil($time_s) == $time_s){//表明是整点
            $time .= ceil($time_s).':00-';
        }else{
            $time .= (ceil($time_s) - 1).':30-';
        }

        if($time_e < 10){
            $time .= '0';
        }
        if(ceil($time_e) == $time_e){//表明是整点
            $time .= ceil($time_e).':00';
        }else{
            $time .= (ceil($time_e) - 1).':30';
        }
        return $time;
    }

    /**
     * s根据营业时间计算出预定时间段
     * @param $openzone
     * @return array
     */
    public function getOpenZone($openzone){
        $result = array();
        if($openzone){
            $times = explode('-',$openzone);
            foreach($times as $v){
                $tmp    = explode(':',$v);
                if($tmp[1] == '30'){
                    $result[] = $tmp[0] + 0.5;
                }else{
                    $result[] = $tmp[0] * 1;
                }
            }

        }
        return $result;
    }

    /**
     * s获取学号
     * @return string
     */
    public function getStudentNumber(){
        $number = date('YmdHis').$this->getRandCharNum(4);
        return $number;
    }

    /**
     * s获取订单号
     * @return string
     */
    public function getOrderNumber(){
        $number = date('Ym').$this->getRandCharNum(4);
        return $number;
    }

    /**
     * s获取卡号
     * @return string
     */
    public function getCardNumber(){
        $cardnum     = date('md').$this->getRandCharNum(4);
        return $cardnum;
    }


    /**
     * s获取微信支付订单号
     * @return string
     */
    public function getWxPayNumber(){
        $number = date('YmdHis').$this->getRandCharNum(6);
        return $number;
    }


    /**
     * s根据优惠码查询是否存在，并返回优惠金额
     */
    public function checkreduce(){
        $reducecode         = I("reducecode");
        $number             = I("number");
        M()->startTrans();
        if(empty($reducecode)){//不使用优惠码
            $result['status'] = 202;
            $res              = D("order")->updateReduceOff($number);//更新订单优惠信息
            if($res){
                M()->commit();
            }else{
                M()->rollback();
            }
        }else{
            $map['isdel']       = 0;
            $map['status']      = 0;
            $map['startdate']   = array('elt',time());
            $map['enddate']     = array('egt',time());
            $map['code']        = $reducecode;
            $reduce             = M("reduce")->where($map)->find();
            if(is_array($reduce)){
                $result['reduce'] = $reduce['reduce'];
                $result['status'] = 200;
                $res              = D("order")->updateReduceOn($number, $reduce['reduce'], $reducecode);//更新订单优惠信息
                if($res){
                    M()->commit();
                }else{
                    M()->rollback();
                }
            }else{
                $result['status'] = 201;
                $res              = D("order")->updateReduceOff($number);//更新订单优惠信息
                if($res){
                    M()->commit();
                }else{
                    M()->rollback();
                }
            }
        }


        $openid           = $this->getOpenid();
        if($openid){
            $order        = D("order")->findByNumber($number);
            //$result['order']   = $order;
            $result['paypost'] = $this->prewxpay($order['id'], $order['realamount']);
        }
        echo(json_encode($result));
    }

    public function prewxpay($id, $amount){
        $wxpaynumber     = $this->getWxPayNumber();
        $wxpay['oid']    = $id;
        $wxpay['number'] = $wxpaynumber;
        $wxpay['status'] = 0;
        $wxpay['addtime']= time();
        $wxpay['amount'] = $amount;
        $result          = M("WxpayOrder")->add($wxpay);

        if($result){
            $paypost = $this->wxPayPost($amount, $wxpaynumber);
        }else{
            $paypost = false;
        }
        return $paypost;
    }

    /**
     * s获取连报情况下的优惠后的金额
     * @param $amount
     * @return int
     */
    public function getReduceByLast($currentamount){
        $openid      = $this->getOpenid();
        $userinfo    = M("student")->where("openid='".$openid."'")->find();
        $tmporder    = D("order")->checkFollow($userinfo['id']);
        $realamount  = 0;
        if($tmporder['addtime'] < strtotime('2017-06-20 00:00:00')){//2017.6.20之前报名两个的打折
            $lastamount     = $tmporder['amount'];//$tmporder['realamount'];
            $reduceamount   = ($lastamount + $currentamount - 80) * 0.1;
            $realamount     = $currentamount - $reduceamount;
        }
        return $realamount;
    }


    public function validatephone($phone){
        if(empty($phone) || !(preg_match("/^1[34578]{1}[0-9]{9}$/",$phone))){
            $result['response'] = array(
                'code' => '100',
                'msg'  => '手机号码校验错误'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        }
    }

    public function writeRequest(){
        $log['title'] 	= $_GET;
        $log['content'] = $_POST;
        $log['file']    = $_FILES;
        Log::write('writeRequest:'.json_encode($log));
    }

    public function writeRequestResult($result){
        $log['title'] 	= $_GET;
        $log['content'] = $result;
        Log::write('writeRequestResult:'.json_encode($log));
    }


    //发送短信验证码
    public  function sendCode($phone, $code){
        $post_data              = array();
        $post_data['userid']    = 1103;
        $post_data['account']   = 'HSBXX';
        $post_data['password']  = 'Heisenberg2016';
        $post_data['content']   = '【卓赢体育】您的短信验证码为'.$code.'，有效时间10分钟，请尽快输入。';
        $post_data['mobile']    = $phone;
        $post_data['sendtime']  = '';

        Log::write('发送验证码，内容:'.json_encode($post_data));
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
            return true;
        }else{
            return false;
        }
    }

    public function sendTmplMsg($msgid, $openid, $items, $url){
        $color = '#173177';
        $data = array();
        $data['touser'] = $openid;
        $data['template_id'] = $msgid;
        $data["url"] = $url;
        $data["topcolor"] = "#FF0000";
        $datas = array();
        foreach ($items as $key => $item) {
            $datas[$key]['value'] = $item['value'];
            $datas[$key]['color'] = $item['color'] ? $item['color'] : $color;
        }

        $data['data'] = $datas;
        return $data;
    }
}
