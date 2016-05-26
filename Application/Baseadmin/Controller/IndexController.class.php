<?php
namespace Baseadmin\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    public function index(){ 
        
        $this->display();
    }
    
}