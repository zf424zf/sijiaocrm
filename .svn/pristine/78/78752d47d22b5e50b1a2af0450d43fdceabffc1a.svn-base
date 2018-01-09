<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

class ReportController extends AdminController {

//日报表
    function every() {
        if (IS_POST) {
            $shid = I('shid');
            $start = I('date_s');
            $end = I('date_e');
            $data = $this->getDatalist($start, $end, $shid);
            $this->ajaxReturn($data);
        }
        $default = date('Y-m-d', time());
        $day = date('d', time());
        //$deault = '2016-11-12';
        $res = $this->getDatalist($default, $default);
        //  print_r($res);die;
        $this->assign('default', $default);
        $this->assign('day', $day);
        $this->assign('res', $res);
        $sportHall = D('SportHall')->field('id,name')->select();
        $this->assign('sportHall', $sportHall);
        $this->meta_title = '日报表';
        $this->display();
    }

//日报表数据
    public function getDatalist($start, $end, $shid = 0) {
        $starttime = strtotime($start . '00:00:00');
        $endtime = strtotime($end . '23:59:59');
        $time = $endtime - $starttime;
        //中间相差的天数,需要循环的次数+1
        $days = intval($time / 86400);
        for ($i = 0; $i <= $days; $i++) {

            $time_s = $starttime + $i * 86400;
            $time_e = $time_s + (86400 - 1);
            // print_r(date('Y-m-d H:i:s',1478869323));die;
            $wei_s = $time_s - 3 * 60 * 60;
            $wei_e = $time_e - 3 * 60 * 60;

            $condition['_string'] = "(paytype <> '微信支付' and (paytime BETWEEN '$time_s' and '$time_e') ) OR (paytype ='微信支付' and (paytime BETWEEN '$wei_s' and '$wei_e') ) ";
            $condition['ispay'] = array(1, 3, 4, 5, 6, 'or');
            $condition['isdel'] = 0;
            $condition['paytype'] = array('neq', '场地优惠券');
            if ($shid != 0) {
                $condition['shid'] = $shid;
            }

            $order[$i] = D('Order')->field('realamount')->where($condition)->sum('realamount');
            // print_r(M()->getLastSql());die;
            $order[$i] = sprintf("%.2f", (isset($order[$i])) ? $order[$i] : 0);

            //散票预订
            $orderticket[$i] = D('OrderTicketList')->field('realamount')->where($condition)->sum('realamount');
            $orderticket[$i] = sprintf("%.2f", (isset($orderticket[$i])) ? $orderticket[$i] : 0);

            //开放收入=预订收入+散票收入
            $data['list'][$i]['open'] = sprintf("%.2f", $order[$i] + $orderticket[$i]);
            $data['sum']['open'][] = sprintf("%.2f", $order[$i] + $orderticket[$i]);

            $map1['_string'] = "(pay_type <> '微信支付' and (addtime BETWEEN '$time_s' and '$time_e') ) OR (pay_type ='微信支付' and (addtime BETWEEN '$wei_s' and '$wei_e') ) ";
            if ($shid != 0) {
                $map1['shid'] = $shid;
            }
            $profits[$i] = D('Profit')->field('sum(amount) as amount,type')->where($map1)->group('type')->select();
            //print_r(M()->getLastSql());die;
            if ($profits[$i] != null) {
                foreach ($profits[$i] as $k) {
                    if ($k['type'] == '固定') {
                        $data['list'][$i]['fix'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '租场') {
                        $data['list'][$i]['rent'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '活动') {
                        $data['list'][$i]['activity'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '租赁') {
                        $data['list'][$i]['rent2'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '广告') {
                        $data['list'][$i]['ads'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '赞助') {
                        $data['list'][$i]['support'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '其他收入') {
                        $data['list'][$i]['others'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '停车场') {
                        $data['list'][$i]['parks'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '小卖部') {
                        $data['list'][$i]['sells'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '损坏赔偿') {
                        $data['list'][$i]['pays'] = sprintf("%.2f", $k['amount']);
                    } else if ($k['type'] == '押金') {
                        $data['list'][$i]['deposit'] = sprintf("%.2f", $k['amount']);
                    }
                }
            }
            $data['list'][$i]['fix'] = sprintf("%.2f", (isset($data['list'][$i]['fix'])) ? $data['list'][$i]['fix'] : 0);
            $data['list'][$i]['rent'] = sprintf("%.2f", (isset($data['list'][$i]['rent'])) ? $data['list'][$i]['rent'] : 0);
            $data['list'][$i]['activity'] = sprintf("%.2f", (isset($data['list'][$i]['activity'])) ? $data['list'][$i]['activity'] : 0);
            $data['list'][$i]['rent2'] = sprintf("%.2f", (isset($data['list'][$i]['rent2'])) ? $data['list'][$i]['rent2'] : 0);
            $data['list'][$i]['ads'] = sprintf("%.2f", (isset($data['list'][$i]['ads'])) ? $data['list'][$i]['ads'] : 0);
            $data['list'][$i]['support'] = sprintf("%.2f", (isset($data['list'][$i]['support'])) ? $data['list'][$i]['support'] : 0);
            $data['list'][$i]['others'] = sprintf("%.2f", (isset($data['list'][$i]['others'])) ? $data['list'][$i]['others'] : 0);
            $data['list'][$i]['parks'] = sprintf("%.2f", (isset($data['list'][$i]['parks'])) ? $data['list'][$i]['parks'] : 0);
            $data['list'][$i]['sells'] = sprintf("%.2f", (isset($data['list'][$i]['sells'])) ? $data['list'][$i]['sells'] : 0);
            $data['list'][$i]['pays'] = sprintf("%.2f", (isset($data['list'][$i]['pays'])) ? $data['list'][$i]['pays'] : 0);
            $data['list'][$i]['deposit'] = sprintf("%.2f", (isset($data['list'][$i]['deposit'])) ? $data['list'][$i]['deposit'] : 0);


            $data['list'][$i]['sum'] = sprintf("%.2f", $data['list'][$i]['open'] + $data['list'][$i]['fix'] + $data['list'][$i]['rent'] +
                    $data['list'][$i]['activity'] + $data['list'][$i]['rent2'] + $data['list'][$i]['ads'] +
                    $data['list'][$i]['support'] + $data['list'][$i]['others'] + $data['list'][$i]['parks'] +
                    $data['list'][$i]['pays'] + $data['list'][$i]['sells'] + $data['list'][$i]['deposit']);

            //固定
            $data['sum']['fix'][] = sprintf("%.2f", $data['list'][$i]['fix']);
            //租场
            $data['sum']['rent'][] = sprintf("%.2f", $data['list'][$i]['rent']);
            //活动
            $data['sum']['activity'][] = sprintf("%.2f", $data['list'][$i]['activity']);

            //租赁

            $data['sum']['rent2'][] = sprintf("%.2f", $data['list'][$i]['rent2']);
            //广告
            $data['sum']['ads'][] = sprintf("%.2f", $data['list'][$i]['ads']);

            //赞助
            $data['sum']['support'][] = sprintf("%.2f", $data['list'][$i]['support']);

            //其他收入
            $data['sum']['others'][] = sprintf("%.2f", $data['list'][$i]['others']);

            //停车场
            $data['sum']['parks'][] = sprintf("%.2f", $data['list'][$i]['parks']);

            //小卖部
            $data['sum']['sells'][] = sprintf("%.2f", $data['list'][$i]['sells']);

            //赔偿损失
            $data['sum']['pays'][] = sprintf("%.2f", $data['list'][$i]['pays']);

            //押金
            $data['sum']['deposit'][] = sprintf("%.2f", $data['list'][$i]['deposit']);

            $data['sum']['countsum'][] = sprintf("%.2f", $data['list'][$i]['open'] + $data['list'][$i]['fix'] + $data['list'][$i]['rent'] +
                    $data['list'][$i]['activity'] + $data['list'][$i]['rent2'] + $data['list'][$i]['ads'] +
                    $data['list'][$i]['support'] + $data['list'][$i]['others'] + $data['list'][$i]['parks'] +
                    $data['list'][$i]['pays'] + $data['list'][$i]['sells'] + $data['list'][$i]['deposit']);
        }


        $data['sum']['open'] = sprintf("%.2f", array_sum($data['sum']['open']));
        $data['sum']['fix'] = sprintf("%.2f", array_sum($data['sum']['fix']));
        $data['sum']['rent'] = sprintf("%.2f", array_sum($data['sum']['rent']));
        $data['sum']['activity'] = sprintf("%.2f", array_sum($data['sum']['activity']));

        $data['sum']['rent2'] = sprintf("%.2f", array_sum($data['sum']['rent2']));
        $data['sum']['ads'] = sprintf("%.2f", array_sum($data['sum']['ads']));
        $data['sum']['support'] = sprintf("%.2f", array_sum($data['sum']['support']));
        $data['sum']['others'] = sprintf("%.2f", array_sum($data['sum']['others']));

        $data['sum']['parks'] = sprintf("%.2f", array_sum($data['sum']['parks']));
        $data['sum']['sells'] = sprintf("%.2f", array_sum($data['sum']['sells']));
        $data['sum']['pays'] = sprintf("%.2f", array_sum($data['sum']['pays']));
        $data['sum']['deposit'] = sprintf("%.2f", array_sum($data['sum']['deposit']));

        $data['sum']['countsum'] = sprintf("%.2f", array_sum($data['sum']['countsum']));

        return $data;
    }

//订单流水
    function ticketReport() {
        if (IS_POST) {
            $date_s = I('date_s');
            $date_e = I('date_e');
            $res = $this->everyReport($date_s, $date_e);
            $swres = $this->sweveryReport($date_s, $date_e);
            $res = $this->ticketArray($res,$swres);
            $this->ajaxReturn($res,'json');
        }
        $default = date('Y-m-d', time());
        $res = $this->everyReport($default, $default);
        $swres = $this->sweveryReport($default, $default);
        $res = $this->ticketArray($res,$swres);
        $this->assign('res', $res);
        $this->assign('default', $default);
        //print_r($res);die;

        $this->meta_title = '培训报表';
        $this->display();
    }
    function cwReport($start,$end) {
        if (IS_POST) {
            $date_s = I('date_s');
            $date_e = I('date_e');
            $res = $this->everyReport($date_s, $date_e);
            $swres = $this->sweveryReport($date_s, $date_e);
            $res = $this->ticketArray($res,$swres);
            return $res;
        }
        $res = $this->everyReport($start, $end);
        $swres = $this->sweveryReport($start, $end);
        $res = $this->ticketArray($res,$swres);
        return $res;
    }
    //学生报名总课程统计报表
    function countReport($start,$end) {
        $start=  strtotime($start);
        $end = strtotime($end);
        $sid_sql = "SELECT
                    COUNT(train_order.id) as num
                    FROM
                    train_order
                    INNER JOIN train_student ON train_order.uid = train_student.id
                    INNER JOIN train_schedule ON train_schedule.id = train_order.sid
                    WHERE
                    train_schedule.isdel = 0 AND
                    train_order.isdel = 0 AND
                    train_order.`status` = 1 AND
                    train_student.isdel = 0 AND train_order.addtime between '$start' AND '$end'
                    ORDER BY
                    train_schedule.id ASC";
        $Model = M();
        $sid_res = $Model->query($sid_sql);
        return $sid_res[0]['num'];
    }
    //学生报名课程统计报表
    function studentReport($id,$start,$end) {
        $start=  strtotime($start);
        $end = strtotime($end);
        $Model = M();
        $sql = "SELECT
                    train_schedule.id,
                    train_schedule.title,
                    train_schedule.hour_s,
                    train_schedule.weekinfo,
                    train_student.`name`,
                    train_student.sex,
                    train_student.idcard,
                    train_student.birthinfo,
                    train_student.phone,
                    train_schedule.classtype,
                    train_schedule.hour_e,
                    train_order.uid,
                    train_schedule.startdate,
                    train_order.addtime
                    FROM
                    train_order
                    INNER JOIN train_student ON train_order.uid = train_student.id
                    INNER JOIN train_schedule ON train_schedule.id = train_order.sid
                    WHERE
                    train_schedule.isdel = 0 AND
                    train_order.isdel = 0 AND
                    train_order.`status` = 1 AND
                    train_student.isdel = 0 AND train_schedule.id =$id AND train_order.addtime between '$start' AND '$end'
                    ORDER BY
                    train_schedule.id ASC";
        $res = $Model->query($sql);
        int_to_string($res);
        foreach ($res as &$v) {
            if($v['sex'] == 0 ){
                $v['sex'] ="男";
            }else{
                $v['sex'] ="女";
            }
        }
        return $res;
    }

    //学生报名课程统计报表
    function schReport($start,$end) {
        $start=  strtotime($start);
        $end = strtotime($end);
        $sid_sql = "SELECT
                    train_schedule.id
                    FROM
                    train_order
                    INNER JOIN train_student ON train_order.uid = train_student.id
                    INNER JOIN train_schedule ON train_schedule.id = train_order.sid
                    WHERE
                    train_schedule.isdel = 0 AND
                    train_order.isdel = 0 AND
                    train_order.`status` = 1 AND
                    train_student.isdel = 0 AND train_order.addtime between '$start' AND '$end'
                    GROUP BY train_schedule.id
                    ORDER BY
                    train_schedule.id ASC";
        $Model = M();
        $sid_res = $Model->query($sid_sql);
        $ids = array_column($sid_res, 'id');
        return $ids;
    }
    function ticketArray($res,$swres) {
        $ticket = array();
        $order = array();
        foreach ($res['list2'] as $k => $v) {
                $order[$k]['count'] = $res['list2'][$k]['count'];
                $order[$k]['amount'] = sprintf("%.2f", $res['list2'][$k]['amount']);
                $order[$k]['realamount'] = sprintf("%.2f", $res['list2'][$k]['realamount']);
                $order[$k]['title'] = $res['list2'][$k]['title'];
                $order[$k]['ysamount'] = sprintf("%.2f", $res['list2'][$k]['ysamount']);
                $order[$k]['reduceamount'] = sprintf("%.2f", $res['list2'][$k]['reduceamount']);
                $order[$k]['xianjin'] = $res['list2'][$k]['xianjin'];
                $order[$k]['imbalance'] = $res['list2'][$k]['imbalance'];
                $order[$k]['weixin'] = $res['list2'][$k]['weixin'];
                $order[$k]['refundmoney'] =sprintf("%.2f", $res['list2'][$k]['refundmoney']);
                $order[$k]['yangguang'] = $res['list2'][$k]['yangguang'];
                $order[$k]['gongshang'] = $res['list2'][$k]['gongshang'];
                $order[$k]['sid'] = $res['list2'][$k]['sid'];
                unset($res['list2'][$k]);
        }
        $orders = array_merge($res['list2'], $order);
        $orders = $this->array_sort($orders);
        foreach ($swres['list'] as $k => $v) {
            $ticket[$k]['count'] = $swres['list'][$k]['count'];
            $ticket[$k]['amount'] = sprintf("%.2f", $swres['list'][$k]['amount']);
            $ticket[$k]['realamount'] = sprintf("%.2f", $swres['list'][$k]['realamount']);
            $ticket[$k]['title'] = $swres['list'][$k]['title'];
            $ticket[$k]['ysamount'] = sprintf("%.2f", $swres['list'][$k]['ysamount']);
            $ticket[$k]['reduceamount'] = sprintf("%.2f", $swres['list'][$k]['reduceamount']);
            $ticket[$k]['xianjin'] = $swres['list'][$k]['xianjin'];
            $ticket[$k]['imbalance'] = $swres['list'][$k]['imbalance'];
            $ticket[$k]['weixin'] = $swres['list'][$k]['weixin'];
            $ticket[$k]['refundmoney'] =sprintf("%.2f", $swres['list'][$k]['refundmoney']);
            $ticket[$k]['yangguang'] = $swres['list'][$k]['yangguang'];
            $ticket[$k]['gongshang'] = $swres['list'][$k]['gongshang'];
            $ticket[$k]['sid'] = $swres['list'][$k]['sid'];
            unset($swres['list'][$k]);
        }
        $orderTickets = array_merge($swres['list'], $ticket);
        $orderTickets = $this->array_sort($orderTickets);
        $res['list'] = $orderTickets;
        $res['list2'] = $orders;
        $res['allsum'] = $this->twoArraySum($orders,$orderTickets);
        return $res;
    }
    //室内 订单流水
    function everyReport($date_s, $date_e) {
        $starttime = strtotime($date_s . '00:00:00');
        $endtime = strtotime($date_e . '23:59:59');
        //课程
        $smap['isdel'] =0;
        $smap['weekinfo'] =array('neq','周一至周六');
        $smap['isdel'] =0;
        $sportHall = D('Schedule')->field('id,amount,title,amount_follow')->where($smap)->order('id asc')->select();
//             print_r($guestTicket);die;
        if ($sportHall != null) {
            //培训报名
            $where['paytime'] = array('between', "$starttime,$endtime");
            $where['refundtime'] = array('between',"$starttime,$endtime");
            $where['_logic'] = 'OR';
            $condition2['status'] =  array(array('eq',1),array('eq',3), 'or');
            $condition2['_complex'] = $where;
            $condition2['isdel'] = 0;
            $condition2['status'] =  array(array('eq',1),array('eq',3), 'or');
            //print_r($sportHall);die;
            foreach ($sportHall as $i => $k) {
                $condition2['sid'] = $k['id'];
                //课程订单
                //实收等总额paytime为准 退款除外
                $condition3['status'] =  array(array('eq',1),array('eq',3), 'or');
                $condition3['paytime'] = array('between', "$starttime,$endtime");
                $condition3['isdel'] = 0;
                $condition3['sid'] = $k['id'];
                $orderA[$i] = D('Order')->field('sum(realamount) as realamount,paytype,sum(imbalance) as imbalance')->where($condition3)->group('paytype')->select();
                if ($orderA[$i] != null) {
                    foreach ($orderA[$i] as $vv) {
                        if ($vv['paytype'] == '1') { //微信支付
                            $orderM[$i]['weixin'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '2') { //现金
                            $orderM[$i]['xianjin'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '3') {//阳光卡
                            $orderM[$i]['yangguang'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '4') {//工商银行
                            $orderM[$i]['gongshang'] = $vv['realamount'];
                        }
                        $rmap['isdel']=0;
                        $rmap['code']= $vv['reducecode'];
                        $reducecode = D('Reduce')->field('id,reduce')->where($rmap)->select();
                        $orderM[$i]['reduce']=$reducecode['reduce'];
                        $orderM[$i]['imbalance']=$vv['imbalance'];
                    }
                }
                $res['list2'][$i]['sid'] = $k['id'];
                $ordercount[$i] = D('Order')->field('sum(realamount) as realamount,sum(refundmoney) as refundmoney,sum(reduceamount) as reduceamount,sum(amount) as amount')->where($condition2)->select();
                $orderB[$i] = D('Order')->field('sum(realamount) as realamount,sum(refundmoney) as refundmoney,sum(reduceamount) as reduceamount,sum(amount) as amount')->where($condition3)->select();


                //课程名称
                $res['list2'][$i]['title'] = $k['title'];
                $smap['id'] =$k['id'];
                //单价
                $priceConfig[$i] = D('Schedule')->field('amount')->where($smap)->select();
                $price[$i] = json_decode($priceConfig[$i][0]['amount'], true);

                $res['list2'][$i]['amount'] = sprintf("%.2f", $price[$i]);
                //数量	
                $res['list2'][$i]['count'] = D('Order')->where($condition2)->count();
                //应收		
                $res['list2'][$i]['ysamount'] = sprintf("%.2f", isset($orderB[$i]) ? $orderB[$i][0]['amount'] : 0);
                //优惠		
                $res['list2'][$i]['reduceamount'] = sprintf("%.2f", isset($orderB[$i]) ? $orderB[$i][0]['reduceamount'] : 0);
                //实收
                $res['list2'][$i]['realamount'] = sprintf("%.2f", isset($orderB[$i]) ? $orderB[$i][0]['realamount'] : 0);
                //现金
                $res['list2'][$i]['xianjin'] = sprintf("%.2f", isset($orderM[$i]['xianjin']) ? $orderM[$i]['xianjin'] : 0);
                //微信支付
                $res['list2'][$i]['weixin'] = sprintf("%.2f", isset($orderM[$i]['weixin']) ? $orderM[$i]['weixin'] : 0);
                //微信退款
                $res['list2'][$i]['refundmoney'] = sprintf("%.2f", isset($ordercount[$i]) ?  $ordercount[$i][0]['refundmoney'] : 0);
                //阳光卡
                $res['list2'][$i]['yangguang'] = sprintf("%.2f", isset($orderM[$i]['yangguang']) ? $orderM[$i]['yangguang'] : 0);
                //工商银行
                $res['list2'][$i]['gongshang'] = sprintf("%.2f", isset($orderM[$i]['gongshang']) ? $orderM[$i]['gongshang'] : 0);
                //差价
                $res['list2'][$i]['imbalance'] = sprintf("%.2f", isset($orderM[$i]['imbalance']) ? $orderM[$i]['imbalance'] : 0);

            }
            foreach ($res['list2'] as $h => $g) {
                if ($g['count'] == 0) {
                    unset($res['list2'][$h]);
                }
            }
            return $res;
        }
    }

    //室外 订单流水
    function sweveryReport($date_s, $date_e) {
        $starttime = strtotime($date_s . '00:00:00');
        $endtime = strtotime($date_e . '23:59:59');
        //课程
        $smap['isdel'] =0;
        $smap['weekinfo'] =array('eq','周一至周六');
        $sportHall = D('Schedule')->field('id,amount,title,amount_follow')->where($smap)->order('id asc')->select();
//             print_r($guestTicket);die;
        if ($sportHall != null) {
            //课程报名
            $where['paytime'] = array('between', "$starttime,$endtime");
            $where['refundtime'] = array('between',"$starttime,$endtime");
            $where['_logic'] = 'OR';
            $condition2['_complex'] = $where;
            $condition2['status'] =  array(array('eq',1),array('eq',3), 'or');
            $condition2['isdel'] = 0;
            //print_r($sportHall);die;
            foreach ($sportHall as $i => $k) {
                $condition2['sid'] = $k['id'];
                //课程订单
                //实收等总额paytime为准 退款除外
                $condition3['status'] =  array(array('eq',1),array('eq',3), 'or');
                $condition3['paytime'] = array('between', "$starttime,$endtime");
                $condition3['isdel'] = 0;
                $condition3['sid'] = $k['id'];
                $orderA[$i] = D('Order')->field('sum(realamount) as realamount,paytype,sum(imbalance) as imbalance')->where($condition3)->group('paytype')->select();
                if ($orderA[$i] != null) {
                    foreach ($orderA[$i] as $vv) {
                        if ($vv['paytype'] == '1') { //微信支付
                            $orderM[$i]['weixin'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '2') { //现金
                            $orderM[$i]['xianjin'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '3') {//阳光卡
                            $orderM[$i]['yangguang'] = $vv['realamount'];
                        } else if ($vv['paytype'] == '4') {//工商银行
                            $orderM[$i]['gongshang'] = $vv['realamount'];
                        }
                        $rmap['isdel']=0;
                        $rmap['code']= $vv['reducecode'];
                        $reducecode = D('Reduce')->field('id,reduce')->where($rmap)->select();
                        $orderM[$i]['reduce']=$reducecode['reduce'];
                        $orderM[$i]['imbalance']=$vv['imbalance'];
                    }
                }
                $res['list'][$i]['sid'] = $k['id'];
                $ordercount[$i] = D('Order')->field('sum(realamount) as realamount,sum(refundmoney) as refundmoney,sum(reduceamount) as reduceamount,sum(amount) as amount')->where($condition2)->select();
                 $orderB[$i] = D('Order')->field('sum(realamount) as realamount,sum(refundmoney) as refundmoney,sum(reduceamount) as reduceamount,sum(amount) as amount')->where($condition3)->select();
                //课程名称
                $res['list'][$i]['title'] = $k['title'];
                $smap['id'] =$k['id'];
                //单价
                $priceConfig[$i] = D('Schedule')->field('amount')->where($smap)->select();
                $price[$i] = json_decode($priceConfig[$i][0]['amount'], true);

                $res['list'][$i]['amount'] = sprintf("%.2f", $price[$i]);
                //数量
                $res['list'][$i]['count'] = D('Order')->where($condition3)->count();
                //应收
                $res['list'][$i]['ysamount'] = sprintf("%.2f", isset($orderB[$i]) ? $orderB[$i][0]['amount'] : 0);
                //优惠
                $res['list'][$i]['reduceamount'] = sprintf("%.2f", isset($orderB[$i]) ? $orderB[$i][0]['reduceamount'] : 0);
                //实收
                $res['list'][$i]['realamount'] = sprintf("%.2f", isset( $orderB[$i]) ? $orderB[$i][0]['realamount'] : 0);
                //现金
                $res['list'][$i]['xianjin'] = sprintf("%.2f", isset($orderM[$i]['xianjin']) ? $orderM[$i]['xianjin'] : 0);
                //微信支付
                $res['list'][$i]['weixin'] = sprintf("%.2f", isset($orderM[$i]['weixin']) ? $orderM[$i]['weixin'] : 0);
                 //微信退款
                $res['list'][$i]['refundmoney'] =sprintf("%.2f", isset($ordercount[$i]) ? $ordercount[$i][0]['refundmoney'] : 0);
                //阳光卡
                $res['list'][$i]['yangguang'] = sprintf("%.2f", isset($orderM[$i]['yangguang']) ? $orderM[$i]['yangguang'] : 0);
                //工商银行
                $res['list'][$i]['gongshang'] = sprintf("%.2f", isset($orderM[$i]['gongshang']) ? $orderM[$i]['gongshang'] : 0);
                //差价
                $res['list'][$i]['imbalance'] = sprintf("%.2f", isset($orderM[$i]['imbalance']) ? $orderM[$i]['imbalance'] : 0);

            }
            foreach ($res['list'] as $h => $g) {
                if ($g['count'] == 0) {
                    unset($res['list'][$h]);
                }
            }
            return $res;
        }
    }

    //两个数组各项分别求和
    function twoArraySum($orders,$orderTickets) {
        foreach ($orders as $i) {
            $res['sum2']['count'][] = $i['count'];
            $res['sum2']['amount'][] = $i['amount'];
            $res['sum2']['reduceamount'][] = $i['reduceamount'];
            $res['sum2']['realamount'][] = $i['realamount'];
            $res['sum2']['xianjin'][] = $i['xianjin'];
            $res['sum2']['imbalance'][] = $i['imbalance'];
            $res['sum2']['weixin'][] =  $i['weixin'];
            $res['sum2']['refundmoney'][] =  $i['refundmoney'];
            $res['sum2']['yangguang'][] = $i['yangguang'];
            $res['sum2']['gongshang'][] = $i['gongshang'];
            $res['sum2']['ysamount'][] =$i['ysamount'];
        }
        foreach ($orderTickets as $i) {
            $res['sum']['count'][] = $i['count'];
            $res['sum']['amount'][] = $i['amount'];
            $res['sum']['reduceamount'][] = $i['reduceamount'];
            $res['sum']['realamount'][] = $i['realamount'];
            $res['sum']['xianjin'][] = $i['xianjin'];
            $res['sum']['imbalance'][] = $i['imbalance'];
            $res['sum']['weixin'][] =  $i['weixin'];
            $res['sum']['refundmoney'][] =  $i['refundmoney'];
            $res['sum']['yangguang'][] = $i['yangguang'];
            $res['sum']['gongshang'][] = $i['gongshang'];
            $res['sum']['ysamount'][] =$i['ysamount'];
        }
        //总数量
        $res['allsum']['count'] = (array_sum($res['sum2']['count'])+array_sum($res['sum']['count']))?(array_sum($res['sum2']['count'])+array_sum($res['sum']['count'])):0;
        //总价格
        $res['allsum']['amount'] = sprintf("%.2f", array_sum($res['sum2']['amount'])+array_sum($res['sum']['amount']));
        //总应收
        $res['allsum']['ysamount'] = sprintf("%.2f", array_sum($res['sum2']['ysamount'])+array_sum($res['sum']['ysamount']));
        //总优惠
        $res['allsum']['reduceamount'] = sprintf("%.2f", array_sum($res['sum2']['reduceamount'])+ array_sum($res['sum']['reduceamount']));
        //总微信退款
        $res['allsum']['refundmoney'] = sprintf("%.2f", array_sum($res['sum2']['refundmoney'])+ array_sum($res['sum']['refundmoney']));
        //总实收
        $res['allsum']['realamount'] = sprintf("%.2f", $res['allsum']['ysamount'] - $res['allsum']['reduceamount']-$res['allsum']['refundmoney']);
        //总微信
        $res['allsum']['weixin'] = sprintf("%.2f", array_sum($res['sum2']['weixin'])+ array_sum($res['sum']['weixin']));
        //总现金
        $res['allsum']['xianjin'] = sprintf("%.2f", array_sum($res['sum2']['xianjin'])+ array_sum($res['sum']['xianjin']));
        //总阳光卡
        $res['allsum']['yangguang'] = sprintf("%.2f", array_sum($res['sum2']['yangguang'])+ array_sum($res['sum']['yangguang']));
        //总工商银行
        $res['allsum']['gongshang'] = sprintf("%.2f", array_sum($res['sum2']['gongshang'])+ array_sum($res['sum']['gongshang']));
        //总苏州专用
        $res['allsum']['imbalance'] = sprintf("%.2f", array_sum($res['sum2']['imbalance'])+ array_sum($res['sum']['imbalance']));
        return $res['allsum'];
    }

    //二维数组排序
    function array_sort($arr) {
        $newarr = array();
        foreach ($arr as $v) {
            $newarr[] = $v['shid'];
        }
        array_multisort($newarr, SORT_ASC, $arr);
        return $arr;
    }


    //单日统计表1号到当天
    function monthSales($newstart, $start) {
        $time_s = strtotime($newstart . '00:00:00');
        $time_e = strtotime($start . '23:59:59');
        $wei_s = $time_s - 3 * 60 * 60;
        $wei_e = $time_e - 3 * 60 * 60;
        $condition['_string'] = "(paytype <> '微信支付' and (paytime BETWEEN '$time_s' and '$time_e') ) OR (paytype ='微信支付' and (paytime BETWEEN '$wei_s' and '$wei_e') ) ";
        $condition['ispay'] = array(1, 3, 4, 5, 6, 'or');
        $condition['isdel'] = 0;
        $condition['paytype'] = array('neq', '场地优惠券');

        $order = D('Order')->field('realamount')->where($condition)->sum('realamount');
        $order = sprintf("%.2f", (isset($order)) ? $order : 0);


        //散票预订
        $orderticket = D('OrderTicketList')->field('realamount')->where($condition)->sum('realamount');
        $orderticket = sprintf("%.2f", (isset($orderticket)) ? $orderticket : 0);


        $map1['_string'] = "(pay_type <> '微信支付' and (addtime BETWEEN '$time_s' and '$time_e') ) OR (pay_type ='微信支付' and (addtime BETWEEN '$wei_s' and '$wei_e') ) ";
        $profits = D('Profit')->field('amount')->where($map1)->sum('amount');
        $profits = sprintf("%.2f", (isset($profits)) ? $profits : 0);


        $data = sprintf("%.2f", $order + $orderticket + $profits);
        // print_r($data);die;
        return $data;
    }

   

}
