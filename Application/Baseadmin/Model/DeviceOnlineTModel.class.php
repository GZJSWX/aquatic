<?php
/**
 * Created by PhpStorm.
 * User: honor
 * Date: 2016/9/5
 * Time: 10:55
 */

namespace Baseadmin\Model;


use Think\Model;

class DeviceOnlineTModel extends Model
{
    public function getData(){
        //$userInfo = \Org\Util\User::_getUserInfo();
        $data = $this->select();
        return $data;
    }
}