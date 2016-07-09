<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    
    public function _before_showMe(){

         $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    public function showMe() {

        $data = D('member')->showMe();
        $this->assign('member_data',$data);
        $role = I('get.role');

        if($role == '1') {
           $this->display('Superadmin@User:showMe');
        }else if($role == '2'){
           $this->display('Baseadmin@User:showMe');  
        }else {
            $this->display();
        }
        
    }
    public function login(){

        $result=D('member')->login();
        if($result['status']) {

        	switch ($result['role']) {
        		case 1:
        			redirect(U('Superadmin/Index/index'));
        			break;
        		case 2:
        			redirect(U('Baseadmin/Index/index'));
        			break;
        	    case 3:
        			redirect(U('Home/Index/iindex'));
        			break;
        		default:
        			echo 'User login wrong';
        			break;
        	}
        }else {
            echo '登录失败';
        }

    }
    public function modify() {

        $result = D(I('get.name'))->modify();
        
    }
    public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
    }
}