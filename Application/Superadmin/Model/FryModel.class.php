<?php 
namespace Superadmin\Model;
use Think\Model;
class FryModel extends Model{
	
	public function getFryInfo() {

		$data = $this->select();
		return $data;
	}
	public function addFry(){

    	if(IS_POST) {

           $params = I("post.");
           if(! $this->add($params)) {
              echo 'addFry 插入失败';
           }
    	}else {
    		echo 'addFry wrong';
    	}
  }
  public function getChooseFry(){

       if(IS_GET) {
           $params = I('get.val');
           $chooseFry = $this->where("fry_id = $params")->find();
           return $chooseFry;
       }else {
         echo 'getChooseFry wrong';
       }
    }
    public function ModifyFry(){
        //用echo输出 可以在$.post()中的data中读到，可判断数据正确否
      if(IS_POST) { 
           $data = I('post.');
           $id = $data['fry_id'];
           if(!($this->where("fry_id = $id")->save($data))) {
               echo 'modifyfryinfo_save wrong';
           }
      }else {
        echo 'wrong';
      }
    }
}