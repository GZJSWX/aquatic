<?php 
namespace Superadmin\Model;
use Think\Model;
class MedicineModel extends Model{
	
	public function getMedicineInfo() {

		$data = $this->select();
		return $data;
	}
	public function addMedicine(){

    	if(IS_POST) {

           $params = I("post.");
           if(! $this->add($params)) {
              echo 'addMedicine 插入失败';
           }
    	}else {
    		echo 'addMedicine wrong';
    	}
    }
    public function getChooseMedicine(){

       if(IS_GET) {
           $params = I('get.val');
           $chooseMedicine = $this->where("medicine_id = $params")->find();
           return $chooseMedicine;
       }else {
         echo 'getChooseMedicine wrong';
       }
    }
    public function ModifyMedicine(){
        //用echo输出 可以在$.post()中的data中读到，可判断数据正确否
      if(IS_POST) { 
           $data = I('post.');
           $id = $data['medicine_id'];
           if(!($this->where("medicine_id = $id")->save($data))) {
               echo 'modifymedicineinfo_save wrong';
           }
      }else {
        echo 'wrong';
      }
    }
}