<?php
namespace Home\Model;
use Think\Model;
class CageModel extends Model{

	public function get(){

		// $userInfo = \Org\Util\User::_getUserInfo();
		// $pool_id = $userInfo['member_pool_id'];
		// $data = $this->where("cage_pool_id = $pool_id")->select();
    $data = $this->select();
    return $data;
	}
  public function transfer(){
      
        $pool_id = I('get.val');  
        return $this->where(array('cage_pool_id' => $pool_id))->select();
   
  }
	public function adds() {

    	if(IS_POST) {

           $userInfo = \Org\Util\User::_getUserInfo();
           $params = I("post.");
           $params['cage_pool_id'] = $userInfo['member_pool_id'];
           if(! $this->add($params)) {
              return 0;
           }
            return 1;
      }else {
            echo 'error';
            return;
      }
	}
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $chooseCage = $this->where("cage_id = $params")->find();
           return $chooseCage;
       }else {
         echo 'getChoosePool wrong';
       }
    }
     public function modify(){
        //用echo输出 可以在$.post()中的data中读到，可判断数据正确否
    	if(IS_POST) { 
           $data = I('post.');

           $id = $data['cage_id'];

           if(!($this->where("cage_id = $id")->save($data))) {
               echo 'modifyCageinfo_save wrong';
           }
    	}else {
    		echo 'modifyCageInfowrong';
    	}
    	
    }

}