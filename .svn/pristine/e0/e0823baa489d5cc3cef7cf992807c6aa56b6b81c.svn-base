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
class 	CourseController extends AdminController
{

    /**
     * 课程信息管理首页
     * @author catherine
     */
    public function index()
    {
        $path = array('delete' => 'admin/Course/indexDel', 'edit' => 'admin/Course/indexEdit','add' => 'admin/Course/indexAdd');
        foreach ($path as $k => $v) {
            if (!$this->checkRule($v)) {
                $hidden[$k] = $v;
            }
        }
        $nickname = I('nickname');
        $nickname = trim($nickname);
        //$map['status'] = array('egt', 0);
        //$map['isdel'] = 0;
            if (is_numeric($nickname)) {
                $map['id'] = array(intval($nickname));
            } else {
                $map['title'] = array('like', '%' . (string)$nickname . '%');
            }
        $list = $this->lists('Schedule', $map, 'id DESC');
        int_to_string($list);
        $this->assign('_list', $list);
        $this->assign('hidden', $hidden);
        $this->meta_title = '课程列表';
        $this->display();
    }

    function indexEdit()
    {
        $id = I("id");
        $type = D('Schedule');
        $schedule = $type->where("isdel=0")->find($id);

        if (IS_POST) {
            if (!$type->create()) {
                $this->error('修改课程信息失败！');
            } else {
                $map['classtype'] = I("classtype");
                $map['title'] = I("title");
                $map['startdate'] = I("startdate");
                $map['enddate'] = I("enddate");
                $map['weekinfo'] = I("weekinfo");
                $map['amount'] = I("amount");
                $map['amount_follow'] = I("amount_follow");
                $map['nums'] = I("nums");
                $map['hours'] = I("hours");
                $map['hour_s'] = I("hour_s");
                $map['hour_e'] = I("hour_e");
                $map['num_min'] = I("num_min");
                $map['num_max'] = I("num_max");
                $map['reserve'] = I("reserve");
                $map['content'] = I("content");
                $map['students'] = I("students");
                $map['mark'] = I("mark");
                $map['classnum'] = I("classnum");

                if (empty($map['classtype'])) {
                    $this->error('课程类型不能为空！');
                }
                if (empty($map['title'])) {
                    $this->error('课程名称不能为空！');
                }
                if (strtotime($map['enddate'])<strtotime($map['startdate'])) {
                    $this->error('培训结束日期不能小于开始日期！');
                }
                if (empty($map['weekinfo'])) {
                    $this->error('上课周期不能为空！');
                }
                if (empty($map['amount'])) {
                    $this->error('学费不能为空！');
                }
                if (empty($map['nums'])) {
                    $this->error('课次不能为空！');
                }
                if (empty($map['hours'])) {
                    $this->error('课时不能为空！');
                }
                if (empty($map['hour_s'])) {
                    $this->error('培训开始时间段不能为空！');
                }
                if (empty($map['hour_e'])) {
                    $this->error('培训结束时间段不能为空！');
                }
                if (empty($map['num_min'])) {
                    $this->error('每班最少人数不能为空！');
                }
                if (empty($map['num_max'])) {
                    $this->error('每班最多人数不能为空！');
                }
                if (empty($map['content'])) {
                    $this->error('授课内容不能为空！');
                }
                if (empty($map['students'])) {
                    $this->error('招生对象不能为空！');
                }
                if (empty($map['mark'])) {
                    $this->error('报名须知不能为空！');
                }
                if (empty($map['classnum'])) {
                    $this->error('班级数不能为空！');
                }

                $type->where('id=' . $id)->save($map);
                $this->success('修改课程信息成功！', U('Course/index'));

            }
        } else {
            $this->assign('schedule', $schedule);
            $this->meta_title = '编辑课程';
            $this->display();
        }
    }
    //添加课程信息
    function indexAdd()
    {
        $type = D('Schedule');

        if (IS_POST) {
            if (!$type->create()) {
                $this->error('添加课程信息失败！');
            } else {
                $map['classtype'] = I("classtype");
                $map['title'] = I("title");
                $map['startdate'] = I("startdate");
                $map['enddate'] = I("enddate");
                $map['weekinfo'] = I("weekinfo");
                $map['amount'] = I("amount");
                $map['amount_follow'] = I("amount_follow");
                $map['nums'] = I("nums");
                $map['hours'] = I("hours");
                $map['hour_s'] = I("hour_s");
                $map['hour_e'] = I("hour_e");
                $map['num_min'] = I("num_min");
                $map['num_max'] = I("num_max");
                $map['reserve'] = I("reserve");
                $map['content'] = I("content");
                $map['students'] = I("students");
                $map['mark'] = I("mark");
                $map['classnum'] = I("classnum");

                if (empty($map['classtype'])) {
                    $this->error('课程类型不能为空！');
                }
                if (empty($map['title'])) {
                    $this->error('课程名称不能为空！');
                }
                if (empty($map['startdate'])) {
                    $this->error('培训开始日期不能为空！');
                }
                if (empty($map['enddate'])) {
                    $this->error('培训结束日期不能为空！');
                }
                if (strtotime($map['enddate'])<strtotime($map['startdate'])) {
                    $this->error('培训结束日期不能小于开始日期！');
                }
                if (empty($map['weekinfo'])) {
                    $this->error('上课周期不能为空！');
                }
                if (empty($map['amount'])) {
                    $this->error('学费不能为空！');
                }
                if (empty($map['nums'])) {
                    $this->error('课次不能为空！');
                }
                if (empty($map['hours'])) {
                    $this->error('课时不能为空！');
                }
                if (empty($map['hour_s'])) {
                    $this->error('培训开始时间段不能为空！');
                }
                if (empty($map['hour_e'])) {
                    $this->error('培训结束时间段不能为空！');
                }
                if (empty($map['num_min'])) {
                    $this->error('每班最少人数不能为空！');
                }
                if (empty($map['num_max'])) {
                    $this->error('每班最多人数不能为空！');
                }
                if (empty($map['content'])) {
                    $this->error('授课内容不能为空！');
                }
                if (empty($map['students'])) {
                    $this->error('招生对象不能为空！');
                }
                if (empty($map['mark'])) {
                    $this->error('报名须知不能为空！');
                }
                if (empty($map['classnum'])) {
                    $this->error('班级数不能为空！');
                }
                $res = $type->add($map);
                if ($res) {
                    $this->success('添加课程信息成功！', U('Course/index'));
                } else {
                    $this->error('添加课程信息失败！');
                }
            }
        } else {
            $this->meta_title = '添加课程信息';
            $this->display();
        }
    }


    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
                $this->resume('Member', $map );
                break;
            case 'deleteuser':
                $this->delete('Member', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    function indexDel()
    {
        $id1 = array_unique((array)I('id', 0));
        $id = is_array($id1) ? implode(',', $id1) : $id1;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in', $id);
        $data['isdel'] = 1;
        $msg = array('success' => '删除成功！', 'error' => '删除失败！');
        $this->editRow('Schedule', $data, $map, $msg);
//        $this->deleteModel('Order', 'order');
    }
    //改变报名状态
    function indexStatus()
    {
        $id1 = array_unique((array)I('id', 0));
        $id = is_array($id1) ? implode(',', $id1) : $id1;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in', $id);
        $data['iscontinue'] = 1;
        $data['isdel'] = 0;
        $msg = array('success' => '开启报名成功！', 'error' => '开启报名失败！');
        $this->editRow('Schedule', $data, $map, $msg);
//        $this->deleteModel('Order', 'order');
    }
}