<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;

use Think\Model;
use Think\Log;

/**
 * s订单模型
 */
class OrderModel extends Model {

    function addOrder($number, $uid, $sid, $cid, $amount, $type, $mark = ''){
        $student['number']  = $number;
        $student['uid']     = $uid;
        $student['sid']     = $sid;
        $student['cid']     = $cid;
        $student['amount']  = $amount;
        $student['type']    = $type;
        $student['addtime'] = time();
        $student['isdel']   = 0;
        $student['mark']    = $mark;
        $id                 = $this->add($student);
        Log::write('新增订单，结果：' . $id . ',' . $this->getLastSql());
        return $id;
    }
}
