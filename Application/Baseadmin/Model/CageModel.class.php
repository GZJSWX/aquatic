<?php
/**
 * Created by PhpStorm.
 * User: honor
 * Date: 2016/8/26
 * Time: 2:28
 */

namespace Baseadmin\Model;
use Think\Model;

class CageModel extends Model
{
    public function addCoordinate($coordinate){
        $userInfo = \Org\Util\User::_getUserInfo();
        $result = $this->where(array('pool_base_id'=>$userInfo['member_base_id'],'cage_rowname'=>$coordinate['typeName']))->setField('cage_coordinate',$coordinate['coordinate']);
        if($result){
            $data['coordinate'] = $coordinate['coordinate'];
            $data['type'] = 1;
            return $data;
        }
        return null;
    }
}