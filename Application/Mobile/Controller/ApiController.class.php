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
class ApiController extends MobileController
{


    public function getoauthinfo()
    {
        $reurl = $_GET['reurl'];
        $openid = $_GET['openid'];

        if ($openid) {
            $_SESSION['openid'] = $openid;
            $_SESSION['reurl'] = 'http://fit.24parking.com.cn/Personal';
//            $_SESSION['reurl'] = 'http://192.168.3.10:8080/Personal';
        }

        if ($_SESSION['openid']) {
            $userinfo = M("userinfo")->where("isdel = 0 and openid = '" . $_SESSION['openid'] . "'")->find();
            if (empty($userinfo)) {
                echo("<script>window.location.href='http://fit.24parking.com.cn/Login';</script>");
//                echo("<script>window.location.href='http://192.168.3.10:8080/Login';</script>");

            } else {
                $_SESSION['uid'] = $userinfo['id'];
                if (empty($reurl)) {
                    $reurl = $_SESSION['reurl'];
                }
                echo("<script>window.location.href='" . $reurl . "';</script>");
            }
        } else {
            echo("<script>window.location.href = 'http://crmapi.24parking.com.cn/index.php/Mobile/OAuth/wxUserBase/?state=" . $reurl . "'</script>");
        }
    }

    public function userlogout()
    {
        $_SESSION = null;
    }

    /**
     * s获取城市选择列表
     */
    public function getarea()
    {
        $this->writeRequest();
        $data = M("area")->field("id,name")->where(" parent_id = 0 and deep = 1")->limit(0, 5)->select();
        foreach ($data as &$v) {
            $v['city'] = M("area")->field("id,name")->where("parent_id =" . $v['id'])->select();
            foreach ($v['city'] as &$vv) {
                $vv['dist'] = M("area")->field("id,name")->where("parent_id =" . $vv['id'])->select();
            }
        }
        $result['response'] = array(
            'code' => 200,
            'msg' => '操作成功',
            'data' => $data
        );

        $this->writeRequestResult($result);
        echo json_encode($result);
    }

    /**
     * s获取场馆列表
     */
    public function getsporthall()
    {
        $this->writeRequest();
        $pageid = $_REQUEST["pageid"];
        $pagesize = $_REQUEST["pagesize"];
        if (empty($pageid)) {
            $pageid = 0;
        }
        if (empty($pagesize)) {
            $pagesize = 10;
        }
        $data = M("sporthall")->field("id,name,logo,province,city,dist,address,score,imgs")->where("active = 1 and isdel = 0")->limit($pageid * $pagesize, $pagesize)->order("sort desc,score desc,id desc")->limit("0,10")->select();

        $count = M("sporthall")->where("active = 1 and isdel = 0")->count();
        foreach ($data as &$v) {
            $v['logo'] = C("IMAGE_URL") . $v['logo'];
            $v['address'] = $v['province'] . $v['city'] . $v['dist'] . $v['address'];
            unset($v['province']);
            unset($v['city']);
            $images = M("images")->where("id in (" . $v['imgs'] . ")")->select();
            $tmp = array();
            foreach ($images as $vv) {
                $tmp[] = C("IMAGE_URL") . $vv['url'];
            }
            $v['imgs'] = $tmp;
        }

        $result['response'] = array(
            'code' => 200,
            'msg' => '操作成功',
            'data' => $data,
            'count' => $count
        );

        $this->writeRequestResult($result);
        echo json_encode($result);
    }

