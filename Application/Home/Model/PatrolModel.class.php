<?php
namespace Home\Model;
use Think\Model;
class PatrolModel extends Model{
  

	public function adds() {
        
    	if(IS_POST) {
           
           $userInfo = \Org\Util\User::_getUserInfo();
           $params = I("post.");
           // $params['patrol_pool_id'] = $userInfo['member_pool_id'];
           $params['patrol_member_id'] = $userInfo['member_id'];
           //$params['patrol_death_date'] = date('Y-m-d');
           $params['patrol_coordinate'] = $params['latitude'].$params['longitude'];

           if(! $this->add($params)) {
             
              return 0;
           }
            return 1;
      }else {
            echo 'error';
            return;
      }
	}
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("patrol_id = $params")->find();
            // $data['patrol_fry_id'] = M('fry')->getFieldByfry_id($data['patrol_fry_id'],'fry_name');
            // $data['patrol_cage_id'] = M('cage')->getFieldBycage_id($data['patrol_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

	     $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       
       $count = $this->where("patrol_member_id = $member_id")->count();

       $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("patrol_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->order("patrol_id desc")->select();
       

       foreach ($data as $key => $value) {

            $cage = $data[$key]['feeding_cage_id'];
            if($cage == null || $cage == 0) {
               $data[$key]['medication_cage_id'] = '无网箱';
            }
            $data[$key]['patrol_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['patrol_fry_id'],'fry_name');
            $data[$key]['patrol_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['patrol_cage_id'],'cage_rowname');
            $data[$key]['patrol_pool_id'] = M('pool')->getFieldBypool_id($data[$key]['patrol_pool_id'],'pool_name');
            $data[$key]['patrol_pool_img'] = C('PIC_UPLOADS').$data[$key]['patrol_pool_img'];
       }
       $result['page'] = $show;
       $result['data'] = $data;
      
       return $result;
	}
  
  public function modify(){

      if(IS_POST) { 
           $data = I('post.');
           $id = $data['patrol_id'];
           if(!($this->where("patrol_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}