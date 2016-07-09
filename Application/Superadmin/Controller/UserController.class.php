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

    	$data = D('member')->getMemberInfo();
        $base = D('base')->getBase();
        //dump($base);exit();
    	$this->assign('member_data',$data);
        $this->assign('base',$base);
    	$this->display();
    }
	public function adminRegister(){
        $params = I("post.");

        $data = D('Member')->adminRegister();
        //dump($data);exit();
        if($data==1){
            $this->error("已存在此用户名，请选择其他用户名");
        }elseif($data==2){
            $this->error("两次密码不同，请重新填写");
        }elseif($data==3){
            $this->error("请选择所属基地");
        }elseif($data==4){
            $this->error("请选择权限");
        }elseif($data==5){
            $this->error("注册失败，请重新尝试！");
        }
        else{
            $this->success("注册成功",U("Superadmin/Index/index"));
        }

	}
    public function getManage(){

        $data = D('member')->getChooseMember();
        $this->ajaxReturn($data);
    }

    public function manageSave(){
        $data = D('member')->saveManage();
        $this->ajaxReturn($data);
    }
}