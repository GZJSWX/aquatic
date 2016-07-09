<?php
namespace Baseadmin\Model;
use Think\Model;
class MemberModel extends Model{
    
    
//    public function adminRegister(){
//
//    		if(IS_POST){
//                $userInfo = \Org\Util\User::_getUserInfo();
//                $params = I("post.");
//                $params['member_role'] = 3;
//                $this->checkParams($params);
//
//                $params['member_base_id'] =  $userInfo['member_base_id'];
//               // $params['member_password'] = md5(str)
//                if( !$this->add($params)) {
//                    echo 'Member adminRegister wrong';
//                }
//
//    		}else {
//               echo 'Member register wrong';
//    		}
//  	}
  	// public function checkParams($params){
         
  	// }

    public function adminRegister(){

        if(IS_POST){

            $params = I("post.");

            $params['member_role'] = 3;

            //dump($nameResult);exit();

            if(!$this->checkName($params['member_username']))
                return 1;
            elseif(!$this->checkParams($params))
                return 2;
            elseif($params['member_pool_id']==0)
                return 4;
            else{
                $userInfo = \Org\Util\User::_getUserInfo();
                $params['member_base_id'] =  $userInfo['member_base_id'];
                $params['member_password'] = md5($params['member_password'].$params['member_username']);

                if( !$this->add($params)) {
                    return 5;
                }
                else return 0;
            }

        }else {
            return 5;
        }
    }
    public  function checkName($name){
        if($this->where(array('member_username'=>$name))->select())
            return 0;
        else return 1;
    }
    public function checkParams($params){
        if($params['member_password']==$params['member_apassword'])
            return 1;
        return 0;
    }

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
            $data = I('post.');
            $id = $data['member_id'];
            $member=$this->where("member_id = $id")->select();
            $member['member_password']=$data['member_password'];
            $member['member_permission']=$data['member_permission'];
            $member['member_pool_id']=$data['member_pool_id'];
            if(!($this->where("member_id = $id")->save($member))) {
                echo 'modifyMemberinfo_save wrong';
            }
        }else {
            echo 'modifyMemberInfowrong';
        }

    }


}