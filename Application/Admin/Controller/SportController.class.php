<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author catherine
 */
class SportController extends AdminController {

    /**
     * 订单管理首页
     * @author catherine
     */
    public function order(){
        $path = array('delete' => 'admin/sport/orderDelete', 'edit' => 'admin/sport/orderEdit');
        foreach ($path as $k => $v) {
            if (!$this->checkRule($v)) {
                $hidden[$k] = $v;
            }
        }
        $nickname       =   I('nickname');
        $nickname = trim($nickname);
        $map['status']  =   array('egt',0);
        $map['isdel']  =   0;
        if($_GET['sid']){
            $map['sid'] = $_GET['sid'];
        }else{
            if(is_numeric($nickname) && (strlen($nickname)==10)){
                //搜索订单查询
                $map['number'] = $nickname;
            }else {
                if (is_numeric($nickname)) {
                    $map['id'] = array(intval($nickname));
                } else {
                    $map['title'] = array('like', '%' . (string)$nickname . '%');
                }
            }
        }
        if($_GET['paytype']){
            $map['paytype'] = array('eq', $_GET['paytype']);
            $this->assign("paytype",$_GET['paytype']);
        }
        $list   = $this->lists('Order', $map,'id DESC');
        int_to_string($list);
        foreach($list as &$v){
            $smap    = array();
            $smap['id']  = $v['uid'];
            $smap['status']  = 1;
            $smap['isdel']   = 0;
            $stu_name  = M('student')->where($smap)->select();
            $cmap['id']  = $v['sid'];
            $cmap['status']  = 1;
            $cmap['isdel']   = 0;
            $v['name'] =$stu_name[0]['name'];
            $v['phone'] =$stu_name[0]['phone'];
            $sch_title  = M('schedule')->where($cmap)->select();
            $v['title'] =$sch_title[0]['title'];
            $v['classtype'] =$sch_title[0]['classtype'];
            $v['hour_s'] =$sch_title[0]['hour_s'];
            $v['hour_e'] =$sch_title[0]['hour_e'];
        }

        $this->assign('_list', $list);
        $this->assign('hidden', $hidden);
        $this->meta_title = '订单报表';
        $this->display();
    }
    function orderEdit()
    {
        $id = I("id");
        $uid = $_GET["uid"];
        $type = D('Order');
        $stu = D('Student');
        $order = $type->find($id);
        $st['id']  = $uid;
        $st['isdel']  = 0;
        $student = $stu->where($st)->find();
        $type_s = D('Schedule');
        $schedule = $type_s->find($order['sid']);
        $order['title'] = $schedule['title'];
        $order['classtype'] = $schedule['classtype'];
        $order['hour_s'] = $schedule['hour_s'];
        $order['hour_e'] = $schedule['hour_e'];
        if($order['paytime'] =='0'){
            $paytime = '';
        }else{
            $paytime = date("Y-m-d H:i:s", $order['paytime']);
        }
        $addtime = date("Y-m-d H:i:s", $order['addtime']);
        if($order['refundtime'] ==''){
            $refundtime = '';
        }else{
            $refundtime = date("Y-m-d H:i:s", $order['refundtime']);
        }
        if (IS_POST) {
            if (!$type->create()) {
                $this->error('修改订单信息失败！');
            } else {
                $status=  I("refund");
                if($status == 1){
                    $update['status'] = 3;
                    $update['refundmoney'] = $order['realamount'] - 40;
                    $update['refundtime'] = time();
                    $number =$this->createOrderNumber();
                    $update['refundnumber'] = date("Y").date("m").$number;
                }
                $update['paytype']=  I("paytype");
                $update['mark']=  I("mark");
                $m =  I("uid");
                $map['name']=  I("name");
                $map['sex']=  I("sex");
                $map['phone']=  I("phone");
                if(empty($map['name'])){
                    $this->error('学生姓名不能为空！');
                }
                if(empty($map['phone'])){
                    $this->error('手机号不能为空！');
                }

                if(!empty($map['phone'])){
                    if(!preg_match("/^1[34578]{1}\d{9}$/", $map['phone'])){
                        $this->error('请填写正确的手机号！');
                    }
                }
                $map['idcard']=  I("idcard");
                if(!empty($map['idcard'])){
                    if(!preg_match("/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/",$map['idcard'])){
                        $this->error('请填写正确的身份证号！');
                    }
                }
                $map['school']=  I("school");
                $type->where('id=' . $id)->save($update);
                $stu->where('id=' . $m)->save($map);
                $this->success('修改订单信息成功！', U('Sport/order'));

            }
        } else {
            $this->assign('refundtime', $refundtime);
            $this->assign('paytime', $paytime);
            $this->assign('addtime', $addtime);
            $this->assign('uid', $uid);
            $this->assign('order', $order);
            $this->assign('student', $student);
            $this->meta_title = '编辑订单';
            $this->display();
        }
    }

    //随机生成退款编号
    public function createOrderNumber()
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
    function orderDelete()
    {
        $id1 = array_unique((array)I('id', 0));
        $id = is_array($id1) ? implode(',', $id1) : $id1;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in', $id);
        $data['isdel'] = 1;
        $msg = array('success' => '删除成功！', 'error' => '删除失败！');
        $this->editRow('Order', $data, $map, $msg);
//        $this->deleteModel('Order', 'order');
    }


}
