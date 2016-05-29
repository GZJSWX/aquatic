<?php
namespace Home\Controller;
use Think\Controller;
class SafeController extends Controller {
     
     private  $base = array();
     private  $cage = array();
     private  $feeding = array();
     private  $fry = array();
     private  $patrol = array();
     private  $pool = array();
     private  $stocking = array();
     private  $medication = array();
     private  $medicine = array();
     private  $indicator = array();
     private  $userInfo = array();
     private  $feed     = array();

     public function _initialize(){
          
          $this->userInfo = \Org\Util\User::_getUserInfo();
          if(empty($this->userInfo)) {
              redirect(U('Home/Index/index'));
          }
          $this->base = D('base')->get();
          $this->cage = D('cage')->get();
          $this->feeding = D('feeding')->get();
          $this->fry = D('fry')->get();
          $this->patrol = D('patrol')->get();
          $this->pool = D('pool')->get();
          $this->stocking = D('stocking')->get();
          $this->medication = D('medication')->get();
          $this->medicine = D('medicine')->get();
          $this->indicator = D('indicator')->get();
          $this->feed = D('feed')->get();
          //要上缓存
          //S($name,$value,$options)
     }
     public function index(){
         
       	$this->assign("base_data", $this->base['data']);
       	$this->assign('time', $this->base['time']);
         
        $this->assign("pool_data", $this->pool);   
        $this->assign('cage',$this->cage);
       	$this->display();
     }
     public function cultivation(){
        
        date_default_timezone_set('prc');
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
        $name = I('get.name');

        switch ($name) {
             
            case 'stocking':
                 $data = $this->stocking;
                 $this->assign('stocking',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'feeding':
                 $data = $this->feeding;
                 $this->assign('feeding',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'patrol':
                 $data = $this->patrol;
                 $this->assign('patrol',$data['data']);
                 $this->assign('page', $data['page']);  
                break;
            case 'medication':
                 $data = $this->medication;
                 $this->assign('medication', $data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'indicator':
            $data = $this->indicator;
            $this->assign('indicator', $data['data']);
            $this->assign('page', $data['page']);
                break;
            default:
                echo 'name wrong ';
                break;
        }
        
        $this->assign('pool_data',$this->pool);
        $this->assign('fry',$this->fry);
        $this->assign('cage',$this->cage);
        $this->assign('feed',$this->feed);
        $this->assign('medicine', $this->medicine);
        
        $this->display($name);
     }
     
     public function adds() {
        

        $name = I('get.name');
        $data = D($name)->adds();
        if($data == 0){
           $this->ajaxReturn(array('code'=>0,'msg'=>'插入失败'));
        }else {
            $this->ajaxReturn(array('code'=>1,'msg'=>'添加成功'));
        }
     }
     public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
     }
     public function modify() {
        
        $result = D(I('get.name'))->modify();
     }

      // public function commonInfo() {

     //      $feed = D('feed')->getFeedInfo();
     //      $fry  = D('fry')->getFryInfo();
     //      $medicine = D('medicine')->getMedicineInfo();

     //      $this->assign('feed',$feed);
     //      $this->assign('fry',$fry);
     //      $this->assign('medicine',$medicine);
     //      $this->display();

     // }
     
}

