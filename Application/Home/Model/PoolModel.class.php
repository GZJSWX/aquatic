<?php
namespace Home\Model;
use Think\Model;
class PoolModel extends Model{

  	public function get(){
         
         // $userInfo = \Org\Util\User::_getUserInfo();
         // $pool_id = $userInfo['member_pool_id'];
         $data = $this->select();
         //$data['pool_base_id'] = D('base')->getFieldByBase_id($data['pool_base_id'],'base_name');
         return $data;
  	}
    public function getAll(){

       return $this->select();
    }
    public function modify(){
        
    	if(IS_POST) { 
           $data = I('post.');
           $id = $data['pool_id'];
           if(!($this->where("pool_id = $id")->save($data))) {
               echo 'modifyPoolinfo_save wrong';
           }
    	}else {
    		echo 'modifyPoolInfowrong';
    	}
    	
    }
    public function getChoose(){

           if(IS_GET) {
               $params = I('get.val');
               $choosePool = $this->where("Pool_id = $params")->find();
               return $choosePool;
           }else {
             echo 'getChoosePool wrong';
           }
    }
}