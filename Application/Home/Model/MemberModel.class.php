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
        $data['member_permission'] = M('base')->getFieldbyBase_id($data['member_permission'],'base_name');
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
             $psw = I("get.member_password");
             $password = md5($psw.$username);
             //dump($password);exit();
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
    public function getChoose(){

        if(IS_GET) {
            $params = I('get.val');
            $choosePool = $this->where("member_id = $params")->find();
            return $choosePool;
        }else {
            echo 'getChoosePool wrong';
        }
    }
    public function modify(){

        if(IS_POST) {
            $userInfo= \Org\Util\User::_getUserInfo();
            $data = I('post.');
            $id = $userInfo['member_id'];
            if($userInfo['member_password']==$data['old_member_password']) {
                $userInfo['member_password']=$data['new_member_password'];
                $this->where(" member_id= $id")->save($userInfo);
                \Org\Util\User::_setUserInfo($userInfo);
                echo "修改成功";
            }
            else{
                echo  "修改失败：旧密码不对";
            }
        }else {
            echo 'modifyPoolInfowrong';
        }

    }
 
}