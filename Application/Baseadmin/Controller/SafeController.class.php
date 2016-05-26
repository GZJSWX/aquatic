<?php
namespace Baseadmin\Controller;
use Think\Controller;
class SafeController extends Controller{
    
    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
	public function index() {
        
		$result = D('pool')->getPoolInfo();
     	$this->assign("pool_data", $result['data']);
        $this->assign('time', $result['time']);
		$this->display();
	}

    public function addPool(){

    	$result = D("pool")->addPool();

    }

    public function getChoosePool(){

        $data = D("pool")->getChoosePool();
        $this->ajaxReturn($data);
    }
}