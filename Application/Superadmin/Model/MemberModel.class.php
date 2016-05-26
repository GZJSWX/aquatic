<?php
namespace Superadmin\Model;
use Think\Model;
class MemberModel extends Model{

	public function adminRegister(){

		if(IS_POST){
            
            $params = I("post.");
            $params['member_role'] = 2;
            $this->checkParams($params); 
            if( !$this->add($params)) {
                echo 'Member adminRegister wrong';
            }
            
		}else {
           echo 'Member register wrong';
		}
	}
	public function checkParams($params){
       
	}
	public function getMemberInfo() {
        
		$data = $this->where("member_role = 2")->select();
		foreach($data as $key => $value) {

		    $data[$key]['member_base_id'] = M('base')->getFieldbyBase_id($data[$key]['member_base_id'],'base_name');
		    $data[$key]['member_role'] = 2 ? '基础管理员' : '普通用户';
		}
        return $data;
	}

}