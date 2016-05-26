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
    public function search() {

         $name = I('get.name');

         $data = array();
         switch ($name) {
           case 's1':
             $data = D('trace')->search_breed();
             break;
           case 's2':
             $data = D('trace')->search_batch();
             break;
           case 's3':
              $data = D("trace")->search_sale();
             break;
           default:
             echo 'trace search wrong';
             break;
         }
        $this->assign('data',$data);  
        $this->display($name);
    }

   
}