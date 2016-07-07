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
//    public function adminRegister(){
//
//        $data = D('Member')->adminRegister();
//        redirect(U("Baseadmin/Index/index"));
//    }
    public function adminRegister(){
        //$params = I("post.");

        $data = D('Member')->adminRegister();
        //dump($data);exit();
        if($data==1){
            $this->error("已存在此用户名，请选择其他用户名");
        }elseif($data==2){
            $this->error("两次密码不同，请重新填写");
        }elseif($data==4){
            $this->error("请选择权限");
        }elseif($data==5){
            $this->error("注册失败，请重新尝试！");
        }
        else{
            $this->success("注册成功",U("Baseadmin/Index/index"));
        }

    }
    
    public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
    }
    public function modify() {

        $result = D(I('get.name'))->modify();
    }
    
}