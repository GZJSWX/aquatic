<?php
namespace Baseadmin\Controller;
use Think\Controller;
class UserController extends Controller{
    
    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    
    public function index(){
    	$data = D('pool')->getPoolInfo();
    	$this->assign('pool_data',$data['data']);
    	$this->assign('time',$data['time']);
    	$this->display();
    }
	public function showMe() {

		$data = D('member')->showMe();
		$this->assign('member_data',$data);
		$this->display();
	}
    public function manage(){
        $data= D('member')->getMemberInfo();
        $this->assign('member_data',$data);
        $this->display();
    }
    public function adminRegister(){
        
        $data = D('Member')->adminRegister();
        redirect(U("Baseadmin/Index/index"));
    }

    
    public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
    }
    public function modify() {

        $result = D(I('get.name'))->modify();
    }
    
}