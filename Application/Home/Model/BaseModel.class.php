<?php
namespace Home\Model;
use Think\Model;
class BaseModel extends Model{
    
	public function get() {
        
        date_default_timezone_set('prc');
        $time = date('Y-m-d H:i', time());
        $userInfo = \Org\Util\User::_getUserInfo();
        $base_id = $userInfo['member_base_id'];
        $result['data'] = $this->where("base_id = $base_id")->find();
        $result['time'] = $time;
		return $result;
	}
    public function ModifyBaseInfo(){

    	if(IS_POST) { 
           $this->result['data']=I('post.');
           $this->save($this->result['data']);
           
    	}else {
    		echo 'wrong';
    	}
    	
    }

}