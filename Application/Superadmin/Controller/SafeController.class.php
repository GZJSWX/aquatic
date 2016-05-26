<?php
namespace Superadmin\Controller;
use Think\Controller;
class SafeController extends Controller{
    
    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
	public function index() {

		$result = D('Base')->getBaseInfo();
     	$this->assign("base_data", $result['data']);
        $this->assign('time', $result['time']);

        $feed = D('feed')->getFeedInfo();
        $fry  = D('fry')->getFryInfo();
        $medicine = D('medicine')->getMedicineInfo();

        $this->assign('feed',$feed);
        $this->assign('fry',$fry);
        $this->assign('medicine',$medicine);
		$this->display();
	}

	public function modifyBase() {
        
        $result = D("Base")->modifyBase();
    }
    public function modifyMedicine() {
        
        $result = D("medicine")->modifyMedicine();
    }
    public function modifyFeed() {
        
        $result = D("feed")->modifyFeed();
    }
    public function modifyFry() {
        
        $result = D("fry")->modifyFry();
    }

    public function addBase(){

    	$result = D("base")->addBase();
    }
    
    public function addFeed(){

        $result = D("feed")->addFeed();
    }
    public function addFry(){

        $result = D("fry")->addFry();
    }
    public function addMedicine(){

        $result = D("medicine")->addMedicine();
    }
    public function getChooseBase(){

        $data = D("base")->getChooseBase();
        $this->ajaxReturn($data);
    }
    public function getChooseFeed(){

        $data = D("feed")->getChooseFeed();
        $this->ajaxReturn($data);
    }
    public function getChooseFry(){

        $data = D("fry")->getChooseFry();
        $this->ajaxReturn($data);
    }
    public function getChooseMedicine(){

        $data = D("medicine")->getChooseMedicine();
        $this->ajaxReturn($data);
    }

}