<?php
namespace Home\Model;
use Think\Model;
class MedicineModel extends Model{

	  public function get() {

       $data = $this->select();
       
       return $data;
    }
}