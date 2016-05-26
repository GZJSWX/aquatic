<?php
namespace Baseadmin\Model;
use Think\Model;
class MemberModel extends Model{
    
    
    public function adminRegister(){

    		if(IS_POST){
                $userInfo = \Org\Util\User::_getUserInfo();     
                $params = I("post.");
                $params['member_role'] = 3;
                $this->checkParams($params);

                $params['member_base_id'] =  $userInfo['member_base_id'];
               // $params['member_password'] = md5(str)
                if( !$this->add($params)) {
                    echo 'Member adminRegister wrong';
                }
                
    		}else {
               echo 'Member register wrong';
    		}
  	}
  	// public function checkParams($params){
         
  	// }
  	public function showMe(){
         
         $userInfo = \Org\Util\User::_getUserInfo();

         $id = $userInfo['member_id'];
         
         $data = $this->where(array('member_id' => $id))->find();
  	     $data['member_base_id'] = M('base')->getFieldbyBase_id($data['member_base_id'],'base_name');
  	     $data['member_role'] = '基础管理员';
         return $data;
  	}
    public function getMemberInfo() {
      // 在界面的右边角来个图文信息介绍所属基地
      $userInfo = \Org\Util\User::_getUserInfo();
      $member_base_id = $userInfo['member_base_id'];
      $data = $this->where("member_role = 3 and member_base_id = $member_base_id")->select();
      foreach($data as $key => $value) {

          $data[$key]['member_pool_id'] = M('pool')->getFieldbypool_id($data[$key]['member_pool_id'],'pool_name');
          $data[$key]['member_role'] = '普通用户';
      }
      return $data;
    }


}