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

    public function deletePool(){
        if(IS_GET){
            //dump($_GET);exit();
            $pool_id = I('get.id',null);
            $result = M('pool')->where(array('pool_id'=>$pool_id))->delete();
            if($result){
                $this->success('删除成功', U('Baseadmin/Safe/index'));
                //redirect(U('Baseadmin/Safe/index'));
            }else{
                $this->error('删除失败');
            }
        }
        else{
            $this->error('删除失败');
        }
    }

    public function poolMap(){
        $pool = D('pool')->getPoolAndCageInfo();
        $base = D('base')->getBaseInfo();
        $this->assign('pool',$pool);
        $this->assign('base',$base);
        $this->display();
    }

    public function saveCoordinate(){
        if($_POST){
            $coordinate = I('post.');
            if($coordinate['type']==0){
                $data = D('pool')->addCoordinate($coordinate);
                $this->ajaxReturn($data);
            }else{
                $data = D('cage')->addCoordinate($coordinate);
                $this->ajaxReturn($data);
            }
        }
    }

    public function getPoolCoordinate(){
        if($_GET){
            $name = I('get.name');
            $userInfo = \Org\Util\User::_getUserInfo();
            $result = D('pool')->where(array('pool_base_id'=>$userInfo['member_base_id'],'pool_name'=>$name))->find();
            $this->ajaxReturn($result);
        }
        return null;
    }

    public function getCageCoordinate(){
        if($_GET){
            $name = I('get.name');
            $result = D('cage')->where(array('cage_rowname'=>$name))->getField('cage_coordinate');
            $this->ajaxReturn($result);
        }
        return null;
    }

    public function getAllPool(){
        $userInfo = \Org\Util\User::_getUserInfo();
        $result = D('pool')->where(array('pool_base_id'=>$userInfo['member_base_id']))->getField('pool_coordinate',true);
        $this->ajaxReturn($result);
    }

    public function deleteArea(){
        if($_POST){
            $name = I('post.typeName');
            $type = I('post.type');
            if($type==0){
                $userInfo = \Org\Util\User::_getUserInfo();
                $result = D('pool')->where(array('pool_base_id'=>$userInfo['member_base_id'],'pool_name'=>$name))->setField('pool_coordinate',null);
            }else{
                $result = D('cage')->where(array('cage_rowname'=>$name))->setField('cage_coordinate',null);
            }
            $this->ajaxReturn($result);
        }return null;
    }
}