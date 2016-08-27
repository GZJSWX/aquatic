<?php
namespace Baseadmin\Model;
use Think\Model;
class BaseModel extends Model{
    public function getBaseInfo(){

        $userInfo = \Org\Util\User::_getUserInfo();

        $result = $this->where(array('base'=>$userInfo['members_base_id']))->find();

        if(!$result){
            return null;
        }
        return  $result;
    }
}