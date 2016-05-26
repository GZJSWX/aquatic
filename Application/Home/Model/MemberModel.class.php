<?php
namespace Home\Model;
use Think\Model;
// 后面加自动验证自动完成
class MemberModel extends Model {
    
    public function showMe(){
         
         $userInfo = \Org\Util\User::_getUserInfo();
         $id = $userInfo['member_id'];
         $data = $this->where(array('member_id' => $id))->find();
         $data['member_base_id'] = M('base')->getFieldbyBase_id($data['member_base_id'],'base_name');
         $data['member_pool_id'] = M('pool')->getFieldbypool_id($data['member_pool_id'],'pool_name');
         switch ($data['member_role']) {
             case '1':
                 $data['member_role'] = '系统管理员';
                 break;
             case '2':
                 $data['member_role'] = '基础管理员';
                 break;
             case '3':
                 $data['member_role'] = '普通用户';
             break;
             default:
                 $data['member_role'] = "错误,请联系管理员";
                 break;
         }
         return $data;
    }
    public function login() {
         
         if(IS_GET) {
             
             $username = I("get.member_username");
             $password = I("get.member_password");
             $role = I('get.member_role');
             if($data = $this->where(array('member_role' => $role, 'member_username' => $username, 'member_password' => $password))->find()) {
                
                $result['status'] = 1;
                $userInfo['member_username'] = $username;
                $userInfo['member_password'] = $password;
                $userInfo['member_id'] = $data['member_id'];
                $userInfo['member_base_id'] = $data['member_base_id'];
                // $userInfo['member_pool_id'] = $data['member_pool_id'];
                \Org\Util\User::_setUserInfo($userInfo);
              
             }else{
                 $result['status'] = 0;
             }
             $result['role'] = $role;
             //echo $this->getLastSql();exit;
             return $result;
         }else {
            echo 'login wrong';
         }
    }
 
}