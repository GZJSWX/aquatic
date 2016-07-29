<?php
namespace Baseadmin\Controller;
use Think\Controller;
class TraceController extends Controller{
    
    static private $breed = array();
    static private $sale = array();
    static private $batch = array();

    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }

    public function querys() {
         $name = I('get.name');
        $this->display($name);
    }

    public function search1(){
        $data=D('stocking')->search_breed();
        $this->ajaxReturn($data);
    }
    public function search2(){
        $data=D('stocking')->search_batch();
        $this->ajaxReturn($data);
    }
    public function search3(){
        $data=D('trace')->search_sale();
        $this->ajaxReturn($data);
    }

}