    /**
     * s获取场馆详情
     */
    public function getsporthalldetail()
    {
        $this->writeRequest();
        $id = $_REQUEST['id'];
        if (empty($id)) {
            $result['response'] = array(
                'code' => 100,
                'msg' => '参数为空'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
        }
        $sporthall = M("sporthall")->where("active = 1 and isdel = 0 and id = " . $id)->find();
        if ($sporthall) {
            $sporthall['address'] = $sporthall['province'] . $sporthall['city'] . $sporthall['dist'] . $sporthall['address'];
            unset($sporthall['sort']);
            unset($sporthall['isdel']);
            unset($sporthall['province']);
            unset($sporthall['city']);
            unset($sporthall['dist']);

            $images = M("images")->where("id in (" . $sporthall['imgs'] . ")")->select();
            $tmp = array();
            foreach ($images as $vv) {
                $tmp[] = C("IMAGE_URL") . $vv['url'];
            }
            $sporthall['imgs'] = $tmp;
            $data['sporthall'] = $sporthall;

            $coachlist = M("coach")->field("id,name,headimg,score,imgs,phone,shids")->where("isdel = 0 and shids like '%" . $id . "%'")->select();

            $coachids = "";
            foreach ($coachlist as &$vo) {
                if (!strstr($vo['headimg'], 'http')) {
                    $vo['headimg'] = C("IMAGE_URL") . $vo['headimg'];
                }
                if ($vo['imgs']) {
                    $images = M("images")->where("id in (" . $vo['imgs'] . ")")->select();
                    $tmp = array();
                    foreach ($images as $vvv) {
                        $tmp[] = C("IMAGE_URL") . $vvv['url'];
                    }
                    $vo['imgs'] = $tmp;
                }
                unset($vo['shids']);
                $course = M("coachcourse")->where("isdel = 0 and coachid = " . $vo['id'] . " and price > 10")->order("price asc")->limit(1)->select();
                $vo['lowprice'] = $course[0]['price'];

                $tmp = M("label")->where("cid =" . $vo['id'])->select();
                $label = array();
                foreach ($tmp as $vvv) {
                    $label[] = $vvv['title'];
                }
                $vo['label'] = $label;

                $tmp = M("coachskill")->field("tblskill.name")->join("tblskill on tblcoachskill.sid = tblskill.id")
                    ->where("tblcoachskill.isdel = 0 and tblcoachskill.cid =" . $vo['id'])->order("tblskill.sort desc")->select();
                $skill = array();
                foreach ($tmp as $vvv) {
                    $skill[] = $vvv['name'];
                }
                $vo['skill'] = $skill;
                $coachids .= "," . $vo['id'];
            }
            $coachids = substr($coachids, 1);
            $data['coach'] = $coachlist;

            $evaluate = M("evaluate")->where("isdel = 0 and cid in (" . $coachids . ")")->select();
            foreach ($evaluate as &$ve) {
                $ve['addtime'] = date('Y年m月d日', $ve['addtime']);

                $tmpcoach = M("coach")->where("isdel = 0 and id = " . $ve['cid'])->find();
                if ($tmpcoach) {
                    $ve['coachname'] = $tmpcoach['name'];
                }

                $tmpuser = M("userinfo")->where("isdel = 0 and id =" . $ve['uid'])->find();
                if ($tmpuser) {
                    $ve['name'] = $tmpuser['name'];
                    //$ve['headimg'] = $tmpuser['headimg'];
                    if (strstr($tmpuser['headimg'], 'http')) {
                        $ve['headimg'] = $tmpuser['headimg'];
                    } else {
                        $ve['headimg'] = C("IMAGE_URL") . $tmpuser['headimg'];
                    }
                }

                if ($ve['imgs']) {
                    $images = M("images")->where("isdel = 0 and id in(" . $ve['imgs'] . ")")->select();
                    $tmp = array();
                    foreach ($images as $vvv) {
                        $tmp[] = C("EVALUATE_IMAGE_URL") . $vvv['url'];
                    }
                    $ve['imgs'] = $tmp;
                }
                unset($ve['id']);
                unset($ve['uid']);
                unset($ve['cid']);
                unset($ve['isdel']);
            }
            if (empty($evaluate)) {
                $evaluate = array();
            }
            $data['evaluate'] = $evaluate;


            $result['response'] = array(
                'code' => 200,
                'msg' => '操作成功',
                'data' => $data
            );
        } else {
            $result['response'] = array(
                'code' => 110,
                'msg' => '场馆不存在或已关闭'
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s获取教练信息
     */
    public function getcoachinfo()
    {
        $this->writeRequest();
        $id = $_REQUEST['id'];
        if (empty($id)) {
            $id = 1;
        }
        if ($id) {
            $tmp = M("coach")->where("isdel = 0 and id =" . $id)->select();
            $data = $tmp[0];
            if (!strstr($data['headimg'], 'http')) {
                $data['headimg'] = C("IMAGE_URL") . $data['headimg'];
            }
            unset($data['isdel']);
            if ($data['imgs']) {
                $images = M("images")->where("isdel = 0 and id in(" . $data['imgs'] . ")")->select();
                $tmp = array();
                foreach ($images as $v) {
                    $tmp[] = C("IMAGE_URL") . $v['url'];
                }
                $data['imgs'] = $tmp;
            }

            $course = M("coachcourse")->where("isdel = 0 and coachid = " . $data['id'] . " and price > 10")->order("price asc")->limit(1)->select();
            $data['lowprice'] = $course[0]['price'];

            $sporthall = M("sporthall")->field("id,name,province,city,dist,address,navurl,latitude,longitude")->where("active = 1 and isdel = 0 and id in( " . $data['shids'] . ")")->select();
            foreach ($sporthall as &$v) {
                $v['address'] = $v['province'] . $v['city'] . $v['dist'] . $v['address'];
                unset($v['province']);
                unset($v['city']);
            }
            $data['shids'] = $sporthall;

            $tmp = M("label")->where("cid = " . $data['id'])->select();
            $label = array();
            foreach ($tmp as $vv) {
                $label[] = $vv['title'];
            }
            $data['label'] = $label;

            $tmp = M("coachskill")->field("tblskill.name")->join("tblskill on tblcoachskill.sid = tblskill.id")
                ->where("tblskill.isdel = 0 and tblcoachskill.cid =" . $data['id'])->order("tblskill.sort desc")->select();
            $skill = array();
            foreach ($tmp as $vv) {
                $skill[] = $vv['name'];
            }
            $data['skill'] = $skill;

            $course = M("coachcourse")
                ->join("tblcourse on tblcoachcourse.courseid = tblcourse.id")
                ->field("tblcoachcourse.id,tblcourse.name,tblcourse.img,tblcourse.salelimit,tblcourse.content,tblcourse.people,tblcourse.coursetime,tblcourse.suggest,tblcoachcourse.price")
                ->where("tblcourse.isdel = 0 and tblcoachcourse.isdel = 0 and tblcoachcourse.price > 10 and tblcoachcourse.coachid = " . $data['id'])
                ->select();
            foreach ($course as &$vc) {
                $vc['img'] = C("IMAGE_URL") . $vc['img'];
            }
            $data['course'] = $course;

            $evaluate = M("evaluate")->where("isdel = 0 and cid = " . $data['id'])->select();
            foreach ($evaluate as &$ve) {
                $ve['addtime'] = date('Y年m月d日', $ve['addtime']);

                $tmpcoach = M("coach")->where("isdel = 0 and id = " . $ve['cid'])->find();
                if ($tmpcoach) {
                    $ve['coachname'] = $tmpcoach['name'];
                }

                $tmpcourse = M("courselog")->find($ve['courselogid']);
                $ve['coursename'] = $tmpcourse['ctitle'];

                $tmpuser = M("userinfo")->where("isdel = 0 and id = " . $ve['uid'])->find();
                if ($tmpuser) {
                    $ve['name'] = $tmpuser['name'];
                    if (strstr($tmpuser['headimg'], 'http')) {
                        $ve['headimg'] = $tmpuser['headimg'];
                    } else {
                        $ve['headimg'] = C("IMAGE_URL") . $tmpuser['headimg'];
                    }
                }

                if ($ve['imgs']) {
                    $images = M("images")->where("isdel = 0 and id in(" . $ve['imgs'] . ")")->select();
                    $tmp = array();
                    foreach ($images as $vvv) {
                        $tmp[] = C("EVALUATE_IMAGE_URL") . $vvv['url'];
                    }
                    $ve['imgs'] = $tmp;
                }
                unset($ve['id']);
                unset($ve['uid']);
                unset($ve['cid']);
                unset($ve['isdel']);
            }
            if (empty($evaluate)) {
                $evaluate = array();
            }
            $data['evaluate'] = $evaluate;

            $result['response'] = array(
                'code' => 200,
                'msg' => '操作成功',
                'data' => $data
            );
        } else {
            $result['response'] = array(
                'code' => 100,
                'msg' => '教练ID不能为空'
            );
        }

        $this->writeRequestResult($result);
        echo json_encode($result);
    }


    /**
     * 获取验证码
     * @return bool
     */
    public function getvalidatecode()
    {
        $this->writeRequest();
        $phone = $_REQUEST['phone'];
        $action = $_REQUEST['action'];
        if (empty($phone)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '手机号码为空'
            );
        } else {
            $this->validatePhone($phone);
            $check = $this->checkUserByPhone($phone);
            if ($action == 'reg') {
                if (!empty($check)) {
                    $result['response'] = array(
                        'code' => '101',
                        'msg' => '您已是注册会员，请直接登录'
                    );
                    $json_result = json_encode($result);
                    $this->writeRequestResult($json_result);
                    echo($json_result);
                    exit();
                }
            } elseif ($action == 'findpwd') {
                if (empty($check)) {
                    $result['response'] = array(
                        'code' => '102',
                        'msg' => '用户不存在'
                    );
                    $json_result = json_encode($result);
                    $this->writeRequestResult($json_result);
                    echo($json_result);
                    exit();
                }
            }

            $data['code'] = $this->getRandCharNum(6);
            $data['phone'] = $phone;
            $data['addtime'] = time();

            $res = M("registertemp")->where("phone = '" . $phone . "'")->find();
            if (empty($res)) {
                $id = M("registertemp")->add($data);
            } else {
                $data['id'] = $res['id'];
                $id = $res['id'];
                $flag = M("registertemp")->save($data);
            }
            if ($id) {
                //发送短信验证码
                $flag = $this->sendCode($data['phone'], $data['code']);
                if ($flag) {
                    $result['response'] = array(
                        'code' => '200',
                        'msg' => '发送成功'
                    );
                } else {
                    $result['response'] = array(
                        'code' => '103',
                        'msg' => '发送失败'
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '105',
                    'msg' => '网络或系统错误'
                );
            }
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 检查用户手机是否已存在
     * @param $phone
     * @return mixed
     */
    public function checkUserByPhone($phone)
    {
        $where['phone'] = $phone;
        $where['isdel'] = 0;
        return M("userinfo")->where($where)->find();
    }


    /**
     * 验证验证码
     */
    public function validateCode($phone, $code)
    {
        $userreg = M("registertemp")->where("phone = '" . $phone . "'")->find();
        $nowtime = time();
        if (empty($userreg)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '验证码不存在'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        } else {
            $lasttime = $userreg['addtime'];
            if ($nowtime - $lasttime > 10 * 60) {//验证码有效期10分钟
                M("registertemp")->delete($userreg['id']);
                $result['response'] = array(
                    'code' => '104',
                    'msg' => '验证超时'
                );
                $json_result = json_encode($result);
                $this->writeRequestResult($json_result);
                echo($json_result);
                exit();
            } else {
                if ($code != $userreg['code']) {
                    $result['response'] = array(
                        'code' => '106',
                        'msg' => '验证码错误'
                    );
                    $json_result = json_encode($result);
                    $this->writeRequestResult($json_result);
                    echo($json_result);
                    exit();
                } else {
                    M("registertemp")->delete($userreg['id']);
                    return true;
                }
            }
        }
    }


    /**
     * s用户注册
     */
    public function userreg()
    {
        $this->writeRequest();
        $phone = $_REQUEST['phone'];
        $pwd = $_REQUEST['pwd'];
        $repwd = $_REQUEST['repwd'];
        $code = $_REQUEST['code'];
        $this->validatephone($phone);
        if (empty($pwd) && empty($repwd)) {
            $result['response'] = array(
                'code' => 100,
                'msg' => '密码不能为空'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        } elseif ($pwd != $repwd) {
            $result['response'] = array(
                'code' => 107,
                'msg' => '两次密码输入不同'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        } elseif (empty($code)) {
            $result['response'] = array(
                'code' => 100,
                'msg' => '验证码不能为空'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        }
        $this->validatePhone($phone);
        if ($this->validateCode($phone, $code)) {//如果校验成功，则添加用户记录
            if ($this->checkUserByPhone($phone)) {
                $result['response'] = array(
                    'code' => '101',
                    'msg' => '手机号码已存在'
                );
            } else {
                $user['number'] = time() . $this->getRandChar(5);
                $user['phone'] = $phone;
                $user['password'] = md5($pwd);
                $user['addtime'] = time();
                /*$weixinuser = M("weixinuser")->where("openid ='".$_SESSION['openid']."'")->find();
                Log::write("weixinuser用户参数：".json_encode($_SESSION));
                Log::write("weixinuser用户SQL：".M()->getLastSql());
                $user['openid']  = $weixinuser['openid'];
                $user['name']    = $weixinuser['nickname'];
                $user['headimg'] = $weixinuser['headimgurl'];
                $user['sex']     = $weixinuser['sex'];*/
                $res = M("userinfo")->add($user);
                if ($res) {
                    $result['response'] = array(
                        'code' => '200',
                        'msg' => '注册成功',
                    );
                } else {
                    $result['response'] = array(
                        'code' => '105',
                        'msg' => '新增失败',
                    );
                }
            }
        } else {
            $result['response'] = array(
                'code' => '106',
                'msg' => '验证码错误'
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s用户登录
     */
    public function userlogin()
    {
        $this->writeRequest();
        $phone = $_REQUEST['phone'];
        $pwd = $_REQUEST['pwd'];
        $this->validatephone($phone);
        if (empty($pwd)) {
            $result['response'] = array(
                'code' => 100,
                'msg' => '密码不能为空'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit();
        }

        $where['phone'] = $phone;
        $where['isdel'] = 0;
        $user = M("userinfo")->where($where)->find();
        if ($user) {
            if ($user['password'] == md5($pwd)) {
                $_SESSION['uid'] = $user['id'];

                $data['id'] = $user['id'];
                $weixinuser = M("weixinuser")->where("openid ='" . $_SESSION['openid'] . "'")->find();
                if ($weixinuser) {
                    if ($weixinuser['openid']) {
                        $data['openid'] = $weixinuser['openid'];
                    }
                    if ($weixinuser['nickname']) {
                        $data['name'] = $weixinuser['nickname'];
                    }
                    if ($weixinuser['headimgurl']) {
                        $data['headimg'] = $weixinuser['headimgurl'];
                    }
                    if ($weixinuser['sex']) {
                        $data['sex'] = $weixinuser['sex'];
                    }
                    M("userinfo")->save($data);
                }

                $result['response'] = array(
                    'code' => 200,
                    'msg' => '登录成功',
                    'data' => session_id()
                );
            } else {
                $result['response'] = array(
                    'code' => 108,
                    'msg' => '密码错误'
                );
            }
        } else {
            $result['response'] = array(
                'code' => 102,
                'msg' => '用户不存在'
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s用户中心
     */
    public function getuserinfo()
    {
        $this->writeRequest();
        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
        } else {
            $where['id'] = $uid;
            $where['isdel'] = 0;
            $user = M("userinfo")->field("name,headimg,balance,score,phone")->where($where)->find();
            if (!strstr($user['headimg'], 'http')) {
                $user['headimg'] = C("IMAGE_URL") . $user['headimg'];
            }
            $coach = M("coach")->where("isdel = 0 and phone = '" . $user['phone'] . "'")->find();
            if ($coach) {
                $user['iscoach'] = 1;
                $user['cid'] = think_encrypt($coach['id'], "zhuoying");
            } else {
                $user['iscoach'] = 0;
                $user['cid'] = '';
            }
            $map['uid'] = $user['id'];
            $map['isused'] = 0;
            $discount = M("discount")->where($map)->count();
            $user['discount'] = $discount;
            if ($user) {
                $result['response'] = array(
                    'code' => 200,
                    'msg' => '操作成功',
                    'data' => $user
                );
            } else {
                $result['response'] = array(
                    'code' => 102,
                    'msg' => '用户不存在或被禁用'
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        $this->writeRequest();//验签
        $olduserpwd = $_REQUEST['olduserpwd'];
        $olduserpwd = md5($olduserpwd);
        $newuserpwd = $_REQUEST['newuserpwd'];
        $renewuserpwd = $_REQUEST['renewuserpwd'];
        $uid = $_SESSION['uid'];
        $user['password'] = md5($newuserpwd);
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($olduserpwd) || empty($newuserpwd) || empty($renewuserpwd)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '参数为空'
            );
        } elseif ($olduserpwd == $user['password']) {
            $result['response'] = array(
                'code' => '111',
                'msg' => '新旧密码相同，无法修改'
            );
        } elseif ($newuserpwd != $renewuserpwd) {
            $result['response'] = array(
                'code' => '107',
                'msg' => '两次输入密码不相同'
            );
        } else {
            $where['id'] = $uid;
            $where['isdel'] = 0;
            $userdata = M("userinfo")->where($where)->find();
            if ($userdata) {
                if ($userdata['password'] != $olduserpwd) {
                    $result['response'] = array(
                        'code' => '112',
                        'msg' => '原密码输入错误'
                    );
                } else {
                    $data = M("userinfo")->where("id = " . $uid)->save($user);
                    if ($data) {
                        $result['response'] = array(
                            'data' => $data,
                            'code' => '200',
                            'msg' => '修改成功',
                        );
                    } else {
                        $result['response'] = array(
                            'data' => $data,
                            'code' => '105',
                            'msg' => '网络或系统错误',
                        );
                    }
                }
            } else {
                $result['response'] = array(
                    'code' => '102',
                    'msg' => '用户不存在'
                );
            }
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 忘记密码后设置新密码
     */
    public function setnewpwd()
    {
        $this->writeRequest();//验签
        $phone = $_REQUEST['phone'];
        $code = $_REQUEST['code'];

        $this->validatePhone($phone);//验证手机号码
        $this->validateCode($phone, $code);//验证短信验证码

        $newpwd = $_REQUEST['newuserpwd'];
        $renewpwd = $_REQUEST['renewuserpwd'];

        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }

        if (empty($newpwd) || empty($renewpwd)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '密码为空'
            );
        } elseif ($newpwd != $renewpwd) {
            $result['response'] = array(
                'code' => '107',
                'msg' => '两次密码输入不相同'
            );
        } else {
            $user['password'] = md5($newpwd);
            $where['phone'] = $phone;
            $where['isdel'] = 0;
            $data = M("userinfo")->where($where)->find();
            if ($data['password'] != $user['password']) {
                $user['id'] = $data['id'];
                $res = M("userinfo")->save($user);
            } else {
                $res = 1;
            }
            if ($res) {
                $result['response'] = array(
                    'data' => $data,
                    'code' => '200',
                    'msg' => '修改成功',
                );
            } else {
                $result['response'] = array(
                    'data' => $data,
                    'code' => '105',
                    'msg' => '网络或系统错误',
                );
            }
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 用户修改昵称
     */
    public function setusername()
    {
        $this->writeRequest();//验签

        $name = $_REQUEST['name'];
        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }

        if (empty($name)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '参数不正确'
            );
        } else {
            $data['id'] = $uid;
            $data['name'] = $name;
            $res = M("userinfo")->save($data);
            if ($res) {
                $result['response'] = array(
                    'code' => '200',
                    'msg' => '修改成功',
                );
            } else {
                $result['response'] = array(
                    'code' => '105',
                    'msg' => '网络或系统错误',
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s获取私教列表
     */
    public function getcoachlist()
    {
        $this->writeRequest();
        $sid = $_REQUEST['sid'];//场馆ID
        $sort = $_REQUEST['sort'];
        if ($sid) {
            $map['id'] = $sid;
        }

        $map['isdel'] = 0;
        $map['active'] = 1;
        $sporthall = M("sporthall")->field("id,name")->where($map)->select();
        $data['sporthall'] = $sporthall;
        $pageid = $_REQUEST["pageid"];
        $pagesize = $_REQUEST["pagesize"];
        if (empty($pageid)) {
            $pageid = 0;
        }
        if (empty($pagesize)) {
            $pagesize = 10;
        }
        $coachlist = array();
        $i = 0;
        foreach ($sporthall as $v) {
            $coachtmp = M("coach")->field("id,name,headimg,score,imgs,shids")->where("isdel = 0 and shids like '%" . $v['id'] . "%'")->limit($pageid * $pagesize, $pagesize)->select();
            $coachids = array();
            foreach ($coachtmp as &$vo) {
                if (!strstr($vo['headimg'], 'http')) {
                    $vo['headimg'] = C("IMAGE_URL") . $vo['headimg'];
                }
                if ($vo['imgs']) {
                    $images = m("images")->where("isdel = 0 and id in(" . $vo['imgs'] . ")")->select();
                    $tmp = array();
                    foreach ($images as $vvv) {
                        $tmp[] = C("IMAGE_URL") . $vvv['url'];
                    }
                    $vo['imgs'] = $tmp;
                }
                unset($vo['shids']);
                $course = M("coachcourse")->where("isdel = 0 and coachid = " . $vo['id'] . " and price > 10")->order("price asc")->limit(1)->select();
                $vo['lowprice'] = $course[0]['price'];

                $tmp = M("label")->where("cid = " . $vo['id'])->select();
                $label = array();
                foreach ($tmp as $vvv) {
                    $label[] = $vvv['title'];
                }
                $vo['label'] = $label;

                $tmp = M("coachskill")->field("tblskill.name")->join("tblskill on tblcoachskill.sid = tblskill.id")
                    ->where("tblcoachskill.cid =" . $vo['id'])->order("tblskill.sort desc")->select();
                $skill = array();
                foreach ($tmp as $vvv) {
                    $skill[] = $vvv['name'];
                }
                $vo['skill'] = $skill;
                $coachids[] = $vo['id'];
                $coachlist[$i++] = $vo;
            }
        }
        $data['coach'] = $coachlist;

        $result['response'] = array(
            'code' => 200,
            'msg' => '操作成功',
            'data' => $data
        );
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s确认订单
     */
    public function confirmorder()
    {
        $this->writeRequest();

        $cid = $_REQUEST['id'];
        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if ($cid) {
            $course = M("course")->field("tblcoachcourse.id,tblcourse.name,tblcourse.salelimit,tblcoachcourse.price,tblcoachcourse.coachid")
                ->join("tblcoachcourse on tblcourse.id = tblcoachcourse.courseid")
                ->where("tblcoachcourse.isdel = 0 and tblcourse.isdel = 0 and tblcoachcourse.id = " . $cid)->find();
            if ($course) {
                $map['id'] = $course['coachid'];
                $map['isdel'] = 0;
                $coach = M("coach")->where($map)->find();
                if ($coach) {
                    $map['id'] = $coach['shids'];
                    $map['isdel'] = 0;
                    $map['active'] = 1;
                    $sporthall = M("sporthall")->where($map)->find();
                    if ($sporthall) {
                        $amount = $course['salelimit'] * $course['price'];
                        $course['sporthallid'] = $sporthall['id'];
                        $course['sporthall'] = $sporthall['name'];
                        $course['amount'] = $amount;
                        unset($course['coachid']);

                        $result['response'] = array(
                            'code' => '200',
                            'msg' => '操作成功',
                            'data' => $course
                        );
                    } else {
                        $result['response'] = array(
                            'code' => '110',
                            'msg' => '场馆不存在或已关闭',
                        );
                    }
                } else {
                    $result['response'] = array(
                        'code' => '110',
                        'msg' => '教练不存在或已删除',
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '课程不存在或已删除',
                );
            }
        } else {
            $result['response'] = array(
                'code' => '100',
                'msg' => '未选择课程',
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取我的课程
     */
    public function getmycourse()
    {
        $this->writeRequest();
        $type = $_REQUEST['type'];
        $cid = $_REQUEST['cid'];
        $uid = $_SESSION['uid'];

        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            if (empty($type)) {
                $type = 1;//默认显示未完成
            }
            $map['uid'] = $uid;
            $map['isdel'] = 0;
            $map['ispay'] = 1;

            if ($type == 1) {
                $map['status'] = 1;
            } else {
                $map['status'] = array('in', array(1, 4));
            }
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $tblorder = M("order")->where($map)->limit($pageid * $pagesize, $pagesize)->select();
            $count = M("order")->where($map)->count();
            if (empty($tblorder)) {
                $data = array();
            } else {
                //foreach($tblorder as $v){
                $map = array();
                //$map['orderid'] = $v['id'];
                //$map['status'] = 1;
                if ($type == 1) {
                    $map['status'] = array('in', array(1));
                } else {
                    $map['status'] = array('in', array(2, 3));
                }
                if (!empty($cid)) {
                    $map['id'] = $cid;
                }
                $data = M("courselog")
                    ->field("id,cid,shid,ctitle,coid,totalhours,currenthours,ordertime,signtime,canceltime,status")
                    ->limit($pageid * $pagesize, $pagesize)
                    ->where($map)->order("orderid desc, currenthours desc, id desc")->select();
                if ($data) {
                    foreach ($data as &$v) {
                        if ($v['ordertime'] < $v['signtime']) {
                            $v['late'] = 1;
                        } else {
                            $v['late'] = 0;
                        }
                        if ($type == 1) {
                            $where['uid'] = $uid;
                            $where['courselogid'] = $v['id'];
                            $userschedule = M("userschedule")->where($where)->find();
                            if ($userschedule) {
                                if (floor($userschedule['ordertime_s']) == $userschedule['ordertime_s']) {
                                    $userschedule['ordertime_s'] = intval($userschedule['ordertime_s']) . ":00";
                                } else {
                                    $userschedule['ordertime_s'] = floor($userschedule['ordertime_s']) . ":30";
                                }
                                $v['ordertime'] = $userschedule['orderdate'] . ' ' . $userschedule['ordertime_s'];
                            } else {
                                if ($v['ordertime'] > 0) {
                                    $v['ordertime'] = date("Y-m-d H:i", $v['ordertime']);
                                }
                            }
                        } else {
                            if ($v['ordertime'] > 0) {
                                $v['ordertime'] = date("Y-m-d H:i", $v['ordertime']);
                            }
                        }
                        if ($v['signtime'] > 0) {
                            $v['signtime'] = date("Y-m-d H:i:s", $v['signtime']);
                        }
                        if ($v['canceltime'] > 0) {
                            $v['canceltime'] = date("Y-m-d H:i", $v['canceltime']);
                        }
                        $sporthall = M("sporthall")->find($v['shid']);
                        $v['sporthall'] = $sporthall['name'];
                        $v['address'] = $sporthall['province'] . $sporthall['city'] . $sporthall['dist'] . $sporthall['address'];
                        $v['navurl'] = $sporthall['navurl'];
                        $v['sporthall'] = $sporthall['name'];
                        $v['latitude'] = $sporthall['latitude'];
                        $v['longitude'] = $sporthall['longitude'];

                        $coach = M("coach")->find($v['coid']);
                        $v['cname'] = $coach['name'];
                        if (strstr($coach['headimg'], 'http')) {
                            $v['headimg'] = $coach['headimg'];
                        } else {
                            $v['headimg'] = C("IMAGE_URL") . $coach['headimg'];
                        }
                        $v['phone'] = $coach['phone'];

                        $course = M("coachcourse")->where("coachid = " . $coach['id'] . " and courseid = " . $v['cid'])->find();
                        $v['price'] = $course['price'];

                        $evaluate = M("evaluate")->where("courselogid = " . $v['id'])->find();
                        if ($evaluate) {
                            $v['is_evaluate'] = 1;
                        } else {
                            $v['is_evaluate'] = 0;
                        }

                        unset($v['shid']);
                    }
                }
                //}
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $data,
                'uid' => $uid,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s账户充值
     */
    public function accountrecharge()
    {
        $this->writeRequest();

        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        $amount = $_REQUEST["amount"];
        $paytype = $_REQUEST['paytype'];//alipay,wxpay,inpay,unipay
        if (empty($amount) || empty($paytype)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '参数不正确'
            );
        } else {
            $data['amount'] = $amount;
            $data['createtime'] = time();
            $number = time() . $this->getRandChar(5);
            $data['number'] = $number;
            $data['paytype'] = $paytype;
            $flag = M("rechargeorder")->add($data);
            if ($flag) {
                $body = '卓赢健身账户充值';
                if ($paytype == 1) {
                    $paypost = $this->wxPayPost($amount, $number, $body);

                    $result['response'] = array(
                        'data' => $paypost,
                        'code' => '200',
                        'msg' => '账户充值——微信支付请求成功',
                    );
                } elseif ($paytype == 'ALIPAY') {
                    $pay = 1;//$this->aliPayPost($amount, $number,$body);
                    $result['response'] = array(
                        'data' => $pay,
                        'code' => '200',
                        'msg' => '账户充值——支付宝支付请求成功',
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '105',
                    'msg' => '系统或网络错误',
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * 获取充值记录
     */
    public function getrechargelist()
    {
        $this->writeRequest();

        $uid = $_SESSION['uid'];//自己的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $datalist = M("accountchange")->field("amount,balance,paytype,mark,addtime")->where("type = 0 and uid = " . $uid)->limit($pageid * $pagesize, $pagesize)->select();

            foreach ($datalist as &$v) {
                $v['addtime'] = date("Y-m-d H:i:", $v['addtime']);
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $datalist
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * 获取账户变动记录
     */
    public function getaccountchange()
    {
        $this->writeRequest();

        $uid = $_SESSION['uid'];//自己的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $datalist = M("accountchange")->field("amount,balance,paytype,mark,addtime")->where("uid = " . $uid)->limit($pageid * $pagesize, $pagesize)->select();

            foreach ($datalist as &$v) {
                $v['addtime'] = date("Y-m-d H:i:", $v['addtime']);
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $datalist
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s取消课程
     */
    public function cancelcourse()
    {
        $this->writeRequest();
        $uid = $_SESSION['uid'];//自己的uid
        $cid = $_REQUEST['cid'];//课耗ID
        $type = $_REQUEST['type'];
        if($type == 1){
            $coid = $_SESSION['coid'];
        }

            if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($cid)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '参数不正确'
            );
        } else {
            //教练取消
            if($type == 1){
                $map['coid'] = $coid;
            }else{
                $map['uid'] = $uid;
            }
            $map['id'] = $cid;
            $map['isdel'] = 0;
            $map['status'] = 1;

            $course = M("courselog")->where($map)->find();
            if ($course) {
                if ($course['ordertime'] - time() > C("CANCELTIME") || $type == 1) {
                    $data['status'] = 0;//状态置为待预约
                    $course['status'] = 2;
                    $course['canceltime'] = time();
                    if($type == 1){
                        //标明是教练取消预约
                        $course['cancelstatus'] = 1;
                    }
                    //创建一条新的取消纪录
                    $newDate = $course;
                    unset($newDate['id']);

                    $flag1 = M('courselog')->where("id = " . $course['id'])->save($data);
                    $flag2 = M('userschedule')->where("courselogid = " . $cid)->save(array('status'=>0));
                    $flag3 = M('courselog')->data($newDate)->add();

                    if ($flag1 && $flag2 && !empty($flag3)) {
                        //购买课程的用户
                        $userinfo = M("userinfo")->find($course['uid']);
                        if ($userinfo['openid']) {
                            $tmpcourse = M("course")->find($course['cid']);
                            $coach = M("coach")->find($course['coid']);
                            $sporthall = M("sporthall")->find($course['shid']);
                            $schedule = M("userschedule")->where("courselogid = " . $course['id'])->order("id desc")->find();
                            $time_s = $schedule['ordertime_s'];
                            if (floor($time_s) == $time_s) {
                                $time_s = $time_s . ":00";
                            } else {
                                $time_s = floor($time_s) . ":30";
                            }
                            //通知用户
                            $map = array();
                            if($type == 1){
                                $map['first']['value'] = '您预约的私教课程已被教练-'.$coach["name"].'取消';
                            }else{
                                $map['first']['value'] = '您预约的私教课程已经取消';
                            }
                            $map['keyword1']['value'] = $schedule['orderdate'] . " " . $time_s;
                            $map['keyword2']['value'] = $coach["name"];
                            $map['keyword3']['value'] = $tmpcourse['name'];;
                            $map['keyword4']['value'] = $sporthall['name'];
                            $map['keyword5']['value'] = "时间临时变化，要求取消";
                            $payurl = '';
                            $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
                            $body = $this->sendTmplMsg('fGAz3gu_8Dtop1USskGyznQJH56sOMP8-ndVnc8nE-I', $userinfo['openid'], $map, $payurl);
                            $this->getWechat()->sendTemplateMessage($body);

                            //通知教练
                            $map = array();
                            if($type == 1){
                                $map['first']['value'] = $coach["name"] . '您已成功取消会员-'.$userinfo['name'].'的课程';
                            }else{
                                $map['first']['value'] = $coach["name"] . '您好，有会员取消了预约的课程';
                            }
                            $map['keyword1']['value'] = $userinfo['name'];
                            $map['keyword2']['value'] = $userinfo['phone'];
                            $map['keyword3']['value'] = $course['name'];;
                            $map['keyword4']['value'] = $schedule['orderdate'] . " " . $time_s;
                            $map['keyword5']['value'] = date("Y-m-d H:i:s");
                            $payurl = '';
                            $map['remark']['value'] = '请尽快联系会员以便安排下一次预约上课。';
                            $body = $this->sendTmplMsg('5zOMrqhP7DPiIRZ2v-MN_CzdlvR2ieykgrB38VX-DtY', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
                            $this->getWechat()->sendTemplateMessage($body);
                        }
                        $result['response'] = array(
                            'code' => '200',
                            'msg' => '操作成功'
                        );
                    } else {
                        $result['response'] = array(
                            'code' => '105',
                            'msg' => '系统或网络错误'
                        );
                    }
                } else {
                    $result['response'] = array(
                        'code' => '116',
                        'msg' => '请于预约时间提前' . (C("CANCELTIME") / (60 * 60)) . '小时取消'
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '课程不存在'
                );
            }
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 用户签到
     */
    public function usersignup()
    {
        $this->writeRequest();

        $cid = $_REQUEST['cid'];//courselog ID
        $uid = $_SESSION['uid'];//自己的uid
        if (empty($uid)) {
            echo "<script>alert('请先登录');window.history.go(-1);</script>";
        }
        if (empty($cid)) {
            echo "<script>alert('二维码不正确');window.history.go(-1);</script>";
        } else {
            $where['uid'] = $uid;
            $where['id'] = $cid;
            $where['status'] = 1;
            $where['isdel'] = 0;
            $course = M("courselog")->where($where)->find();
            if ($course) {
                M()->startTrans();
                $data['id'] = $course['id'];
                $data['status'] = 3;
                $data['signtime'] = time();
                $flaglog = M("courselog")->save($data);
                $flaglogsql = M()->getLastSql();
                $flagorder = true;
                if ($course['totalhours'] == $course['currenthours']) {//表明是最后一次课时，课程订单做结束处理
                    $order['id'] = $course['orderid'];
                    $order['status'] = 4;
                    $flagorder = M("order")->save($order);
                    $flagordersql = M()->getLastSql();
                }

                $operate['uid'] = $uid;
                $operate['coid'] = $course['coid'];
                $course = M("course")->find($cid);
                $operate['class_name'] = $course['name'];
                $operate['type'] = 3;
                $operate['addtime'] = time();
                $operate['isdel'] = 0;
                $flagoperate = M("operatelog")->add($operate);//添加用户操作日志
                $flagoperatesql = M()->getLastSql();

                if ($flaglog && $flagorder && $flagoperate) {
                    M()->commit();
                    echo "<script>window.location.href = 'http://fit.24parking.com.cn/OverClass';</script>";
                } else {
                    M()->rollback();
                    echo "<script>alert('签到失败');window.history.go(-1);</script>";
                    Log::write("flaglog:" . $flaglogsql);
                    Log::write("flagorder:" . $flagordersql);
                    Log::write("flagoperate:" . $flagoperatesql);
                }
            } else {
                echo "<script>alert('签到失败，课程不存在');window.history.go(-1);</script>";
            }
        }
    }

    /**
     * s查询教练空闲时间
     */
    public function getcoachchedule()
    {
        $this->writeRequest();

        $oid = $_REQUEST['oid'];//订单ID
        $date = $_REQUEST['date'];//查询日期
        $uid = $_SESSION['uid'];//自己的uid
        $coid = $_SESSION['coid'];//教练id
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($oid)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '订单或日期信息不能为空'
            );
        } else {
            if (empty($date)) {
                $date = date('Y-m-d');
            } else {
                $date = date('Y-m-d', strtotime($date));
            }

            $where['isdel'] = 0;
            $where['id'] = $oid;
            $where['ispay'] = 1;
            $where['status'] = 1;
            $order = M("order")->where($where)->find();
            if ($order) {
                $cid = $order['coid'];
                $coach = M("coach")->find($cid);
                $times = $this->getTimes(9, 22);
                $timestatus = array();
                $modelcoachnoschedule = M("coachnoschedule");
                $modeluserschedule = M("userschedule");
                foreach ($times as $v) {
                    $tmp = explode(':', $v);
                    if ($tmp[1] == 30) {
                        $time = $tmp[0] + 0.5;
                    } else {
                        $time = $tmp[0];
                    }
                    $tmp = array();
                    $time_now = time();
                    $time_value = strtotime($date . ' ' . $v . ":00");
                    $tmp = array();
                    $tmp['time'] = $v;
                    if ($coach['status'] == 1) {
                        if ($coach['time_s'] <= $time && $time <= ($coach['time_e'] - 1)) {
                            if ($time_now < $time_value) {
                                $where = array();
                                $where['date_s'] = array("elt", $time_value);
                                $where['date_e'] = array("gt", $time_value);
                                $where['cid'] = $cid;

                                $schedule = $modelcoachnoschedule->where($where)->select();
                                if ($schedule) {
                                    $tmp['status'] = 1;
                                } else {
                                    $where = array();
                                    $where['coachid'] = $cid;
                                    $where['orderdate'] = array(array("elt", $date), array("egt", $date));
                                    $where['ordertime_s'] = array('elt', $time);
                                    $where['ordertime_e'] = array('gt', $time);
                                    $where['status'] = array('neq', 0);
                                    $userschedule = $modeluserschedule->where($where)->select();
                                    if ($userschedule) {
                                        $tmp['status'] = 2;
                                    } else {
                                        $tmp['status'] = 0;
                                    }
                                }
                            } else {//如果已过期，则直接设置为不可预约
                                $tmp['status'] = 1;
                            }
                        } else {//如果不在教练上班时间，则直接显示不可预约
                            $tmp['status'] = 1;
                        }
                    } else {//如果教练设置为不可预约，则直接显示不可预约
                        $tmp['status'] = 1;
                    }

                    $timestatus[] = $tmp;
                }

                $data['times'] = $timestatus;

                $courselog = M("courselog")->where("uid = " . $uid . " and status = 1")->order("currenthours asc, id asc")->select();
                if ($courselog) {
                    foreach ($courselog as $vv) {
                        $tmp = array();
                        $userschedule = $modeluserschedule->where("courselogid = " . $vv['id'] . " and orderdate = '" . date('Y-m-d') . "'")->find();
                        if ($userschedule) {
                            if (floor($userschedule['ordertime_s']) == $userschedule['ordertime_s']) {
                                $hours = intval($userschedule['ordertime_s']) . ":00";
                            } else {
                                $hours = floor($userschedule['ordertime_s']) . ':30';
                            }
                            $tmp['orderdate'] = $userschedule['orderdate'] . ' ' . $hours;
                            $tmp['course'] = $vv['ctitle'];
                            $coach = M("coach")->find($vv['coid']);
                            $tmp['coach'] = $coach['name'];
                        }
                        $lastorder[] = $tmp;
                    }
                } else {
                    $lastorder[] = array();
                }
                $data['lastorder'] = $lastorder;

                $result['response'] = array(
                    'code' => '200',
                    'msg' => '操作成功',
                    'data' => $data
                );
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '订单不存在'
                );
            }

        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s用户约课
     */
    public function setuserschedule()
    {
        $this->writeRequest();

        $oid = $_REQUEST['oid'];//订单
        $date = $_REQUEST['date'];//预约日期
        $hour_s = $_REQUEST['hour_s'];

        $type = $_REQUEST['type'];//0表示用户自己预约，1表示教练帮忙预约
        if ($type == 1) {
            $order = M("order")->find($oid);
            $uid = $order['uid'];
            $coid = $order['coid'];
        } else {
            $uid = $_SESSION['uid'];//自己的uid
        }
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($oid) || empty($date) || empty($hour_s)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '预约信息不能为空'
            );
        } else {

            $where['uid'] = $uid;
            $where['ispay'] = 1;
            $where['status'] = array('in', array(1, 3, 4));
            $where['isdel'] = 0;
            if($type == 1){
                $where['coid'] = $coid;
            }
            $data = M("order")->field("id,shid,coid,totalhours,cid")->where($where)->order("id desc")->select();
            $modelcourse = M("course");
            $isexperience = 0;
            $orderids = array();
            $EXPERIENCE_PRICE = C("EXPERIENCE_PRICE");
            foreach ($data as $vv) {
                $tmp = $modelcourse->find($vv['cid']);
                if ($tmp['price'] == $EXPERIENCE_PRICE) {
                    $isexperience = 1;
                    $orderids[] = $vv['id'];
                }
            }
            if ($isexperience == 1) {//存在体验课
                if (!in_array($oid, $orderids)) {//当前预约不属于体验课
                    $result['response'] = array(
                        'code' => '117',
                        'msg' => '存在体验课时必须先预约体验课'
                    );
                    $json_result = json_encode($result);
                    $this->writeRequestResult($json_result);
                    echo($json_result);
                    exit;
                }
            }

            $date = date("Y-m-d", strtotime($date));
            $tmp = explode(':', $hour_s);
            if ($tmp[1] == 30) {
                $time_s = $tmp[0] + 0.5;
            } else {
                $time_s = $tmp[0];
            }
            $time_e = $time_s + 1;
            /*$tmp = explode(':', $hour_e);
            if($tmp[1] == 30){
                $time_e = $tmp[0] + 0.5;
            }else{
                $time_e = $tmp[0];
            }*/
            $map = array();
            $map['status'] = 1;
            $map['uid'] = $uid;
            $map['orderid'] = $oid;
            $courselog = M("courselog")->where($map)->order("currenthours asc, id asc")->find();
//            if ($courselog) {
//                $result['response'] = array(
//                    'code' => '110',
//                    'msg' => '单个课程每次只能预约一次'
//                );
//            } else {
                $map = array();
                $map['status'] = 0;
                $map['uid'] = $uid;
                $map['orderid'] = $oid;
                $courselog = M("courselog")->where($map)->order("currenthours asc, id asc")->find();
                if ($courselog) {
                    if ($type == 1) {//教练代预约的情况下，不对已预约的做限制
                        $flag_c = 1;
                    } else {
                        $flag_c = $this->checkExist($courselog['coid'], $date, $time_s, $time_e);
                    }
                    if ($flag_c) {
                        M()->startTrans();
                        $data = array();
                        $data['id'] = $courselog['id'];
                        $data['ordertime'] = strtotime($date . ' ' . $hour_s . ":00");
                        if (!empty($type)) {
                            $data['type'] = 1;
                            $data['status'] = 1;
                        } else {
                            $data['status'] = 1;
                        }
                        $flag_r = M("courselog")->save($data);
                        $flag_r_sql = M()->getLastSql();

                        $data = array();
                        $data['coachid'] = $courselog['coid'];
                        $data['uid'] = $courselog['uid'];
                        $data['courselogid'] = $courselog['id'];
                        $data['status'] = 1;
                        $data['orderdate'] = $date;
                        $data['ordertime_s'] = $time_s;
                        $data['ordertime_e'] = $time_e;
                        $data['hours'] = $time_e - $time_s;
                        $data['addtime'] = time();
                        $flag_s = M("userschedule")->add($data);
                        $flag_s_sql = M()->getLastSql();

                        $course = M("course")->find($courselog['cid']);
                        $operate['uid'] = $uid;
                        $operate['coid'] = $courselog['coid'];
                        $operate['class_name'] = $course['name'];
                        $operate['type'] = 2;
                        $operate['addtime'] = time();
                        $operate['isdel'] = 0;
                        $flagoperate = M("operatelog")->add($operate);//添加用户操作日志
                        $flagoperatesql = M()->getLastSql();

                        if ($flag_r && $flag_s && $flagoperate) {
                            M()->commit();

                            $userinfo = M("userinfo")->find($courselog['uid']);
                            if ($userinfo['openid']) {
                                $course = M("course")->find($courselog['cid']);
                                $coach = M("coach")->find($courselog['coid']);
                                $sporthall = M("sporthall")->find($courselog['shid']);
                                if (floor($time_s) == $time_s) {
                                    $time_s = $time_s . ":00";
                                } else {
                                    $time_s = floor($time_s) . ":30";
                                }
                                //通知会员
                                $map = array();
                                if ($type == 1) {
                                    $map['first']['value'] = '恭喜，教练代预约成功';
                                } else {
                                    $map['first']['value'] = '恭喜，预约成功';
                                }
                                $map['keyword1']['value'] = $course['name'];
                                $map['keyword2']['value'] = $sporthall['name'];
                                $map['keyword3']['value'] = $coach["name"];
                                $map['keyword4']['value'] = $date . " " . $time_s;
                                $payurl = '';
                                $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
                                $body = $this->sendTmplMsg('pmBfBkwEIQcE4duax54oFjZzMKVGQmpxzLumuQ3eeIw', $userinfo['openid'], $map, $payurl);
                                $this->getWechat()->sendTemplateMessage($body);

                                //通知教练
                                $map = array();
                                $map['first']['value'] = $coach["name"] . '教练您好，有会员预约了您的课程';
                                $map['keyword1']['value'] = $userinfo['name'];
                                $map['keyword2']['value'] = $userinfo['phone'];
                                $map['keyword3']['value'] = $course['name'];
                                $map['keyword4']['value'] = $date . " " . $time_s;
                                $map['keyword5']['value'] = date('Y-m-d H:i:s');
                                $payurl = '';
                                $map['remark']['value'] = '请为会员合理安排上课时间。';
                                $userinfo_coach = M("userinfo")->where("isdel = 0 and phone = '" . $coach['phone'] . "'")->find();

                                $body = $this->sendTmplMsg('nV6N_8ZNSiQZPf_mogmXKKHkAZ_kweoFxVINIECvTOI', $userinfo_coach['openid'], $map, $payurl);
                                $f = $this->getWechat()->sendTemplateMessage($body);
                                Log::write("fa song cheng gong");
                            }else{
                                Log::write("fa song shi bai");
                            }

                            $result['response'] = array(
                                'code' => '200',
                                'msg' => '预约成功'
                            );
                        } else {
                            M()->rollback();
                            $result['response'] = array(
                                'code' => '105',
                                'msg' => '预约失败'
                            );
                            Log::write("flag_r_sql:" . $flag_r_sql);
                            Log::write("flag_s_sql:" . $flag_s_sql);
                            Log::write("flagoperatesql:" . $flagoperatesql);
                        }
                    } else {
                        $result['response'] = array(
                            'code' => '113',
                            'msg' => '预约日期已过期或已被其他人预定'
                        );
                    }
                } else {
                    $result['response'] = array(
                        'code' => '110',
                        'msg' => '课程不存在或不可预约'
                    );
                }
//            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s用户评论
     */
    public function userevaluate()
    {
        $this->writeRequest();
        $cid = $_REQUEST['cid'];//教练ID
        $content = $_REQUEST['content'];
        $score = $_REQUEST['score'];
        $imgs = $_REQUEST['imgs'];
        $uid = $_SESSION['uid'];//自己的uid
        $courselogid = $_REQUEST['courselogid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($cid) || empty($score)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '评论参数不正确'
            );
        } else {
            $data['uid'] = $uid;
            $data['cid'] = $cid;
            if (empty($content)) {
                $content = '默认好评';
            }
            $data['content'] = $content;
            $data['score'] = $score;
            $data['addtime'] = time();
            $data['imgs'] = $imgs;
            $data['courselogid'] = $courselogid;
            $flag = M("evaluate")->add($data);

            if ($flag) {
                $result['response'] = array(
                    'code' => '200',
                    'msg' => '评论成功'
                );
            } else {
                $result['response'] = array(
                    'code' => '105',
                    'msg' => '评论失败'
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s上传评论图片
     */
    public function uploadimage()
    {
        $this->writeRequest();
        $uid = $_REQUEST['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            if ($_FILES) {
                M()->startTrans();
                $id = '';
                $flag = true;
                if ($_FILES["images"]["error"] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["images"]["tmp_name"];
                    $names = explode('.', $_FILES["images"]["name"]);
                    $name = time() . $this->getRandChar(4) . '.' . $names[1];
                    $position = "Uploads/Picture/$name";
                    $flag = move_uploaded_file($tmp_name, $position);
                    $data['url'] = "/" . $position;
                    $data['addtime'] = time();
                    $data['uid'] = $uid;
                    $id = M("images")->add($data);
                }

                if ($id && $flag) {
                    M()->commit();
                    $result['response'] = array(
                        'code' => '200',
                        'msg' => '图片上传成功',
                        'data' => $id
                    );
                } else {
                    M()->rollback();
                    $result['response'] = array(
                        'code' => '115',
                        'msg' => '图片上传错误'
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '图片不能为空'
                );
            }
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取用户订单
     */
    public function getuserorder()
    {
        $this->writeRequest();

        $uid = $_SESSION['uid'];//自己的uid
        $type = $_REQUEST['type'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            if (empty($type)) {
                $type = 0;//默认获取未支付的订单
            } else {
                $type = 1;
            }
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $where['uid'] = $uid;
            $where['ispay'] = $type;
            $where['isdel'] = 0;
            $data = M("order")->field("id,number,realamount,status,shid,coid,cid,totalhours,addtime")->where($where)->limit($pageid * $pagesize, $pagesize)->order("id desc")->select();
            $count = M("order")->where($where)->count();
            $modelsporthall = M("sporthall");
            $modelcoach = M("coach");
            $modelcourse = M("course");
            $modelcoachcourse = M("coachcourse");
            foreach ($data as &$v) {
                $v['addtime'] = date('Y-m-d H:i', $v['addtime']);
                $tmp = $modelsporthall->find($v['shid']);
                $v['sporthall'] = $tmp['name'];
                unset($v['shid']);

                $tmp = $modelcoachcourse->where("coachid = " . $v['coid'] . " and courseid = " . $v['cid'])->find();
                $v['price'] = $tmp['price'];

                $tmp = $modelcoach->find($v['coid']);
                $v['coach'] = $tmp['name'];
                $v['phone'] = $tmp['phone'];
                unset($v['coid']);

                $tmp = $modelcourse->find($v['cid']);
                $v['course'] = $tmp['name'];
                //$v['courseimg'] = $tmp['img'];
                if (strstr($tmp['img'], 'http')) {
                    $v['courseimg'] = $tmp['img'];
                } else {
                    $v['courseimg'] = C("IMAGE_URL") . $tmp['img'];
                }
                unset($v['cid']);
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s获取用户约课列表
     */
    public function getusercourse()
    {
        $this->writeRequest();

        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $where['uid'] = $uid;
            $where['ispay'] = 1;
            $where['status'] = array('in', array(1, 3, 4));
            $where['isdel'] = 0;
            $data = M("order")->field("id,shid,coid,totalhours,cid")->where($where)->limit($pageid * $pagesize, $pagesize)->order("id desc")->select();
            $count = M("order")->where($where)->count();
            $modelsporthall = M("sporthall");
            $modelcoach = M("coach");
            $modellogcourse = M("courselog");
            $modelcourse = M("course");
            $modelcoachcourse = M("coachcourse");
            $EXPERIENCE_PRICE = C("EXPERIENCE_PRICE");
            foreach ($data as &$v) {
                $tmp = $modelsporthall->find($v['shid']);
                $v['sporthall'] = $tmp['name'];
                $v['latitude'] = $tmp['latitude'];
                $v['longitude'] = $tmp['longitude'];
                $v['address'] = $tmp['province'] . $tmp['city'] . $tmp['dist'] . $tmp['address'];

                $tmp = $modelcoach->find($v['coid']);
                $v['coach'] = $tmp['name'];
                $v['phone'] = $tmp['phone'];
                if (strstr($tmp['headimg'], 'http')) {
                    $v['headimg'] = $tmp['headimg'];
                } else {
                    $v['headimg'] = C("IMAGE_URL") . $tmp['headimg'];
                }

                $tmp = $modellogcourse->where("status in(1, 3) and orderid = " . $v['id'])->order(" currenthours desc,id desc")->find();
                /*if($tmp['status'] == 0){
                    $v['isordercourse'] = 0;
                    $v['currenthours'] = $tmp['currenthours'] - 1;
                }else*/
                if ($tmp) {
                    if ($tmp['status'] == 1) {
                        $v['currenthours'] = $tmp['currenthours'];
                        $v['isordercourse'] = 1;
                        $v['shownoclass'] = 0;
                    } elseif ($tmp['status'] == 3) {
                        if ($v['totalhours'] > $tmp['currenthours']) {
                            if ($tmp['signtime'] < strtotime("-7 days")) {
                                $v['shownoclass'] = 1;
                            } else {
                                $v['shownoclass'] = 0;
                            }
                            $v['isordercourse'] = 0;
                            $v['currenthours'] = $tmp['currenthours'] + 1;
                        } else {
                            $v['shownoclass'] = 0;
                            $v['isordercourse'] = 2;
                            $v['currenthours'] = $tmp['currenthours'];
                        }
                    }
                } else {
                    $v['isordercourse'] = 0;
                    $v['currenthours'] = 1;
                    $v['shownoclass'] = 0;
                }

                $tmp = $modelcourse->find($v['cid']);
                $v['course'] = $tmp['name'];
                $v['courseimg'] = $tmp['img'];
                if ($tmp['price'] == $EXPERIENCE_PRICE) {
                    $v['isexperience'] = 1;
                } else {
                    $v['isexperience'] = 0;
                }

                $map = array();
                $map['isdel'] = 0;
                $map['coachid'] = $v['coid'];
                $map['cid'] = $v['cid'];
                $tmp = $modelcoachcourse->where($map)->find();
                $v['cid'] = $tmp['id'];

                unset($v['coid']);
                unset($v['shid']);
//                unset($v['cid']);
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s订单支付接口
     */
    public function orderpay()
    {
        $this->writeRequest();

        $this->writeRequestResult("session:" . json_encode($_SESSION));
        $number = $_REQUEST['number'];
        $uid = $_SESSION['uid'];
        if (empty($uid) || empty($number)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $where['number'] = $number;
            $where['uid'] = $uid;
            $where['ispay'] = 0;
            $where['status'] = 0;
            $where['isdel'] = 0;
            $order = M("order")->field("id,number,shid,coid,cid,addtime,amount,reduce,realamount,totalhours")->where($where)->find();

            if ($order) {
                $sporthall = M("sporthall")->find($order['shid']);
                $order['sporthall'] = $sporthall['name'];
                $order['address'] = $sporthall['province'] . $sporthall['city'] . $sporthall['dist'] . $sporthall['address'];

                $coach = M("coach")->find($order['coid']);
                $order['coach'] = $coach['name'];
                if (strstr($coach['headimg'], 'http')) {
                    $order['headimg'] = $coach['headimg'];
                } else {
                    $order['headimg'] = C("IMAGE_URL") . $coach['headimg'];
                }

                $course = M("course")->find($order['cid']);
                $order['course'] = $course['name'];

                $coachcourse = M("coachcourse")->where("isdel = 0 and coachid = " . $order['coid'] . " and courseid = " . $order['cid'])->find();
                $order['price'] = $coachcourse['price'];

                $order['addtime'] = date("Y-m-d H:i:s", $order['addtime']);
                unset($order['shid']);
                unset($order['coid']);
                unset($order['cid']);
                $data['orderinfo'] = $order;

                $out_trade_no = time() . $this->getRandChar(5);
                $payorder['oid'] = $order['id'];
                $payorder['number'] = $out_trade_no;
                $payorder['addtime'] = time();
                $payorder['amount'] = $order['realamount'];
                $flag_payorder = M("wxpayorder")->add($payorder);

                $body = '卓赢健身' . $course['name'] . '课程报名费用';
                $data['paypost'] = $this->wxPayPost($order['realamount'], $out_trade_no, $body);


                $result['response'] = array(
                    'code' => '200',
                    'msg' => '操作成功',
                    'data' => $data
                );
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '订单不存在'
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s新增订单
     */
    public function createorder()
    {
        $this->writeRequest();
        $uid = $_SESSION['uid'];//自己的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        $cid = $_REQUEST['id'];
        $totalhours = $_REQUEST['totalhours'];
        if ($cid) {
            $course = M("course")->field("tblcourse.id,tblcourse.name,tblcourse.salelimit,tblcoachcourse.price,tblcoachcourse.coachid")
                ->join("tblcoachcourse on tblcourse.id = tblcoachcourse.courseid")
                ->where("tblcoachcourse.isdel = 0 and tblcourse.isdel = 0 and tblcoachcourse.id = " . $cid)->find();
            if ($course) {
                $map['id'] = $course['coachid'];
                $map['isdel'] = 0;
                $coach = M("coach")->where($map)->find();
                if ($coach) {
                    $map['id'] = $coach['shids'];
                    $map['isdel'] = 0;
                    $map['active'] = 1;
                    $sporthall = M("sporthall")->where($map)->find();
                    if ($sporthall) {
                        $amount = $totalhours * $course['price'];

                        M()->startTrans();
                        $order['number'] = time() . $this->getRandCharNum(4);
                        $order['uid'] = $_SESSION['uid'];
                        $order['amount'] = $amount;
                        $order['realamount'] = $amount;
                        $order['addtime'] = time();
                        $order['shid'] = $sporthall['id'];
                        $order['coid'] = $coach['id'];
                        $order['cid'] = $course['id'];
                        $order['totalhours'] = $totalhours;
                        $flag_order = M("order")->add($order);
                        if ($flag_order) {
                            M()->commit();
                            $result['response'] = array(
                                'code' => '200',
                                'msg' => '操作成功',
                                'data' => $order['number']
                            );
                        } else {
                            M()->rollback();
                            Log::write("新增订单：" . $flag_order . "，sql：" . M()->getLastSql());
                            $result['response'] = array(
                                'code' => '105',
                                'msg' => '网络或系统错误'
                            );
                        }
                    } else {
                        $result['response'] = array(
                            'code' => '110',
                            'msg' => '场馆不存在或已关闭',
                        );
                    }
                } else {
                    $result['response'] = array(
                        'code' => '110',
                        'msg' => '教练不存在或已删除',
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '课程不存在或已删除',
                );
            }
        } else {
            $result['response'] = array(
                'code' => '100',
                'msg' => '未选择课程',
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s获取教练订单列表
     */
    public function getcoachorder()
    {
        $this->writeRequest();

        $uid = $_SESSION['coid'];//教练的uid
        $type = $_REQUEST['type'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            if (empty($type)) {
                $type = 0;//默认获取未支付的订单
            } else {
                $type = 1;
            }
            $where['coid'] = $uid;
            $where['ispay'] = $type;
            $where['isdel'] = 0;
            $data = M("order")->field("id,number,amount,reduce,reducetype,realamount,status,shid,uid,cid,totalhours,addtime")->where($where)->order("id desc")->select();
            $modelsporthall = M("sporthall");
            $modeluserinfo = M("userinfo");
            $modelcourse = M("course");
            $modelcoachcourse = M("coachcourse");
            foreach ($data as &$v) {
                $v['addtime'] = date('Y-m-d H:i', $v['addtime']);
                $tmp = $modelsporthall->find($v['shid']);
                $v['sporthall'] = $tmp['name'];
                $v['address'] = $tmp['province'] . $tmp['city'] . $tmp['dist'] . $tmp['address'];
                unset($v['shid']);

                $tmp = $modelcoachcourse->where("coachid = " . $uid . " and courseid = " . $v['cid'])->find();
                $v['price'] = $tmp['price'];

                $tmp = $modeluserinfo->find($v['uid']);
                $v['username'] = $tmp['name'];
                $v['headimg'] = $tmp['headimg'];
                $v['phone'] = $tmp['phone'];
                unset($v['uid']);

                $tmp = $modelcourse->find($v['cid']);
                $v['course'] = $tmp['name'];
                unset($v['cid']);
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取教练下属学员信息列表
     */
    public function getstudent()
    {
        $this->writeRequest();

        $uid = $_SESSION['coid'];//教练的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $where['coid'] = $uid;
            $where['ispay'] = 1;
            $where['isdel'] = 0;
            $where['status'] = array("in", array(1, 3, 4));
            $data = M("order")->field("id,shid,uid,cid,status,totalhours")->where($where)->limit($pageid * $pagesize, $pagesize)->order("id desc")->select();
            $count = M("order")->where($where)->count();
            $modelsporthall = M("sporthall");
            $modeluserinfo = M("userinfo");
            $modelcourse = M("course");
            $modelcourselog = M("courselog");
            $keyword = $_REQUEST['keyword'];
            $EXPERIENCE_PRICE = C("EXPERIENCE_PRICE");
            foreach ($data as $k => &$v) {
                $tmp = $modelsporthall->find($v['shid']);
                $v['sporthall'] = $tmp['name'];
                $v['address'] = $tmp['province'] . $tmp['city'] . $tmp['dist'] . $tmp['address'];
                unset($v['shid']);

                $map = array();
                $map['id'] = $v['uid'];
                if ($keyword) {
                    $map['name|phone'] = array("like", "%" . $keyword . "%");
                }
                $tmp = $modeluserinfo->where($map)->find();
                if (empty($tmp)) {
                    unset($data[$k]);
                    continue;
                }
                $v['username'] = $tmp['name'];
                if (empty($tmp['headimg'])) {
                    $v['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                } else {
                    if (strstr($tmp['headimg'], 'http')) {
                        $v['headimg'] = $tmp['headimg'];
                    } else {
                        $v['headimg'] = C("IMAGE_URL") . $tmp['headimg'];
                    }
                }

                $v['phone'] = $tmp['phone'];
                unset($v['uid']);

                $tmp = $modelcourselog->where("status in(1, 3) and orderid = " . $v['id'])->order("currenthours asc,id asc")->find();

                if ($tmp) {
                    if ($tmp['status'] == 1) {
                        $v['currenthours'] = $tmp['currenthours'];
                        $v['isordercourse'] = 1;
                        $v['shownoclass'] = 0;
                    } elseif ($tmp['status'] == 3) {
                        if ($v['totalhours'] > $tmp['currenthours']) {
                            if ($tmp['signtime'] < strtotime("-7 days")) {
                                $v['shownoclass'] = 1;
                            } else {
                                $v['shownoclass'] = 0;
                            }
                            $v['isordercourse'] = 0;
                            $v['currenthours'] = $tmp['currenthours'] + 1;
                        } else {
                            $v['shownoclass'] = 0;
                            $v['isordercourse'] = 2;
                            $v['currenthours'] = $tmp['currenthours'];
                        }
                    }
                } else {
                    $v['isordercourse'] = 0;
                    $v['currenthours'] = 1;
                    $v['shownoclass'] = 0;
                }

                $tmp = $modelcourse->find($v['cid']);
                $v['course'] = $tmp['name'];
                if ($tmp['price'] == $EXPERIENCE_PRICE) {
                    $v['isexperience'] = 1;
                } else {
                    $v['isexperience'] = 0;
                }
                unset($v['cid']);
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s获取教练课表
     */
    public function getschedulebycoach()
    {
        $this->writeRequest();

        $uid = $_SESSION['coid'];//教练的uid
        $date = $_REQUEST['date'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '教练未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($date)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '日期未选择'
            );
        } else {
            $date = date('Y-m-d', strtotime($date));
            $where['coid'] = $uid;
            $where['ordertime'] = array(
                array('egt', strtotime($date . " 00:00:00")),
                array('lt', strtotime($date . " 23:59:59"))
            );
            $where['isdel'] = 0;
            $where['status'] = array("in", array(1, 3));
            $data = M("courselog")->field("id,shid,uid,cid,currenthours,totalhours,signtime,ordertime")->where($where)->order("ordertime asc")->select();


            $modelsporthall = M("sporthall");
            $modeluserinfo = M("userinfo");
            $modelcourse = M("course");
            $modeluserschedule = M("userschedule");
            foreach ($data as &$v) {
                $tmp = $modeluserschedule->where("courselogid = " . $v['id'] . " and orderdate = '" . $date . "'")->find();

                if (ceil($tmp['ordertime_s']) == $tmp['ordertime_s']) {//表明是整点
                    $v['ordertime_s'] = intval($tmp['ordertime_s']) . ':00';
                } else {
                    $v['ordertime_s'] = floor($tmp['ordertime_s']) . ':30';
                }

                if ($v['signtime'] > 0) {//表明已签到
                    $v['issign'] = 1;
                } else {
                    //strtotime($v['orderdate'].' '.$v['ordertime_s'].":00")
                    $v['issign'] = 0;
                    /*if($v['ordertime'] > time()){
                        $v['issign'] = 0;
                    }else{//预约时间超过当前时间
                        $v['issign'] = 2;//已超时，缺课
                    }*/
                }
                unset($v['signtime']);

                $tmp = $modelsporthall->find($v['shid']);
                $v['sporthall'] = $tmp['name'];
                unset($v['shid']);

                $tmp = $modeluserinfo->find($v['uid']);
                $v['username'] = $tmp['name'];
                if (empty($tmp['headimg'])) {
                    $v['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                } else {
                    if (strstr($tmp['headimg'], 'http')) {
                        $v['headimg'] = $tmp['headimg'];
                    } else {
                        $v['headimg'] = C("IMAGE_URL") . $tmp['headimg'];
                    }
                }

                $v['phone'] = $tmp['phone'];
                unset($v['uid']);

                $tmp = $modelcourse->find($v['cid']);
                $v['course'] = $tmp['name'];
                unset($v['cid']);
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取教练签到二维码
     */
    public function getsignqrcode()
    {
        $this->writeRequest();

        $uid = $_SESSION['coid'];//教练的uid
        $cid = $_REQUEST['courselogid'];//课耗ID
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($cid)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '未选择课耗'
            );
        } else {
            $where['id'] = $cid;
            $where['coid'] = $uid;
            $where['signtime'] = 0;
            $where['status'] = 1;
            $courselog = M("courselog")->where($where)->find();
            if ($courselog) {
                $signurl = 'http://' . $_SERVER['HTTP_HOST'] . "/Mobile/Api/usersignup/cid/" . $cid;
                $filename = time() . $this->getRandChar(4) . ".png";
                $qrcode = 'http://' . $_SERVER['HTTP_HOST'] . $this->createQrcode($signurl, $filename);
                $result['response'] = array(
                    'code' => '200',
                    'msg' => '获取成功',
                    'data' => $qrcode
                );
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '课程不存在或已过期'
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s查看教练中心
     */
    public function getinfobycoach()
    {
        $this->writeRequest();
        $coachid = $_REQUEST['cid'];
        if ($coachid) {
            $cid = think_decrypt($coachid, "zhuoying");
            if ($cid > 0) {
                $_SESSION['coid'] = $cid;
            }
        }
        $uid = $_SESSION['coid'];//教练的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '教练未登录'
            );
        } else {
            $coach = M("coach")->field("name,headimg,score,shids")->find($uid);
            if (!strstr($coach['headimg'], 'http')) {
                $coach['headimg'] = C("IMAGE_URL") . $coach['headimg'];
            }
            $sporthall = M("sporthall")->find($coach['shids']);
            $coach['sporthall'] = $sporthall['name'];
            unset($coach['shids']);
            $label = M("label")->where("cid = " . $uid)->select();
            $tmp = array();
            foreach ($label as $v) {
                $tmp[] = $v['title'];
            }
            $coach['label'] = $tmp;

            $coach['evaluate'] = M("evaluate")->where("cid = " . $uid)->count();

            $where['coid'] = $uid;
            $where['ispay'] = 1;
            $where['isdel'] = 0;
            $where['status'] = array("in", array(1, 4));
            $where['paytime'] = array('egt', strtotime(date("Y-m") . "-01 00:00:00"));
            $orderamount = M("order")->where($where)->sum("realamount");
            if (empty($orderamount)) {
                $orderamount = 0;
            }
            $coach['orderamount'] = $orderamount;

            $totaohours = M("order")->where($where)->sum("totalhours");
            if (empty($totaohours)) {
                $totaohours = 0;
            }
            $coach['totalhours'] = $totaohours;

            $ordernums = M("order")->where($where)->count();
            if (empty($ordernums)) {
                $ordernums = 0;
            }
            $coach['ordernums'] = $ordernums;

            $saleamount = array();
            for ($i = 0; $i < 7; $i++) {
                $date = date("m-d", strtotime("-" . $i . " days"));
                $where = array();
                $where['coid'] = $uid;
                $where['ispay'] = 1;
                $where['isdel'] = 0;
                $where['status'] = array("in", array(1, 4));
                $where['paytime'] = array(
                    array('egt', strtotime($date . "00:00:00")),
                    array('elt', strtotime($date . "23:59:59"))
                );
                $tmp = M("order")->where($where)->sum("realamount");
                if (empty($tmp)) {
                    $tmp = 0;
                }
                $saleamount[] = array(
                    "日期" => $date,
                    "销售额" => $tmp
                );
            }
            $coach['saleamountbyday'] = $saleamount;


            $saleamount = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date("Y-m", strtotime("-" . $i . " months"));
                $month_next = date("Y-m", strtotime("-" . ($i - 1) . " months"));
                $month_num = ltrim(date("m", strtotime("-" . $i . " months")), '0');
                $where = array();
                $where['coid'] = $uid;
                $where['ispay'] = 1;
                $where['isdel'] = 0;
                $where['status'] = array("in", array(1, 4));
                $where['paytime'] = array(
                    array('egt', strtotime($month . " -1 00:00:00")),
                    array('lt', strtotime($month_next . "-1 00:00:00"))
                );
                $tmp = M("order")->where($where)->sum("realamount");
                if (empty($tmp)) {
                    $tmp = 0;
                }
                $saleamount[] = array(
                    "月份" => $month_num . '月份',
                    "销售额" => $tmp
                );
            }
            $coach['saleamountbymonth'] = $saleamount;

            $courselog = array();
            for ($i = 0; $i < 7; $i++) {
                $date = date("m-d", strtotime("-" . $i . " days"));
                $where = array();
                $where['coid'] = $uid;
                $where['ispay'] = 1;
                $where['isdel'] = 0;
                $where['status'] = array("in", array(1, 4));
                $where['paytime'] = array(
                    array('egt', strtotime($date . "00:00:00")),
                    array('elt', strtotime($date . "23:59:59"))
                );
                $tmp = M("order")->where($where)->sum("totalhours");
                if (empty($tmp)) {
                    $tmp = 0;
                }
                $courselog[] = array(
                    "日期" => $date,
                    "课耗" => $tmp
                );
            }
            $coach['courselogbyday'] = $courselog;


            $courselog = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date("Y-m", strtotime("-" . $i . " months"));
                $month_next = date("Y-m", strtotime("-" . ($i - 1) . " months"));
                $month_num = ltrim(date("m", strtotime("-" . $i . " months")), '0');
                $where = array();
                $where['coid'] = $uid;
                $where['ispay'] = 1;
                $where['isdel'] = 0;
                $where['status'] = array("in", array(1, 4));
                $where['paytime'] = array(
                    array('egt', strtotime($month . " -1 00:00:00")),
                    array('lt', strtotime($month_next . "-1 00:00:00"))
                );
                $tmp = M("order")->where($where)->sum("totalhours");
                if (empty($tmp)) {
                    $tmp = 0;
                }
                $courselog[] = array(
                    "月份" => $month_num . '月份',
                    "课耗" => $tmp
                );
            }
            $coach['courselogbymonth'] = $courselog;


            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $coach
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * 按月获取教练销售
     */
    public function getcoachsale()
    {
        $this->writeRequest();
        $uid = $_SESSION['coid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $type = 0;
            if (!empty($_REQUEST['type'])) {
                $type = $_REQUEST['type'];
            }
            $map['t1.coid'] = $uid;
            $map['t1.isdel'] = 0;
            $map['t1.cid'] = array('NEQ', 1);
            $map['t1.status'] = array('in', array(1, 4));
            if (empty($type)) {
                //按月查看
                $selectMonth = $_REQUEST['date'];//传来的月份
                if (!empty($selectMonth)) {
                    //如果传来的月份不是空
                    //如果传来的日期小于18年1月1日 获取之前所有的订单
                    if (strtotime($selectMonth) < strtotime('2018-01-01')) {
                        $map['t1.addtime'] = array('LT', strtotime('2018-01-01'));
                    } else {
                        //如果大于18年1月1日，按月获取
                        $timeArr = explode('-', $selectMonth);
                        $year = $timeArr[0];
                        $month = $timeArr[1];
                        $start = $year . '-' . $month . '-01';
                        $end = date('Y-m-d', strtotime("$start +1 month"));
                        $map['t1.addtime'] = array(array('LT', strtotime($end)), array('EGT', strtotime($start)));
                    }
                } else {
                    //如果没有传月份 则获取本月
                    if (strtotime(date('Y-m-d')) < strtotime('2018-01-01')) {
                        //如果当前时间小于18年1.1日 则获取之前所有订单
                        $map['t1.addtime'] = array('LT', strtotime('2018-01-01'));
                    } else {
                        //如果当前时间大于18年1.1日 则按月获取订单
                        $begin = date('Y-m-01', strtotime(date("Y-m-d")));
                        $end = date('Y-m-d', strtotime("$begin +1 month"));
                        $map['t1.addtime'] = array(array('LT', strtotime($end)), array('EGT', strtotime($begin)));
                    }

                }
            }
            $tmp = M('order')->alias('t1')
                ->join('left join tbluserinfo t2 on t1.uid = t2.id')
                ->join('left join tblcourse t3 on t1.cid = t3.id')
                ->where($map)
                ->order('t1.id desc')
                ->field("t1.id,t1.number,t1.realamount,t1.status,t1.totalhours,FROM_UNIXTIME(t1.addtime,'%Y-%m-%d') as addtime,t2.name,t2.headimg,t3.name as cname")
                ->select();
            foreach ($tmp as $k => $item) {
                if (empty($item['headimg'])) {
                    $tmp[$k]['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                } else {
                    if (strstr($item['headimg'], 'http')) {
                    } else {
                        $tmp[$k]['headimg'] = C("IMAGE_URL") . $item['headimg'];
                    }
                }
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $tmp
            );
        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * 获取教练本月课耗
     */
    public function getcoachcourselog()
    {
        $this->writeRequest();
        $uid = $_SESSION['coid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $type = 0;
            if (!empty($_REQUEST['type'])) {
                $type = $_REQUEST['type'];
            }

            $map['t1.coid'] = $uid;
            $map['t1.isdel'] = 0;
            $map['t1.cid'] = array('NEQ', 1);
            $map['t1.status'] = array('in', array(3));
            //如果是本月

            if (empty($type)) {
                $selectMonth = $_REQUEST['date'];
                if (!empty($selectMonth)) {
                    if (strtotime($selectMonth) < strtotime('2018-01-01')) {
                        $map['t1.addtime'] = array('LT', strtotime('2018-01-01'));
                    } else {
                        //如果月份不是空
                        $timeArr = explode('-', $selectMonth);
                        $year = $timeArr[0];
                        $month = $timeArr[1];
                        $start = $year . '-' . $month . '-01';
                        $end = date('Y-m-d', strtotime("$start +1 month"));
                        $map['t1.addtime'] = array(array('LT', strtotime($end)), array('EGT', strtotime($start)));
                    }
                } else {
                    if (strtotime(date('Y-m-d')) < strtotime('2018-01-01')) {
                        $map['t1.addtime'] = array('LT', strtotime('2018-01-01'));
                    } else {
                        $begin = date('Y-m-01', strtotime(date("Y-m-d")));
                        $end = date('Y-m-d', strtotime("$begin +1 month"));
                        $map['t1.addtime'] = array(array('LT', strtotime($end)), array('EGT', strtotime($begin)));
                    }

                }
            }

            $tmp = M("courselog")->alias('t1')
                ->join('left join tblorder as t2 on t2.id = t1.orderid')
                ->join('left join tbluserinfo as t3 on t3.id = t1.uid')
                ->where($map)
                ->order('t1.id desc')
                ->field("t1.currenthours,t1.ctitle,t1.id,t1.uid,t1.number,t1.orderid,FROM_UNIXTIME(t1.addtime,'%Y-%m-%d') as addtime,FORMAT((t2.realamount / t2.totalhours),2) as price,t2.totalhours,t3.headimg,t3.name")->select();
            foreach ($tmp as $k => $item) {
                if (empty($item['headimg'])) {
                    $tmp[$k]['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                } else {
                    if (strstr($item['headimg'], 'http')) {
                    } else {
                        $tmp[$k]['headimg'] = C("IMAGE_URL") . $item['headimg'];
                    }
                }
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $tmp
            );

        }
        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取学员课耗
     */
    public function getstudentcourselog()
    {
        $this->writeRequest();
        $uid = $_SESSION['coid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $map['coid'] = $uid;
            $map['isdel'] = 0;
            $map['ispay'] = 1;
            $map['status'] = array('in', array(1, 3, 4));
            $tblorder = M("order")->where($map)->select();
            if (empty($tblorder)) {
                $data = array();
            } else {
                foreach ($tblorder as $v) {
                    $map = array();
                    $map['orderid'] = $v['id'];
                    //$map['status'] = 1;
                    $map['status'] = array('in', array(1, 3));
                    $courselog = M("courselog")->field("id,cid,uid,shid,ctitle,coid,totalhours,currenthours,ordertime,signtime,canceltime,status")->where($map)->order("id asc")->find();

                    if ($courselog) {
                        if ($courselog['ordertime'] > 0) {
                            $courselog['ordertime'] = date("Y-m-d H:i", $courselog['ordertime']);
                        }
                        if ($courselog['canceltime'] > 0) {
                            $courselog['canceltime'] = date("Y-m-d H:i", $courselog['canceltime']);
                        }
                        if ($courselog['ordertime'] < $courselog['signtime']) {
                            $courselog['late'] = 1;
                        } else {
                            $courselog['late'] = 0;
                        }

                        $sporthall = M("sporthall")->find($courselog['shid']);
                        $courselog['sporthall'] = $sporthall['name'];
                        $courselog['address'] = $sporthall['province'] . $sporthall['city'] . $sporthall['dist'] . $sporthall['address'];
                        $courselog['navurl'] = $sporthall['navurl'];
                        $courselog['sporthall'] = $sporthall['name'];
                        $courselog['latitude'] = $sporthall['latitude'];
                        $courselog['longitude'] = $sporthall['longitude'];

                        $userinfo = M("userinfo")->find($courselog['uid']);
                        $courselog['username'] = $userinfo['name'];
                        //$courselog['headimg'] = $userinfo['headimg'];

                        if (empty($userinfo['headimg'])) {
                            $courselog['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                        } else {
                            if (strstr($userinfo['headimg'], 'http')) {
                                $courselog['headimg'] = $userinfo['headimg'];
                            } else {
                                $courselog['headimg'] = C("IMAGE_URL") . $userinfo['headimg'];
                            }
                        }


                        $courselog['phone'] = $userinfo['phone'];

                        $course = M("coachcourse")->where("coachid = " . $courselog['coid'] . " and courseid = " . $courselog['cid'])->find();
                        $courselog['price'] = $course['price'];

                        unset($courselog['shid']);
                        unset($courselog['coid']);
                        unset($courselog['signtime']);
                    }
                    $data[] = $courselog;
                }
            }
            $result['response'] = array(
                'code' => '200',
                'msg' => '操作成功',
                'data' => $data
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }


    /**
     * s用户确认约课接口
     */
    public function userconfirmcourselog()
    {
        $this->writeRequest();
        $courselogid = $_REQUEST['courselogid'];
        $uid = $_SESSION['uid'];
        if (empty($uid)) {
            $result['response'] = array(
                'code' => 109,
                'msg' => '用户未登录'
            );
            $json_result = json_encode($result);
            $this->writeRequestResult($json_result);
            echo($json_result);
            exit;
        }
        if (empty($courselogid)) {
            $result['response'] = array(
                'code' => '100',
                'msg' => '课耗信息错误'
            );
        } else {
            $map['id'] = $courselogid;
            $map['type'] = 1;
            $map['isdel'] = 0;
            $courselog = M("courselog")->where($map)->find();
            if ($courselog) {
                $data['id'] = $courselogid;
                $data['status'] = 1;
                $flag = M("courselog")->save($data);
                if ($flag) {
                    $result['response'] = array(
                        'code' => '200',
                        'msg' => '操作成功'
                    );
                } else {
                    $result['response'] = array(
                        'code' => '105',
                        'msg' => '系统或网络错误'
                    );
                }
            } else {
                $result['response'] = array(
                    'code' => '110',
                    'msg' => '课程信息不存在或已确认预约'
                );
            }
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s根据关键词搜索教练下属学员信息列表
     */
    public function searchstudent()
    {
        $this->writeRequest();

        $uid = $_SESSION['coid'];//教练的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $keyword = $_REQUEST['keyword'];
            $where['tblorder.coid'] = $uid;
            $where['tblorder.ispay'] = 1;
            $where['tblorder.isdel'] = 0;
            $where['tblorder.status'] = array("in", array(1, 4));
            $where['tbluserinfo.name|tbluserinfo.phone'] = array("like", "%" . $keyword . "%");
            $data = M("order")->field("tbluserinfo.id,tbluserinfo.name,tbluserinfo.headimg,tbluserinfo.phone")->join("tbluserinfo on tblorder.uid = tbluserinfo.id")->where($where)->limit($pageid * $pagesize, $pagesize)->order("tbluserinfo.id desc")->group("tblorder.uid")->select();
            $count_tmp = M("order")->field("tbluserinfo.id")->join("tbluserinfo on tblorder.uid = tbluserinfo.id")->where($where)->order("tbluserinfo.id desc")->group("tblorder.uid")->select();
            $count = count($count_tmp);

            $modelorder = M("order");
            $modelcourse = M("course");
            $modelcourselog = M("courselog");
            $EXPERIENCE_PRICE = C("EXPERIENCE_PRICE");
            foreach ($data as &$v) {
                $v['uid'] = $v['id'];
                $map['uid'] = $v['id'];
                unset($v['id']);
                $map['ispay'] = 1;
                $map['isdel'] = 0;
                $map['status'] = 1;
                $order = $modelorder->where($map)->select();
                $i = 0;
                $tmp = array();

                if (empty($v['headimg'])) {
                    $v['headimg'] = 'http://crmapi.24parking.com.cn/Public/Mobile/img/nopic.png';
                } else {
                    if (strstr($v['headimg'], 'http')) {
                        $v['headimg'] = $v['headimg'];
                    } else {
                        $v['headimg'] = C("IMAGE_URL") . $v['headimg'];
                    }
                }
                foreach ($order as $vv) {
                    $courselog = $modelcourselog->where("status = 0 and orderid = " . $vv['id']." and coid = ".$uid)->order("currenthours asc,id asc")->find();
                    if ($courselog) {
                        $tmp[$i]['coid'] = $vv['coid'];
                        $tmp[$i]['id'] = $vv['id'];
                        $tmp[$i]['totalhours'] = $vv['totalhours'];
                        $tmp[$i]['currenthours'] = $courselog['currenthours'];
                        $courseinfo = $modelcourse->find($vv['cid']);
                        if ($courseinfo['price'] == $EXPERIENCE_PRICE) {
                            $tmp[$i]['isexperience'] = 1;
                        } else {
                            $tmp[$i]['isexperience'] = 0;
                        }

                        $tmp[$i]['name'] = $courseinfo['name'];
                        $i++;
                    }
                }
                $v['courselog'] = $tmp;
            }

            $result['response'] = array(
                'code' => '200',
                'msg' => '获取成功',
                'data' => $data,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    /**
     * s获取教练评价
     */
    public function getcoachevaluate()
    {
        $this->writeRequest();

        $uid = $_REQUEST['coid'];//教练的uid
        if (empty($uid)) {
            $result['response'] = array(
                'code' => '109',
                'msg' => '用户未登录'
            );
        } else {
            $pageid = $_REQUEST["pageid"];
            $pagesize = $_REQUEST["pagesize"];
            if (empty($pageid)) {
                $pageid = 0;
            }
            if (empty($pagesize)) {
                $pagesize = 10;
            }
            $evaluate = M("evaluate")->where("isdel = 0 and cid = " . $uid)->limit($pageid * $pagesize, $pagesize)->select();
            $count = M("evaluate")->where("isdel = 0 and cid = " . $uid)->count();
            foreach ($evaluate as &$ve) {
                $ve['addtime'] = date('Y年m月d日', $ve['addtime']);

                $tmpuser = M("userinfo")->where("isdel = 0 and id = " . $ve['uid'])->find();
                if ($tmpuser) {
                    $ve['name'] = $tmpuser['name'];
                    //$ve['headimg'] = $tmpuser['headimg'];
                    if (strstr($tmpuser['headimg'], 'http')) {
                        $ve['headimg'] = $tmpuser['headimg'];
                    } else {
                        $ve['headimg'] = C("IMAGE_URL") . $tmpuser['headimg'];
                    }
                }

                $tmpcourse = M("courselog")->find($ve['courselogid']);
                $ve['coursename'] = $tmpcourse['ctitle'];

                if ($ve['imgs']) {
                    $images = M("images")->where("isdel = 0 and id in(" . $ve['imgs'] . ")")->select();
                    $tmp = array();
                    foreach ($images as $vvv) {
                        $tmp[] = C("EVALUATE_IMAGE_URL") . $vvv['url'];
                    }
                    $ve['imgs'] = $tmp;
                }
                unset($ve['id']);
                unset($ve['uid']);
                unset($ve['cid']);
                unset($ve['isdel']);
                unset($ve['courselogid']);
            }
            $result['response'] = array(
                'code' => '100',
                'msg' => '操作成功',
                'data' => $evaluate,
                'count' => $count
            );
        }

        $json_result = json_encode($result);
        $this->writeRequestResult($json_result);
        echo($json_result);
    }

    //用户上课提醒
    public function reminduser()
    {
        $hour = date("H");
        $min = date("i");
        if ($min >= 30) {
            $hour = $hour + 0.5;
        }
        $map['orderdate'] = date("Y-m-d");
        $map['ordertime_s'] = array("eq", $hour + 2);
        $map['status'] = 1;
        $data = M("userschedule")->where($map)->order("id desc")->select();
        $model = M("userinfo");
        $flag = 1;
        foreach ($data as $v) {
            $userinfo = $model->find($v['uid']);
            if ($userinfo['openid']) {
                $courselog = M("courselog")->find($v['courselogid']);
                $course = M("course")->find($courselog['cid']);
                $coach = M("coach")->find($courselog['coid']);
                $sporthall = M("sporthall")->find($courselog['shid']);
                $map = array();
                $map['first']['value'] = '您预定的课程2个小时后就要上课了，请按时上课哦~';
                $map['keyword1']['value'] = $course['name'];
                $map['keyword2']['value'] = $coach["name"];
                $map['keyword3']['value'] = $sporthall['name'];
                $payurl = '';
                $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
                $body = $this->sendTmplMsg('1Kopurmam4-_6KFNu2SYLEUXzw3-XGRZkULAyx55rZI', $userinfo['openid'], $map, $payurl);
                $flag *= $this->getWechat()->sendTemplateMessage($body);
            }
        }
        Log::write("定时用户上课提醒：" . date("Y-m-d H:i:s") . "，结果：" . $flag);
    }

    //教练上课提醒
    public function remindcoach()
    {
        $hour = date("H", strtotime("+10 minute"));
        $min = date("i", strtotime("+10 minute"));
        if ($min >= 30) {
            $hour = $hour + 0.5;
        }
        $map['orderdate'] = date("Y-m-d");
        $map['ordertime_s'] = array("eq", $hour);
        $map['status'] = 1;
        $data = M("userschedule")->where($map)->order("id desc")->select();
        $modeluserinfo = M("userinfo");
        $modelcoach = M("coach");
        $flag = 1;
        foreach ($data as $v) {
            $coachinfo = $modelcoach->field("tbluserinfo.openid")->join("tbluserinfo on tbluserinfo.phone = tblcoach.phone")->where("tblcoach.id = " . $v['coachid'])->find();
            $userinfo = $modeluserinfo->find($v['uid']);
            if ($coachinfo['openid']) {
                $courselog = M("courselog")->find($v['courselogid']);
                $course = M("course")->find($courselog['cid']);
                $coach = M("coach")->find($courselog['coid']);
                $sporthall = M("sporthall")->find($courselog['shid']);
                $map = array();
                $map['first']['value'] = '学员【' . $userinfo['name'] . '】预定您的课程10分钟后就要上课了，请按时上课哦~';
                $map['keyword1']['value'] = $course['name'];
                $map['keyword2']['value'] = $coach["name"];
                $map['keyword3']['value'] = $sporthall['name'];
                $payurl = '';
                $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
                $body = $this->sendTmplMsg('1Kopurmam4-_6KFNu2SYLEUXzw3-XGRZkULAyx55rZI', $coachinfo['openid'], $map, $payurl);
                Log::write("定时教练上课提醒数据：" . json_encode($body));
                $flag *= $this->getWechat()->sendTemplateMessage($body);
            }
        }
        Log::write("定时教练上课提醒：" . date("Y-m-d H:i:s") . "，结果：" . $flag);
    }

    //约课通知
    public function test()
    {
        $courselog = M("courselog")->find(9);
        $course = M("course")->find($courselog['cid']);
        $coach = M("coach")->find($courselog['coid']);
        $sporthall = M("sporthall")->find($courselog['shid']);
        $map = array();
        $map['first']['value'] = '恭喜，预约成功';
        $map['keyword1']['value'] = $course['name'];
        $map['keyword2']['value'] = $sporthall['name'];
        $map['keyword3']['value'] = $coach["name"];
        $map['keyword4']['value'] = "2017-11-11 16:30";
        $payurl = '';
        $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
        $body = $this->sendTmplMsg('pmBfBkwEIQcE4duax54oFjZzMKVGQmpxzLumuQ3eeIw', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
        $this->getWechat()->sendTemplateMessage($body);
    }

    //上课提醒通知
    public function test2()
    {
        $courselog = M("courselog")->find(9);
        $course = M("course")->find($courselog['cid']);
        $coach = M("coach")->find($courselog['coid']);
        $sporthall = M("sporthall")->find($courselog['shid']);
        $map = array();
        $map['first']['value'] = '您预定的课程2个小时后就要上课了，请按时上课哦~';
        $map['keyword1']['value'] = $course['name'];
        $map['keyword3']['value'] = $coach["name"];
        $map['keyword2']['value'] = $sporthall['name'];
        $payurl = '';
        $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
        $body = $this->sendTmplMsg('1Kopurmam4-_6KFNu2SYLEUXzw3-XGRZkULAyx55rZI', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
        $this->getWechat()->sendTemplateMessage($body);
    }

    //取消通知用户
    public function test3()
    {
        $courselog = M("courselog")->find(9);
        $course = M("course")->find($courselog['cid']);
        $coach = M("coach")->find($courselog['coid']);
        $sporthall = M("sporthall")->find($courselog['shid']);
        $map = array();
        $map['first']['value'] = '您预约的私教课程已经取消';
        $map['keyword1']['value'] = "2017-11-11 16:30";
        $map['keyword2']['value'] = $coach["name"];
        $map['keyword3']['value'] = $course['name'];;
        $map['keyword4']['value'] = $sporthall['name'];
        $map['keyword5']['value'] = "时间临时变化，要求取消";
        $payurl = '';
        $map['remark']['value'] = '感谢您的使用，如有疑问请拨打4008-277-699。';
        $body = $this->sendTmplMsg('fGAz3gu_8Dtop1USskGyznQJH56sOMP8-ndVnc8nE-I', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
        $this->getWechat()->sendTemplateMessage($body);
    }

    //取消通知教练
    public function test4()
    {
        $courselog = M("courselog")->find(9);
        $course = M("course")->find($courselog['cid']);
        $coach = M("coach")->find($courselog['coid']);
        $sporthall = M("sporthall")->find($courselog['shid']);
        $map = array();
        $map['first']['value'] = $coach["name"] . '您好，有会员取消了预约的课程';
        $map['keyword1']['value'] = "李某某";
        $map['keyword2']['value'] = "18112345678";
        $map['keyword3']['value'] = $course['name'];;
        $map['keyword4']['value'] = "2017-11-11 16:30";
        $map['keyword5']['value'] = date("Y-m-d H:i:s");
        $payurl = '';
        $map['remark']['value'] = '请尽快联系会员以便安排下一次预约上课。';
        $body = $this->sendTmplMsg('5zOMrqhP7DPiIRZ2v-MN_CzdlvR2ieykgrB38VX-DtY', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
        $this->getWechat()->sendTemplateMessage($body);
    }

    //会员约课通知教练
    public function test5()
    {
        $courselog = M("courselog")->find(9);
        $course = M("course")->find($courselog['cid']);
        $coach = M("coach")->find($courselog['coid']);
        $sporthall = M("sporthall")->find($courselog['shid']);
        $map = array();
        $map['first']['value'] = $coach["name"] . '教练您好，有会员预约了您的课程';
        $map['keyword1']['value'] = $course['name'];;
        $map['keyword2']['value'] = 3;
        $map['keyword3']['value'] = $course['name'];;
        $map['keyword4']['value'] = date("Y-m-d H:i:s");
        $map['keyword5']['value'] = date("Y-m-d H:i:s", strtotime("+1 year"));
        $payurl = '';
        $map['remark']['value'] = '请为会员合理安排上课时间。';
        $body = $this->sendTmplMsg('nV6N_8ZNSiQZPf_mogmXKKHkAZ_kweoFxVINIECvTOI', "ov_lZ0fMvi8iuva6tv6SzoEUV0tE", $map, $payurl);
        $this->getWechat()->sendTemplateMessage($body);
    }

    function add_material()
    {
        $file_info = array('filename' => '/Public/Mobile/img/20171027213206.jpg', //国片相对于网站根目录的路径
            'content-type' => 'image/jpg', //文件类型
            'filelength' => '122' //图文大小
        );
        dump($file_info);
        $access_token = "RGbsPyvYQXXU1oMcNFizVLCuOcdZJDNnPV4QOaK6QrG2vAbJTZm9KTXVFgcDAWd_bh2u7zy_h7r02V8PBiz6BCiI9DIoLDx3dCMN59UwHccOKNdADAKGJ";//$this -> get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$access_token}&type=image";
        $ch1 = curl_init();
        $timeout = 5;
        $real_path = "{$_SERVER['DOCUMENT_ROOT']}{$file_info['filename']}";
        //$real_path=str_replace("/", "//", $real_path);
        $data = array("media" => "@{$real_path}", 'form-data' => $file_info);
        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch1);
        print_r($result);
        curl_close($ch1);
        if (curl_errno() == 0) {
            $result = json_decode($result, true);
            var_dump($result);
            return $result['media_id'];
        } else {
            return false;
        }
    }
}