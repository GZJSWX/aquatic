<?php
namespace Superadmin\Model;
use Think\Model;
class MemberModel extends Model{

	public function adminRegister(){

		if(IS_POST){

            $params = I("post.");

            $params['member_role'] = 2;

			//dump($nameResult);exit();

			if(!$this->checkName($params['member_username']))
				return 1;
			elseif(!$this->checkParams($params))
				return 2;
			elseif($params['member_base_id']==0)
				return 3;
			elseif($params['member_permission']==0)
				return 4;
			else{
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
	public function getMemberInfo() {
        
		$data = $this->where("member_role = 2")->select();
		foreach($data as $key => $value) {
			$data[$key]['member_permission'] = M('base')->getFieldbyBase_id($data[$key]['member_permission'],'base_name');
		    $data[$key]['member_base_id'] = M('base')->getFieldbyBase_id($data[$key]['member_base_id'],'base_name');
		    $data[$key]['member_role'] = 2 ? '基础管理员' : '普通用户';
		}
        return $data;
	}

}