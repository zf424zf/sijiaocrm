<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: catherine
// +----------------------------------------------------------------------

namespace Mobile\Controller;

use User\Api\UserApi;
use Think\Log;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class FrontController extends MobileController
{

    public function login()
    {
        $safedays = time() - strtotime('2014-7-8');
        $this->assign("secs", $safedays);
        /*$year     = $safedays / (24 * 60 * 60 * 365);
        echo $year.'_';
        echo floor($year).'<br/>';
        $tmp = $safedays % (24 * 60 * 60 * 365);
        echo $tmp.'_';
        $days = $tmp / (24 * 60 * 60);
        echo $days;
        die;*/
        if ($_POST) {
            header("Content-type: text/html; charset=utf-8");
            $username = I("username");
            $password = I("password");

            if (empty($username) || empty($password)) {
                $this->error("用户名或密码不能为空");
            }
            $User = new UserApi;
            $uid = $User->login($username, $password);

            if (0 < $uid) { //登录成功
                /* 登录用户 */
                $Member = D('Member');
                if ($Member->login($uid)) { //登录用户

                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('Front/index'));
                } else {
                    $this->error($Member->getError());
                }

            } else { //登录失败
                switch ($uid) {
                    case -1:
                        $error = '用户不存在或被禁用！';
                        break; //系统级别禁用
                    case -2:
                        $error = '密码错误！';
                        break;
                    default:
                        $error = '未知错误！';
                        break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            $this->display();
        }
    }

    /* 退出登录 */
    public function logout()
    {
        if (is_login()) {
            D('Member')->logout();
            $this->success('退出成功！', U('Front/login'));
        } else {
            $this->redirect('Front/login');
        }
    }

    //主界面 课程列表页
    public function index()
    {
        $user = session('user_auth');
        is_login() || $this->error('您还没有登录，请先登录！', U('Front/login'));
        // $user['sport_rule'] || $this->error('当前账号没有权限！', U('Front/login'));

        $title = I('title');
        $title = trim($title);
        $groupSql = M("schedule");
        $classTypes = $groupSql->group('classType')->getField('classType', true);
        $classNames = $groupSql->group('title')->getField('title', true);
        $weekInfos = $groupSql->group('weekinfo')->getField('weekinfo', true);
        $scheduleQuery = M("schedule");
        $q = '1 = 1 ';
        if (is_numeric($title) && (strlen($title) == 10)) {
            //搜索订单查询
            $sid = M("order")->field("sid")->where("number = $title")->find();
            $sid = intval($sid['sid']);
            $q .= "id=$sid";
            //$sql = M()->getLastSql();
        } else {
            //搜索id 和课程 查询
            if (is_numeric($title) && $title != null) {  //ID查询
                $q .= "id=$title";
            } elseif (empty($title)) {                   //空值查询
                //$q .= "isdel = 0";
                // $sql = M()->getLastSql();
            } else {
                $q .= "title like '%$title%'";//班级查询
            }
        }

        $classType = I('classType');
        if ($classType && $classType != 'all') {
            $q .= " and classtype = '$classType'";
        }
        $className = I('className');
        if ($className && $className != 'all') {
            $q .= " and " . "title = '$className'";
        }
        $weekInfo = I('weekinfo');
        if ($weekInfo && $weekInfo != 'all') {
            $q .= " and " . "weekinfo = '$weekInfo'";
        }
        $data = $scheduleQuery->where($q)->group("id")->order("id asc")->select();
        $model = M("order");
        foreach ($data as $k => $v) {
            $condition['id'][] = intval($v['id']);
        }
        //$condition 空值不设查询
        if ($condition) {
            $condition['id'][] = 'or';
            $list = $this->lists('schedule', $condition, 'id ASC');
        } else {
            $list = array();
        }
        foreach ($list as &$v) {
            $map = array();
            $map['sid'] = $v['id'];
            $map['status'] = 1;
            $tmp = $model->where($map)->count();
            if ($tmp) {
                $v['num'] = $v['num_max'] * $v['classnum'] - $v['reserve'] - $tmp;
            } else {
                $v['num'] = $v['num_max'] * $v['classnum'] - $v['reserve'];
            }
            if ($v['num'] < 0) {
                $v['num'] = 0;
            }
            $v['tmp'] = $tmp;
            $time = time();
            /*if((strtotime($v['startdate'])>=$time) && (strtotime($v['enddate'] <=$time))){
                $v['msg']   =  '开班中';
            }elseif(strtotime($v['enddate'])>$time){
                $v['msg']   =  '已结束';
            }else{
                $v['msg']   =  '等待开班';
            }*/
            if($v['isdel'] == 1){
                $v['msg'] = '已关闭';
            }else{
                if (strtotime($v['startdate']) > $time) {
                    $v['msg'] = '等待开班';
                } else {
                    $v['msg'] = '开班中';
                }
            }

            if (($v['amount_follow']) > 0) {
                $v['x_amount'] = $v['amount_follow'];
            } else {
                $v['x_amount'] = $v['amount'];
            }
            if ($v['num_min'] == $v['num_max']) {
                $v['num_d'] = $v['num_max'] * $v['classnum'];
            } else {
                $v['num_d'] = $v['num_max'] * $v['classnum'];
            }
        }
        $year = date('Y') - 7;
        for ($i = $year; $i > 1960; $i--) {
            $birth_year[] = $i;
        }
        for ($i = 1; $i <= 12; $i++) {
            $birth_month[] = $i;
        }
        $this->assign("birth_year", $birth_year);
        $this->assign("birth_month", $birth_month);
        $this->assign("classTypes", $classTypes);
        $this->assign("classNames", $classNames);
        $this->assign("weekInfos", $weekInfos);
        $this->assign('_list', $list);
        $this->assign("title", '选课');
        $this->display();
    }


    /**
     *报名订单
     */

    /**
     *报名订单
     */
    public function signOrder()
    {
        //  Log::write('报名订单请求参数：'.json_encode($_REQUEST));
        $data['name'] = I("name");
        $sale = I("sale");
        $xtype = I("xtype");
        $amount_follow = I("amount_follow");
        $data['birthinfo'] = I("birthinfo");
        $data['sex'] = I("sex");
        $data['phone'] = I("phone");
        $data['idcard'] = I("idcard");
        $data['school'] = I("school");
        $data['addtime'] = time();
        $data['cardnum'] = $this->getCardNumber();
        $data['number'] = $this->getStudentNumber();
        $discount = I("discount");
        $wheres['name'] = I("name");
        $wheres['phone'] = I("phone");
        $sid = intval(I("sid"));
        $where['code'] = $discount;
        $where['status'] = 0;
        $where['isdel'] = 0;
        $data1['reduce'] = '';
        $data1['mark'] = I("order_mark");
        $number = $this->createOrderNumber();
        $data1['number'] = date("Y") . date("m") . $number;
        $data1['paytime'] = time();
        $time = time();
        /*优惠码后端检测*/
        $findreduce = M('reduce')->where($where)->find();
        if (!empty($discount)) {
            if ($findreduce['id']) {
                if ($data['addtime'] >= $findreduce['startdate'] && $data['addtime'] <= $findreduce['enddate']) {
                    $data1['reduce'] = $findreduce['reduce'];
                } else {
                    $result['status'] = 201;
                    $result['msg'] = '优惠码已过期';
                    echo(json_encode($result));
                    exit;
                }
            } else {
                $result['status'] = 201;
                $result['msg'] = '无此优惠码';
                echo(json_encode($result));
                exit;
            }
        }
        $data2['id'] = $sid;
        $finds = M('student')->where($wheres)->find();
            if ($finds) {
                $w_order['uid'] = $finds['id'];
                $w_order['status'] = 1;
                $w_order['isdel'] = 0;
                $w_order['sid'] = array('neq',$sid);
                $r_order = M('order')->where($w_order)->count();
                if ($r_order>0) {
                    $count = $r_order;
                }else{
                    $count =0;
                }
            }else{
                $count =0;
            }
        /*课程后端检测*/
        $findsid = M('schedule')->where($data2)->find();
        if ($findsid) {
            $data1['sid'] = $sid;
            $data1['amount'] = $findsid['amount'];
            $data1['reduceamount'] = $data1['reduce'];
            $data1['paytype'] = I("paytype");
            $data1['status'] = 1;
            $data1['reducecode'] = $discount;
            $data1['addtime'] = time();
            if ($findsid['amount_follow'] > 0) {
                $data1['type'] = '1';
            }
            $paysale = I('paysale');
            if($paysale>1){
                $amount = $data1['amount'] - 40;
                if($paysale == 2){
                    $realamount = $amount*0.95 + 40;
                    $reduceamount =$amount*0.05;
                }elseif($paysale == 3){
                    $realamount = $amount*0.9 + 40;
                    $reduceamount =$amount*0.1;
                }elseif($paysale == 4){
                    $realamount = $amount*0.85 + 40;
                    $reduceamount =$amount*0.15;
                }elseif($paysale == 5){
                    $realamount = $amount*0.8 + 40;
                    $reduceamount =$amount*0.2;
                }
                $data1['realamount'] = $realamount;
                $data1['reduceamount'] =$reduceamount;
                $data1['reducecode'] ='';
            }else{
                if ($data1['amount'] > $data1['reduceamount']) {
                    if ($sale >0) {
                        $data1['reduceamount'] = $sale + $data1['reduce'];
                    } else if ($findsid['amount_follow'] > 0 && $count >0) {
                        $data1['reduceamount'] = $findsid['amount'] - $findsid['amount_follow'] + $data1['reduce'];
                    } else {
                        $data1['reduceamount'] = $data1['reduce'];
                    }
                    $data1['realamount'] = $data1['amount'] - $data1['reduceamount'];
                } else {
                    $data1['realamount'] = 0;
                }
            }
        } else {
            $result['status'] = 201;
            $result['msg'] = '未获取课程ID';
            echo(json_encode($result));
            exit;
        }
        $finds = M('student')->where($wheres)->find();
        /*学生信息是否重复后端检测*/
        if ($finds) {
            $data1['uid'] = $finds['id'];
            $whereo['uid'] = $finds['id'];
            $whereo['status'] = 1;
            $whereo['isdel'] = 0;
            $whereo['sid'] = $sid;
            $findo = M('order')->where($whereo)->find();
            if ($findo) {
                $result['status'] = 201;
                $result['msg'] = '您已经报过此课程了';
                echo(json_encode($result));
                exit;
            } else {
                $resultid2 = M('order')->data($data1)->add();
            }
        } else {
            $resultid = M('student')->data($data)->add();
            if ($resultid) {
                $data1['uid'] = $resultid;
                $resultid2 = M('order')->data($data1)->add();
            } else {
                $result['status'] = 201;
                $result['msg'] = '未获取学生ID';
                echo(json_encode($result));
                exit;
            }
        }
        //var_dump($data1);exit;
        if ($resultid2) {
            $result['status'] = 200;
            $result['msg'] = '报名成功';
            echo(json_encode($result));
            exit;
        } else {
            $result['status'] = 201;
            $result['msg'] = '报名失败';
            echo(json_encode($result));
            exit;
        }
    }

    /*
     * 弹窗课程信息
     * */
    public function msgSchedule()
    {
        $sid = I("sid");
        $order = M('schedule')->where("id=$sid")->find();
        $time = time();
        if ($order) {
            $data['classtype'] = $order['classtype'];
            $data['title'] = $order['title'];
            $data['cname'] = $order['cname'];
            $data['weekinfo'] = $order['weekinfo'];
            $data['amount'] = $order['amount'];
            $data['amount_follow'] = $order['amount_follow'];
            $data['mark'] = $order['mark'];
            $data['students'] = $order['students'];
            $data['nums'] = $order['nums'];
            if (strtotime($order['startdate']) > $time) {
                $data['msg'] = '等待开班';
                $data['status'] = '2';
            } else {
                $data['msg'] = '开班中';
                $data['status'] = '1';
            }
            $data['time_d'] = $order['startdate'];
            $data['hour_d'] = $order['hour_s'] . "-" . $order['hour_e'];
            $map = array();
            $map['sid'] = $sid;
            $map['status'] = 1;
            $map['isdel'] = 0;
            $model = M("order");
            $tmp = $model->where($map)->count();

            if ($tmp) {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'] - $tmp;
            } else {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'];
            }
            if ($data['num'] < 0) {
                $data['num'] = 0;
            }
            if ($order['num_min'] == $order['num_max']) {
                $data['num_d'] = $order['num_max'];
            } else {
                $data['num_d'] = $order['num_min'] . "-" . $order['num_max'];
            }
            $result['status'] = 200;
            $result['data'] = $data;

            //   var_dump($data);
        } else {
            $result['status'] = 201;
            $result['msg'] = '无此课程ID';
        }
        echo(json_encode($result));
    }

    /*
    * 优惠码验证
    * */
    public function checksale()
    {
        $sid = I("sid");
        $where['name'] = I("name");
        $where['phone'] = I("phone");
        $where['isdel'] = 0;
        $result1 = M('student')->where($where)->find();
        $time = time();
        if ($result1) {
            $w_order['uid'] = $result1['id'];
            $w_order['status'] = 1;
            $w_order['isdel'] = 0;
            $w_order['sid'] = array('neq',$sid);
            $r_order = M('order')->where($w_order)->order('id desc')->find();
            $new_order['uid'] = $result1['id'];
            $new_order['status'] = 1;
            $new_order['isdel'] = 0;
            $new_order['sid'] = array('neq',$sid);
            $new_count = M('order')->where($w_order)->count();
            if ($r_order) {
                //6月20号之前第二次报名
                if ($r_order['addtime'] <= strtotime('2017/6/20 0:0:0') && $time <= strtotime('2017/6/20 0:0:0')) {
                    $result['status'] = 200;
                    $result['realamount'] = $r_order['amount'];
                    $result['amount_follow'] = 0;
                    $result['xtype'] = 2;
                    $result['msg'] = '恭喜您，6月20号之前第二次报名可享受9折优惠哦！';
                } else {
                    $result['status'] = 200;
                    $w_schedule['id'] = $sid;
                    $r_schedule = M('schedule')->where($w_schedule)->find();
                    //6月20号之后第二次报名 并且 有续办价格的 amount_follow 续班价格
                    if ($r_schedule && ($r_schedule['amount_follow'] > 0) && $new_count>0) {
                        $result['xtype'] = 2;
                        $result['status'] = 200;
                        $result['amount_follow'] = $r_schedule['amount_follow'];
                        $result['realamount'] = 0;
                        $result['msg'] = '恭喜您，第二次报名可享受续班价格哦！';
                    } else {
                        //6月20号之后第二次报名并不享受
                        $result['amount_follow'] = 0;
                        $result['realamount'] = 0;
                        $result['status'] = 200;
                    }
                }
            } else {
                $result['xtype'] = 1;
                $result['amount_follow'] = 0;
                $result['realamount'] = 0;
                $result['status'] = 200;
                //$result['msg']    = '首次报名1';
            }
        } else {
            $result['amount_follow'] = 0;
            $result['realamount'] = 0;
            $result['status'] = 200;
            //$result['msg']    = '首次报名2';
        }

        echo(json_encode($result));
        exit;
    }

    /*
     * 优惠码验证
     * */
    public function checkreduce()
    {
        $where['code'] = I("code");
        $where['status'] = 0;
        $where['isdel'] = 0;
        $result1 = M('reduce')->where($where)->find();
        $time = time();
        if (!empty($where['code'])) {
            if ($result1) {
                if ($time >= $result1['startdate'] && $time <= $result1['enddate']) {
                    $result['status'] = 200;
                    $result['reduce'] = $result1['reduce'];
                    $result['msg'] = '恭喜您，报名可优惠￥' . $result1['reduce'] . '元哦！';
                } else {
                    $result['reduce'] = 0;
                    $result['status'] = 201;
                    $result['msg'] = '很抱歉哦,优惠码已过期';
                }
            } else {
                $result['reduce'] = 0;
                $result['status'] = 201;
                $result['msg'] = '很抱歉哦，无此优惠码';
            }
        } else {
            $result['reduce'] = 0;
            $result['status'] = 201;
            $result['msg'] = '很抱歉哦，无此优惠码';
        }

        echo(json_encode($result));
        exit;
    }

    /*
     * 查看报名详情列表
     */
    public function getOrderByAjax()
    {
        $map['sid'] = I("sid");
        $map['isdel'] = 0;
        $map['status'] = 1;
        $result = M('order')->field("uid,number,isget")->where($map)->group("uid")->order("uid asc")->select();
        foreach ($result as &$v) {
            $v['m'] = $this->getStudentByAjax($v['uid']);
        }
        $this->ajaxReturn($result);
    }

    /*
   * 领取体验卷
   */
    public function checkLiveByAjax()
    {
        $map['sid'] = I("sid");
        $map['uid'] = I("uid");
        $map['isdel'] = 0;
        $map['status'] = 1;
        $data['isget'] = 1;
        $result = M('order')->where($map)->find();
        if ($result) {
            $update = M('order')->where($map)->save($data);
            if ($update) {
                $result['status'] = 200;
                $result['msg'] = '恭喜您，领取成功';
            } else {
                $result['status'] = 201;
                $result['msg'] = '领取出错请重试';
            }
        } else {
            $result['status'] = 201;
            $result['msg'] = '领取出错请重试1';
        }
        echo(json_encode($result));
        exit;
    }

    /*
* 查看学生信息
* */
    public function getStudentByAjax($id)
    {
        $map['id'] = $id;
        $map['isdel'] = 0;
        $result = M('student')->field("id,name,sex,birthinfo,phone")->where($map)->group("id")->order("id asc")->select();
        foreach ($result as &$v) {
            if ($v['sex'] == 0) {
                $v['sex'] = '男';
            } else {
                $v['sex'] = '女';
            }
        }
        return $result;
    }

    //随机生成订单编号
    public function createOrderNumber()
    {
        $map['isdel'] = 0;
        $rs = M('order')->field('number')->where($map)->select();
        foreach ($rs as &$v) {
            $v['number'] = substr($v['number'], -4);
        }
        $ids = array_column($rs, 'number');
        $ids = implode(',', $ids);
        $code = array_diff(range(1000, 9999), explode(',', $ids));
        $code = current($code);
        return $code;

    }

    //转课 课程列表
    public function change()
    {
        $oldsid = intval($_GET['sid']);
        $uid = intval($_GET['id']);
        $user = session('user_auth');
        is_login() || $this->error('您还没有登录，请先登录！', U('Front/login'));
        // $user['sport_rule'] || $this->error('当前账号没有权限！', U('Front/login'));
        $title = I('title');
        $title = trim($title);
        if (is_numeric($title) && (strlen($title) == 10)) {
            $sid = M("order")->field("sid")->where("number = $title and sid != $oldsid")->find();
            $sid = intval($sid['sid']);
            $data = M("schedule")->where("id=$sid")->group("id")->order("id asc")->select();
            //$sql = M()->getLastSql();
            // var_dump($sql);
        } else {
            //搜索查询
            if (is_numeric($title) && $title != null) {  //ID查询
                $data = M("schedule")->where("id=$title and id != $oldsid")->group("id")->order("id asc")->select();
            } elseif (empty($title)) {                   //空值查询
                $data = M("schedule")->where("id != $oldsid")->group("id")->order("id asc")->select();
                $sql = M()->getLastSql();
            } else {                                      //班级查询
                $data = M("schedule")->where("id != $oldsid and title like '%$title%'")->group("id")->order("id asc")->select();
            }
        }
        $model = M("order");
        foreach ($data as $k => $v) {
            $condition['id'][] = intval($v['id']);
        }
        //$condition 空值不设查询
        if ($condition) {
            $condition['id'][] = 'or';
            $list = $this->lists('schedule', $condition, 'id ASC');
        } else {
            $list = array();
        }

        $count_order = M('order')->where("uid= $uid and isdel=0 and sid !=$oldsid and status=1")->count();
        foreach ($list as &$v) {
            $map = array();
            $map['sid'] = $v['id'];
            $map['status'] = 1;
            $map['isdel'] = 0;
            $tmp = $model->where($map)->count();
            if ($tmp) {
                $v['num'] = $v['num_max'] * $v['classnum'] - $v['reserve'] - $tmp;
            } else {
                $v['num'] = $v['num_max'] * $v['classnum'] - $v['reserve'];
            }
            if ($v['num'] < 0) {
                $v['num'] = 0;
            }
            $v['tmp'] = $tmp;
            $time = time();
            if($v['isdel'] == 1){
                $v['msg'] = '已关闭';
            }else{
                if (strtotime($v['startdate']) > $time) {
                    $v['msg'] = '等待开班';
                } else {
                    $v['msg'] = '开班中';
                }
            }

            if (($v['amount_follow']) > 0 && $count_order>0) {
                $v['x_amount'] = $v['amount_follow'];
            } else {
                $v['x_amount'] = $v['amount'];
            }
            if ($v['num_min'] == $v['num_max']) {
                $v['num_d'] = $v['num_max'] * $v['classnum'];
            } else {
                $v['num_d'] = $v['num_max'] * $v['classnum'];
            }
        }

        $this->assign('_list', $list);
//        $this->assign("data", $data);
        $this->assign("title", '选课');
        $this->assign("uid", $uid);
        $this->assign("oldsid", $oldsid);
        $this->display();
    }

    /**
     *报名订单
     */
    public function changeOrder()
    {
        $sid = intval(I("sid"));
        $uid = intval(I("uid"));
        $oldsid = intval(I("oldsid"));
        $reson = trim(I("reson"));
        $sale = I("sale");
        $xtype = I("xtype");
        $amount_follow = I("amount_follow");
        $data['addtime'] = time();
        $discount = I("discount");
        $wheres['uid'] = $uid;
        $wheres['isdel'] = 0;
        $where['code'] = $discount;
        $where['status'] = 0;
        $where['isdel'] = 0;
        $data1['reduce'] = '';
        $number = $this->createOrderNumber();
        $data1['number'] = date("Y") . date("m") . $number;
        $data1['paytime'] = time();
        $data1['imbalance'] = I("change_money");
        $data1['imstatus'] = I("imstatus");
        if ($data1['imstatus'] == 1) {
            $data1['imbalance'] = '-' . $data1['imbalance'];
        }
        /*优惠码后端检测*/
        $findreduce = M('reduce')->where($where)->find();
        if (!empty($discount)) {
            if ($findreduce['id']) {
                if ($data['addtime'] >= $findreduce['startdate'] && $data['addtime'] <= $findreduce['enddate']) {
                    $data1['reduce'] = $findreduce['reduce'];
                } else {
                    $result['status'] = 201;
                    $result['msg'] = '优惠码已过期';
                    echo(json_encode($result));
                    exit;
                }
            } else {
                $result['status'] = 201;
                $result['msg'] = '无此优惠码';
                echo(json_encode($result));
                exit;
            }
        }
        $data2['id'] = $sid;
        /*课程后端检测*/
        $findsid = M('schedule')->where($data2)->find();
        if ($findsid) {
            $data1['sid'] = $sid;
            $data1['amount'] = $findsid['amount'];
            $data1['reduceamount'] = $data1['reduce'];
            $data1['paytype'] = I("paytype");
            $data1['status'] = 1;
            $data1['reducecode'] = $discount;
            $data1['addtime'] = time();
            if ($findsid['amount_follow'] > 0) {
                $data1['xtype'] = '1';
            }
            $paysale = I('paysale');
            if($paysale>1){
                if($paysale == 2){
                    $realamount = $data1['amount']*0.95;
                    $reduceamount =$data1['amount']*0.05;
                }elseif($paysale == 3){
                    $realamount = $data1['amount']*0.9;
                    $reduceamount =$data1['amount']*0.1;
                }elseif($paysale == 4){
                    $realamount = $data1['amount']*0.85;
                    $reduceamount =$data1['amount']*0.15;
                }elseif($paysale == 5){
                    $realamount = $data1['amount']*0.8;
                    $reduceamount =$data1['amount']*0.2;
                }
                $data1['realamount'] = $realamount;
                $data1['reduceamount'] =$reduceamount;
                $data1['reducecode'] ='';
            }else{
                if ($data1['amount'] > $data1['reduceamount']) {
                    if ($sale >= 0) {
                        $data1['reduceamount'] = $sale + $data1['reduce'];
                    } else if ($amount_follow >= 0) {
                        $data1['reduceamount'] = $findsid['amount'] - $amount_follow + $data1['reduce'];
                    } else {
                        $data1['reduceamount'] = $data1['reduce'];
                    }
                    $data1['realamount'] = $data1['amount'] - $data1['reduceamount'];
                } else {
                    $data1['realamount'] = 0;
                }
            }
        } else {
            $result['status'] = 201;
            $result['msg'] = '未获取课程ID';
            echo(json_encode($result));
            exit;
        }

        $finds = M('student')->where($wheres)->find();
        /*学生信息是否重复后端检测*/
        if ($finds) {
            $data1['uid'] = $uid;
            $whereo['uid'] = $uid;
            $whereo['status'] = 1;
            $whereo['isdel'] = 0;
            $whereo['sid'] = $sid;
            $findo = M('order')->where($whereo)->find();
            if ($findo) {
                $result['status'] = 201;
                $result['msg'] = '您已经报过此课程了';
                echo(json_encode($result));
                exit;
            } else {
                $resultid2 = M('order')->data($data1)->add();
            }
        } else {
            $resultid = M('student')->data($data)->add();
            if ($resultid) {
                $data1['uid'] = $resultid;
                $resultid2 = M('order')->data($data1)->add();
            } else {
                $result['status'] = 201;
                $result['msg'] = '未获取学生ID';
                echo(json_encode($result));
                exit;
            }
        }
        $where_oldsid['uid'] = $uid;
        $where_oldsid['isdel'] = 0;
        $where_oldsid['sid'] = $oldsid;
        $where_oldsid['status'] = 1;
        $find_oldsid = M('order')->where($where_oldsid)->find();
        /*学生信息是否重复后端检测*/
        $result['status'] = 201;
        $result['msg'] = '查无原课程';
        if ($find_oldsid) {
            $res_data['status'] = 3;
            $res_data['refundmoney'] = $find_oldsid['realamount'];
            $res_data['refundtime'] =  time();
            $number =$this->createOrderRefunNumber();
            $res_data['refundnumber'] =  date("Y").date("m").$number;

            $res_data['reson'] = $reson;
            $res_old = M('order')->where($where_oldsid)->save($res_data);
        } else {
            $result['status'] = 201;
            $result['msg'] = '查无原课程';
            echo(json_encode($result));
            exit;
        }
        if ($resultid2 && $res_old) {
            $result['status'] = 200;
            $result['msg'] = '转课成功';
            echo(json_encode($result));
            exit;
        } else {
            $result['status'] = 201;
            $result['msg'] = '转课失败';
            echo(json_encode($result));
            exit;
        }
    }
    //随机生成退款编号
    public function createOrderRefunNumber()
    {
        $map['isdel']      = 0;
        $rs =M('order')->field('refundnumber')->where($map)->select();
        foreach($rs as &$v){
            $v['refundnumber']=substr($v['refundnumber'],-4);
        }
        $ids = array_column($rs, 'refundnumber');
        $ids = implode(',', $ids);
        $code = array_diff(range(1000, 9999), explode(',', $ids));
        $code=  current($code);
        return $code;

    }
    //转课 原课程
    public function oldClass()
    {
        $sid = I("sid");
        $uid = I("uid");
        $student = M('student')->where("id=$uid")->find();
        if ($student) {
            $data['name'] = $student['name'];
            $data['phone'] = $student['phone'];
            $data['birthinfo'] = $student['birthinfo'];
        }
        $order = M('schedule')->where("id=$sid")->find();
        $student_order = M('order')->where("isdel=0 and uid=$uid and sid =$sid and status=1")->find();
        if ($order && $student_order) {
            $data['classtype'] = $order['classtype'];
            $data['title'] = $order['title'];
            $data['cname'] = $order['cname'];
            $data['weekinfo'] = $order['weekinfo'];
            $data['amount'] = $order['amount'];
            $data['mark'] = $order['mark'];
            $data['students'] = $order['students'];
            $data['nums'] = $order['nums'];
            $data['realamount'] = $student_order['realamount'];
            $time = time();
            if (strtotime($order['startdate']) > $time) {
                $data['msg'] = '等待开班';
                $data['status'] = '2';
            } else {
                $data['msg'] = '开班中';
                $data['status'] = '1';
            }
            // $data['time_d']= $order['startdate']."-".$order['enddate'];
            $data['time_d'] = $order['startdate'];
            $data['hour_d'] = $order['hour_s'] . "-" . $order['hour_e'];
            $map = array();
            $map['sid'] = $sid;
            $map['status'] = 1;
            $map['isdel'] = 0;
            $model = M("order");
            $tmp = $model->where($map)->count();
            $data['time'] = time();
            if ($order['amount_follow'] > 0 && $time < strtotime('2017/6/20 0:0:0')) {
                $data['amount'] = $order['amount_follow'];
            } else {
                $data['amount'] = $order['amount'];
            }
            if ($tmp) {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'] - $tmp;
            } else {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'];
            }
            if ($data['num'] < 0) {
                $data['num'] = 0;
            }
            if ($order['num_min'] == $order['num_max']) {
                $data['num_d'] = $order['num_max'];
            } else {
                $data['num_d'] = $order['num_min'] . "-" . $order['num_max'];
            }
            $result['status'] = 200;
            $result['data'] = $data;

            //   var_dump($data);
        } else {
            $result['status'] = 201;
            $result['msg'] = '无此课程ID';
        }
        echo(json_encode($result));
    }

    //转课 新课程
    public function newClass()
    {
        $uid =  I("uid");
        $sid = I("sid");
        $order = M('schedule')->where("id=$sid")->find();
        $time =time();
        if ($order) {
            $data['classtype'] = $order['classtype'];
            $data['title'] = $order['title'];
            $data['cname'] = $order['cname'];
            $data['weekinfo'] = $order['weekinfo'];
            $data['amount'] = $order['amount'];
            $data['amount_follow'] = $order['amount_follow'];
            $o_count = M('order')->where("uid=$uid and status =1")->count();
            if ($order['amount_follow'] > 0 && $time < strtotime('2017/6/20 0:0:0') && $o_count>1) {
                $data['amount_follow'] = $order['amount_follow'];
            } elseif($o_count>1 && $order['amount_follow'] > 0) {
                $data['amount_follow'] = $order['amount_follow'];
            }else{
                $data['amount_follow'] = 0;
            }
            $data['mark'] = $order['mark'];
            $data['students'] = $order['students'];
            $data['nums'] = $order['nums'];
            $time = time();
            if (strtotime($order['startdate']) > $time) {
                $data['msg'] = '等待开班';
                $data['status'] = '2';
            } else {
                $data['msg'] = '开班中';
                $data['status'] = '1';
            }
            $data['time_d'] = $order['startdate'];
            $data['hour_d'] = $order['hour_s'] . "-" . $order['hour_e'];
            $map = array();
            $map['sid'] = $sid;
            $map['status'] = 1;
            $map['isdel'] = 0;
            $model = M("order");
            $tmp = $model->where($map)->count();

            if ($tmp) {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'] - $tmp;
            } else {
                $data['num'] = $order['num_max'] * $order['classnum'] - $order['reserve'];
            }
            if ($data['num'] < 0) {
                $data['num'] = 0;
            }
            if ($order['num_min'] == $order['num_max']) {
                $data['num_d'] = $order['num_max'];
            } else {
                $data['num_d'] = $order['num_min'] . "-" . $order['num_max'];
            }
            $data['time'] = time();
            $result['status'] = 200;
            $result['data'] = $data;
        } else {
            $result['status'] = 201;
            $result['msg'] = '无此课程ID';
        }
        echo(json_encode($result));
    }

    /*
 * 换课 优惠验证
 * */

    public function checkChange()
    {
        $sid = I("sid");
        $oldsid = I("oldsid");
        $uid = I("uid");
        $where['isdel'] = 0;
        $where['id'] = $uid;
        $result1 = M('student')->where($where)->find();
        $time = time();
        $result['time'] = time();
        $m_order = M('order')->where("uid= $uid and isdel=0 and sid =$oldsid")->find();
        $x_order = M('schedule')->where("id =$sid")->find();
        $o_order = M('schedule')->where("id =$oldsid")->find();
        if ($result1 && $o_order && $m_order && $x_order) {
            $w_order['status'] = 1;
            $w_order['isdel'] = 0;
            $r_order = M('order')->where("uid= $uid and isdel=0 and sid !=$oldsid and status=1")->order("id desc")->find();
            if ($r_order) {
                //6月20号之前第二次报名
                if ($r_order['addtime'] <= strtotime('2017/6/20 0:0:0') && $time <= strtotime('2017/6/20 0:0:0')) {
                    $result['status'] = 1;
                    $result['realamount'] = $r_order['amount'];
                    $result['amount_follow'] = 0;
                    $result['xtype'] = 2;
                    $result['msg'] = '恭喜您，6月20号之前第二次报名可享受9折优惠哦！';
                } else {
                    $w_schedule['id'] = $sid;
                    $w_schedule['isdel'] = 0;
                    $r_schedule = M('schedule')->where($w_schedule)->find();
                    //6月20号之后第二次报名 并且 有续办价格的 amount_follow 续班价格
                    if ($r_schedule && ($r_schedule['amount_follow'] > 0)) {
                        $result['xtype'] = 1;
                        $result['status'] = 2;
                        $result['type'] = 2;
                        $result['amount_follow'] = $r_schedule['amount_follow'];
                        $result['realamount'] = 0;
                        $result['msg'] = '恭喜您，第二次报名可享受续班价格哦！';
                    } else {
                        //6月20号之后第二次报名并不享受
                        $result['amount_follow'] = 0;
                        $result['realamount'] = 0;
                        $result['status'] = 2;
                    }
                }
            } else {
                $result['amount_follow'] = 0;
                $result['realamount'] = 0;
                $result['status'] = 3;
                //$result['msg']    = '首次报名1';
            }
        } else {
            $result['amount_follow'] = 0;
            $result['realamount'] = 0;
            $result['status'] = 201;
            //$result['msg']    = '首次报名2';
        }
        $result['realpay'] = $m_order['realamount'];
        $count_order = M('order')->where("uid= $uid and isdel=0 and sid !=$oldsid and status=1")->count();
        if ($o_order['amount_follow'] > 0 && ($time < strtotime('2017/6/20 0:0:0')) && $count_order>0) {
            $result['y_amount'] = $o_order['amount_follow'];
        } elseif($o_order['amount_follow'] >0 &&  $o_order>0) {
            $result['y_amount'] = $o_order['amount_follow'];
        }else {
            $result['y_amount'] = $o_order['amount'];
        }
        if ($x_order['amount_follow'] > 0 && $time < strtotime('2017/6/20 0:0:0') && $count_order>0) {
            $result['x_amount'] = $x_order['amount_follow'];
        } elseif($x_order['amount_follow'] >0 &&  $count_order>0) {
            $result['x_amount'] = $x_order['amount_follow'];
        }else {
            $result['x_amount'] = $x_order['amount'];
        }
        $result['amount'] = $x_order['amount'];
        echo(json_encode($result));
        exit;
    }
}
