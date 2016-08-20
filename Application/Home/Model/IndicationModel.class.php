<?php
namespace Home\Model;
use Think\Model;
class IndicationModel extends Model{
    public function get(){
        $data = $this->select();
        return $data;
    }
}
