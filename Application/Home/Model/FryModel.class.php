<?php
namespace Home\Model;
use Think\Model;
class FryModel extends Model{

	  public function get() {

       $data = $this->select();
       
       return $data;
    }
}