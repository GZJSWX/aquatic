<?php
namespace Superadmin\Controller;
use Think\Controller;
class UserController extends Controller{
    
    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    public function index(){
    	$data = D('base')->getBaseInfo();
    	$this->assign('base_data',$data['data']);
    	$this->assign('time',$data['time']);
    	$this->display();
    }
    public function manage(){
    	$data= D('member')->getMemberInfo();
    	$this->assign('member_data',$data);
    	$this->display();
    }
	public function adminRegister(){
        
        $data = D('Member')->adminRegister();
        redirect(U("Superadmin/Index/index"));
	}
   
}