<?php
namespace Home\Controller;
use Think\Controller;
class SaleController extends Controller {
    
    private  $userInfo  = array();
    private  $record    = array();
    private  $sale      = array();
    private  $trace     = array();
    private  $fry       = array();
    private  $pool      = array();
    private  $this_pool = array();
    private  $cage      = array();

	public function _initialize(){
  
		  $this->userInfo = \Org\Util\User::_getUserInfo();
          if(empty($this->userInfo)) {
              redirect(U('Home/Index/index'));
          }

          $this->record = D('record')->get();
          $this->sale   = D('sale')->get();
          $this->trace  = D('trace')->get();
          $this->fry    = D('fry')->get();
          $this->pool   = D('pool')->getAll();
          $this->this_pool = D('pool')->get();
          $this->cage   = D('cage')->get();

	}
     
	public function sale(){
        
        date_default_timezone_set('prc');
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
		$name = I('get.name');

        switch ($name) {
             
            case 'record':
                 $data = $this->record;
                 $this->assign('record',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'sale':
                 $data = $this->sale;
                 $this->assign('sale',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'trace':
                 $data = $this->trace;
                 $this->assign('trace',$data['data']);
                 $this->assign('page', $data['page']);  
            break;
            default:
                echo 'name wrong ';
                break;	
        }
        $this->assign('record_data',$this->record['data']);
        $this->assign('sale_data', $this->sale['data']);
        $this->assign('this_pool', $this->this_pool);
        $this->assign('pool',$this->pool);
        $this->assign('fry',$this->fry);
        $this->assign('cage',$this->cage);

        $this->display($name);
	}
    public function adds() {
        
        $name = I('get.name');
        $data = D($name)->adds();
     }
     public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
     }
     public function modify() {
        
        $result = D(I('get.name'))->modify();
     }
     public function transfer(){
        
        $data = D('cage')->transfer();
        $this->ajaxReturn($data);
     }
}