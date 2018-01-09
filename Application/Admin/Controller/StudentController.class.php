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
class 	StudentController extends AdminController
{

    /**
     * 课程信息管理首页
     * @author catherine
     */
    public function index()
    {
        $path = array('delete' => 'admin/Student/indexDel', 'edit' => 'admin/Student/indexEdit');
        foreach ($path as $k => $v) {
            if (!$this->checkRule($v)) {
                $hidden[$k] = $v;
            }
        }
        $nickname = I('nickname');
        $nickname = trim($nickname);
        $map['isdel'] = 0;
        if(is_numeric($nickname) && (strlen($nickname)==11)){
            //搜索手机号
            $map['phone'] = $nickname;
        }else {
            if (is_numeric($nickname)) {
                $map['id'] = array(intval($nickname));
            } else {
                $map['name'] = array('like', '%' . (string)$nickname . '%');
            }
        }
        $list = $this->lists('Student', $map, 'id DESC');
        $this->assign('_list', $list);
        $this->assign('hidden', $hidden);
        $this->meta_title = '学生列表';
        $this->display();
    }

    function indexEdit()
    {
        $id = I("id");
        $type = D('Student');
        $student  = M("Student")->where("isdel=0 and id = $id")->find();
        if (IS_POST) {
            if (!$type->create()) {
                $this->error('修改学生信息失败！');
            } else {
                $map['name'] = I("name");
                $map['birthinfo'] = I("birthinfo");
                $map['sex'] = I("sex");
                $map['age'] = I("age");
                $map['phone'] = I("phone");
                $map['mark'] = I("mark");
                $map['parents'] = I("parents");
                $map['school'] = I("school");
                $map['idcard'] = I("idcard");

                if (empty($map['name'])) {
                    $this->error('学生姓名不能为空！');
                }
                if (empty($map['birthinfo'])) {
                    $this->error('学生出生年月不能为空！');
                }
                if (empty($map['phone'])) {
                    $this->error('手机号不能为空！');
                }
                if(!preg_match("/^1[34578]{1}\d{9}$/", $map['phone'])){
                    $this->error('请填写正确的手机号！');
                }
                $type->where('id=' . $id)->save($map);
                $this->success('修改学生信息成功！', U('Student/index'));

            }
        } else {
            $this->assign('student', $student);
            $this->meta_title = '编辑学生信息';
            $this->display();
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
        $this->editRow('Student', $data, $map, $msg);
//        $this->deleteModel('Order', 'order');
    }



}