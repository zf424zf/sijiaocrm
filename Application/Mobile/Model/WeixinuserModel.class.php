<?php
namespace Mobile\Model;
use Think\Model;
use Think\Log;
/**
 * 微信用户信息
 * Class WeixinUserModel
 */
class WeixinUserModel extends Model
{
    /**
     * 根据openid 判断用户信息是否存在
     * @param $openid
     * @return array
     */
    public function findByOpenid($openid)
    {
        $map = array();
        $map['openid'] = $openid;
        return $this->where($map)->find();
    }


    /**
     * 获取头像
     * @param $openId
     * @return array
     */
    public function findHeadImgByOpenId($openId){
        $map = array();
        $map['openid'] = $openId;
        return $this->field("headimgurl")->where($map)->find();;
    }

    /**
     * 获取用户微信昵称
     * @param $openId
     * @return array
     */
    public function findNickNameByOpenId($openId){
        $map = array();
        $map['openid'] = $openId;
        $user = $this->field("nickname")->where($map)->find();;
        return $user['nickname'];
    }


    /**
     * 获取用户默认支付方式
     * @param $openId
     * @return array
     */
    public function findUserPayTypeByOpenId($openid){
        $map = array();
        $map['openid'] = $openid;
        return $$this->field("paytypeid")->where($map)->find();;
    }

    public function setUserDefaultPayType($openid,$paytypeid){
        $data = array();
        $data['paytypeid']   = $paytypeid;
        return $this->where("openid = '".$openid."'")->save($data);
    }

    /**
     * 添加和更新用户信息
     * @param $user
     */
    public function addOne($user)
    {
        $user['updatetime'] = time();
        $this->add($user, null, true);
    }

    /**
     * 添加和更新用户信息
     * @param $user
     */
    public function saveOne($user, $openid)
    {
        $weixinuser = $this->where("openid = '".$openid."'")->find();

        $user['updatetime'] = time();
        if($weixinuser){
            $this->save($user);
        }else{
            $this->add($user, null, true);
        }
    }
}