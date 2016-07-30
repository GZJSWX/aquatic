<?php
namespace Baseadmin\Model;
use Think\Model;
class PoolModel extends Model{

	public function getPoolInfo(){

    date_default_timezone_set('prc');
    $time = date('Y-m-d H:i', time());
    $userInfo = \Org\Util\User::_getUserInfo();
    $member_base_id = $userInfo['member_base_id'];
		$data = $this->where("pool_base_id = $member_base_id")->select();
    foreach ($data as $key => $value) {
        $data[$key]['pool_base_id'] = M('base')->getFieldByBase_id($value['pool_base_id'],'base_name');
    }
    $result['data'] = $data;
		$result['time'] = $time;
		return $result;
	}

    public function getPoolId(){
        $userInfo = \Org\Util\User::_getUserInfo();
        $member_base_id = $userInfo['member_base_id'];
        $data = $this->where("pool_base_id= $member_base_id")->field("pool_id")->select();
        return $data;
    }
    
    public function addPool(){

    	if(IS_POST) {

           date_default_timezone_set('prc');
           $time = date('Y-m-d H:i', time());
           $userInfo = \Org\Util\User::_getUserInfo();
           $params = I("post.");
           $params['pool_base_id'] = $userInfo['member_base_id'];
           $params['pool_time'] = $time;
           if(! $this->add($params)) {
              echo 'addPool 插入失败';
           }

    	}else {
    		echo 'addPool wrong';
    	}
    }
}