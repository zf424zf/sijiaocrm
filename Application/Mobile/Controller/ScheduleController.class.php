<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 苦咖啡
// +----------------------------------------------------------------------

namespace Mobile\Controller;
use OT\DataDictionary;
use Think\Log;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ScheduleController extends MobileController {
    /**
     * s课程列表页
     */
    public function schedulelist(){
        $openid = $this->getOpenid();
        $openid_get = '';
        if(empty($openid)){
            $openid_get = I("openid");
        }else{
            $openid_get = $openid;
        }

        if(empty($openid_get)){
            echo("<script>window.location.href = 'http://suzhou.24parking.com.cn/index.php/Mobile/Userinfo/index/act/train.html'</script>");
            exit();
        }else{
            $_SESSION['openid']  = $openid_get;
            $user['openid'] = $openid;
            M("user")->add($user);
        }
        $model = M("schedule");
        $classtype = $model->field("id,classtype")->where("isdel = 0")->group("classtype")->order("id asc")->select();
        $data = array();
        foreach($classtype as $v){
            $tmps = $model->where("isdel = 0 and classtype = '".$v['classtype']."'")->group("title")->order("id asc")->select();
            foreach($tmps as &$vv){
                $tmp = $model->field("startdate")->where("isdel = 0 and title = '".$vv['title']."' and classtype = '".$v['classtype']."'")->group("startdate")->order("id asc")->select();

                $tmpstartdate = '';
                foreach($tmp as $vvv){
                    $tmpstartdate .= $vvv['startdate'].',  ';
                }

                $tmpschedule = $model->field("id,startdate,num_max,classnum,reserve")->where("isdel = 0 and title = '".$vv['title']."' and classtype = '".$v['classtype']."'")->order("id asc")->select();
                $tmpcount     = 0;
                foreach($tmpschedule as $vvv){
                    $map            = array();
                    $map['sid']     = $vvv['id'];
                    $map['status']  = 1;
                    $map['isdel']   = 0;
                    $tmpc           = M("order")->where($map)->count();//计算已经报名的人数
                    if($tmpc){
                        $tmpcount   += $vvv['num_max'] * $vvv['classnum'] - $vvv['reserve'] - $tmpc;
                    }else{
                        $tmpcount   += $vvv['num_max'] * $vvv['classnum'] - $vvv['reserve'];
                    }
                }

                $vv['count']     = $tmpcount;
                $vv['startdate'] = substr($tmpstartdate, 0, strlen($tmpstartdate) - 3);
            }
            $data[$v['id']] = $tmps;
        }
        //$data = $model->where("isdel = 0")->group("title,startdate,enddate")->order("id asc")->select();
        //print_r($data);die;
        $this->assign("classtype", $classtype);
        $this->assign("data", $data);
        $this->assign("title",'选课');
        $this->display();
    }

    /**
     * s课程详情页
     */
    public function scheduledetail(){
        $id             = I("id");
        $map['isdel']   = 0;
        $map['id']      = $id;
        $data           = M("schedule")->where($map)->find();
        $openid         = $this->getOpenid();
        $userinfo       = M("student")->where("openid = '".$openid."'")->find();
        $uid            = $userinfo['id'];

        $tmp = M("schedule")->field("startdate")->where("isdel = 0 and title = '".$data['title']."' and classtype = '".$data['classtype']."'")->group("startdate")->order("id asc")->select();
        $tmpstartdate = '';
        foreach($tmp as $vvv){
            $tmpstartdate .= $vvv['startdate'].',  ';
        }

        $data['startdate'] = substr($tmpstartdate, 0, strlen($tmpstartdate) - 3);

        $tmpcount           = 0;
        $map                = array();
        $map['title']       = $data['title'];
        $map['isdel']       = 0;
        $map['classtype']   = $data['classtype'];
        $datelist           = M("schedule")->field("id,startdate,weekinfo,hour_s,hour_e,num_min,num_max,reserve,classnum")->where($map)->group("startdate,hour_s")->select();
        $model              = M("order");
        foreach($datelist as &$v){
            $map            = array();
            $map['sid']     = $v['id'];
            $map['status']  = 1;
            $map['isdel']   = 0;
            $tmp            = $model->where($map)->count();//计算已经报名的人数
            if($tmp){
                $v['num']   = $v['num_max'] * $v['classnum'] - $v['reserve'] - $tmp;
            }else{
                $v['num']   = $v['num_max'] * $v['classnum'] - $v['reserve'];
            }
            $tmpcount       += $v['num'];
            $map            = array();
            $map['uid']     = $uid;
            $map['sid']     = $v['id'];
            $map['status']  = 1;
            $map['isdel']   = 0;
            $tmp            = $model->where($map)->find();
            if($tmp){//检测是否已报名
                $v['isbook'] = 1;
            }else{
                $v['isbook'] = 0;
            }
        }

        $data['count'] = $tmpcount;
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
        if(time() < strtotime('2017-06-20 00:00:00')){
            $data['amount_follow'] = 0;
        }

        $map            = array();
        $map['sid']     = $data['id'];
        $map['status']  = 1;
        $map['isdel']   = 0;
        $tmp            = M("order")->where($map)->count();//计算已经报名的人数

        if($tmp){
            $data['count']   = $data['num_max'] * $data['classnum'] - $data['reserve'] - $tmp;
        }else{
            $data['count']   = $data['num_max'] * $data['classnum'] - $data['reserve'];
        }

        $year = date('Y') - 7;
        for($i = $year; $i > 1960; $i--){
            $birth_year[] = $i;
        }
        for($i = 1; $i <= 12; $i++){
            $birth_month[] = $i;
        }

        $realamount = $this->getReduceByLast($data['amount']);

        $this->assign("birth_year",$birth_year);
        $this->assign("birth_month",$birth_month);
        $this->assign("realamount",$realamount);
        $this->assign("data",$data);
        $this->assign("title","确认报名");
        $this->display();
    }

    public function notice(){
        $this->assign("title","报名须知");
        $this->display();
    }

    public function expertdata(){
        $model = M("schedule");
        $data = $model->where("id >= 95")->order("id asc")->select();
        foreach($data as $v){
            unset($v['id']);
            //$v['title'] = '贵宾提高班';
            /*$v['amount'] = 1540;
            $v['amount_follow'] = 1340;
            $v['num_min'] = 5;
            $v['num_max'] = 5;
            $v['classnum'] = 3;*/
            $v['weekinfo'] = '周二、四、六';
            //$v['students'] = '2010年12月前出生（提高班能独自游10米）。';
            $id = $model->add($v);
            echo($id.'<br/>');
        }
    }
}