<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Mobile\Controller;
use OT\DataDictionary;
use Think\Log;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends MobileController {

    public function parking(){
        $openid = $this->getOpenid();
        //$url = 'http://parking.iceinto.com/Mobile/WxOrderForm/caches/appid/wxee976956731c3004/fComeGoNo/wx/sourceopenid/'.$openid;
		$url = 'http://parking.iceinto.com/Mobile/WxOrderForm/pay/?appid=wxee976956731c3004&fComeGoNo=wx&t='.time().'&sourceopenid='.$openid;
        $this->assign("url", $url);
        $this->display();
    }

	//系统首页
    public function index(){
        $openid = $this->getOpenid();
        $weixinUser = D("weixinUser")->findByOpenid($openid);
        $this->assign("weixinUser",$weixinUser);//获取用户的经纬度

        //$datalist = D("gym")->getList();
        //$this->assign("datalist",$datalist);
        $this->assign("title",'选择体育馆场');
        $this->display();
    }

    //搜索体育馆
    public function searchGym(){
        $city = I("city");
        $gym  = I("gym");
        $list = D("gym")->searchGym($gym, $city);
        Log::write('搜索体育馆：'.json_encode($_REQUEST).'，SQL:'.M()->getLastSql().'，结果：'.json_encode($list));
        if(!empty($list)){
            $result['status'] = 1;
            $result['list']   = $list;
        }else{
            $result['status'] = 0;
        }
        echo(json_encode($result));
    }

    public function sportHall(){
        $gid = I("id");
        if(empty($gid)){
            $gid = 1;//默认体育场馆ID
        }
        if($gid){
            $datalist = D("sportHall")->getList($gid);
            $count    = count($datalist);
            $guestTicketModel = D("guestTicket");
            $placeModel = D("place");
            foreach($datalist as &$v){
                $ticketinfo   = $guestTicketModel->getList($v['id']);//判断当前场馆是否有散票
                $placeinfo    = $placeModel->getListByShid($v['id']);//判断当前场馆是否有场地预定
                if(!empty($ticketinfo)){
                    if(!empty($placeinfo)){
                        $v['ordertype'] = 1;//散票和预定全都有
                    }else{
                        $v['ordertype'] = 2;//只有散票
                    }
                }else{
                    if(!empty($placeinfo)){
                        $v['ordertype'] = 3;//只有预定
                    }else{
                        $v['ordertype'] = 0;//全无
                    }
                }
            }
        }else{
            $datalist = array();
        }

        if($count == 1){//判断如果只有一个场馆，则直接跳转到相应页面，不经过场馆选择页面
            $map['gid'] = $gid;
            $map['id']  = $datalist[0]['id'];
            if($datalist[0]['ordertype'] == 1){
                $this->redirect('Order/orderType',$map);
            }elseif($datalist[0]['ordertype'] == 2){
                $this->redirect('Ticket/index',$map);
            }elseif($datalist[0]['ordertype'] == 3){
                $this->redirect('Order/index',$map);
            }
        }

        $this->assign("gid",$gid);
        $this->assign("datalist",$datalist);
        $this->assign("title",'选择运动项目');
        $this->display();
    }

}