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
class OrderModel extends Model {

    function addOrder($number, $uid, $sid, $cid, $amount, $type, $mark = ''){
        $student['number']  = $number;
        $student['uid']     = $uid;
        $student['sid']     = $sid;
        $student['cid']     = $cid;
        $student['amount']  = $amount;
        $student['realamount']  = $amount;
        $student['type']    = $type;
        $student['addtime'] = time();
        $student['isdel']   = 0;
        $student['mark']    = $mark;
        $id                 = $this->add($student);
        Log::write('新增订单，结果：' . $id . ',' . $this->getLastSql());
        return $id;
    }

    function checkFollow($uid){
        $map            = array();
        $map['isdel']   = 0;
        $map['status']  = 1;
        $map['uid']     = $uid;
        $tmporder       = $this->where($map)->find();
        return $tmporder;
    }

    function findByNumber($number){
        $map['isdel'] = 0;
        $map['number']= $number;
        $result = $this->where($map)->find();
        return $result;
    }

    function updateReduceOn($number, $reduce, $reducecode){
        $order = $this->findByNumber($number);
        $data['id'] = $order['id'];
        $data['reduceamount'] = $reduce;
        $data['reducecode']   = $reducecode;
        $data['realamount']   = $order['amount'] - $reduce;
        $result = $this->save($data);
        Log::write('更新订单优惠信息（新增优惠），结果：' . $result . ',' . $this->getLastSql());
        return $result;
    }

    function updateReduceOff($number){
        $order = $this->findByNumber($number);
        $data['id'] = $order['id'];
        $data['reduceamount'] = 0;
        $data['reducecode']   = '';
        $data['realamount']   = $order['amount'];
        $result = $this->save($data);
        Log::write('更新订单优惠信息（取消优惠），结果：' . $result . ',' . $this->getLastSql());
        return $result;
    }

    function updatePayStatus($id,$paytype){
        $data['status']  = 1;
        $data['paytime'] = time();
        $data['paytype'] = $paytype;
        $result = $this->where("id = " . $id)->save($data);
        return $result;
    }

    function getOrderByNumber($number){
        $map['isdel']   = 0;
        $map['status']  = 1;
        $map['paytime'] = array('gt', 0);
        $map['number']  = $number;
        return $this->where($map)->find();
    }
}
