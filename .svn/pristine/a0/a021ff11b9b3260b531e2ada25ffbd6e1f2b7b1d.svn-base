<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Mobile\Model;

use Think\Model;
use Think\Log;

/**
 * s订单模型
 */
class StudentModel extends Model {

    function addStudent($number, $cardnum, $name, $sex, $birthinfo, $phone, $openid = '', $nickname = '', $headimg = '', $mark = ''){
        $student['number']      = $number;
        $student['cardnum']     = $cardnum;
        $student['name']        = $name;
        $student['sex']         = $sex;
        $student['birthinfo']   = $birthinfo;
        $age                    = strtotime(date('Y-m')) - strtotime(date($birthinfo));
        $age                    = $age / ( 365 * 24 * 60 * 60);
        $student['age']         = round($age, 1);
        $student['phone']       = $phone;
        $student['openid']      = $openid;
        $student['nickname']    = '';//$nickname;
        $student['headimg']     = '';//$headimg;
        $student['mark']        = $mark;
        $student['addtime']     = time();
        $student['isdel']       = 0;
        $id                     = $this->add($student);
        Log::write('新增学生，结果：' . $id . ',' . $this->getLastSql());
        return $id;
    }
}
