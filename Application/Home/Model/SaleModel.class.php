<?php
namespace Home\Model;
use Think\Model;
class SaleModel extends Model{
  
  
	public function adds() {
        
    	if(IS_POST) {
           
           $userInfo  = \Org\Util\User::_getUserInfo();
           $member_id = $userInfo['member_id'];
          // $pool_id   = $userInfo['member_pool_id'];
           $params = I("post.");
           $params['sale_member_id'] = $member_id;
           //$params['sale_pool_id'] = $pool_id;
            if(! $this->add($params)) {
              return 0;
           }
            return 1;
      }else {
            echo 'error';
            return;
      }
	}
    public function querys() {

        $params['sale_id'] = I("get.sale_id");
        $params['sale_record_id']=I('get.record_id');
        $params['sale_client_name']=I('get.client_name');
        if($params['sale_id']!=0 && $params['sale_id']!=null)
            $query['sale_id']=$params['sale_id'];
        if( $params['sale_record_id']!=0 && $params['sale_record_id']!=null)
            $query['sale_record_id']= $params['sale_record_id'];
        if($params['sale_client_id']!=0 && $params['sale_client_id']!=null)
            $query['sale_client_id']=$params['sale_client_id'];
        /*if($params['stocking_cage_id']!=0)
            $query['stocking_cage_id']=$params['stocking_cage_id'];*/
        $data= $this->where($query)->select();
        foreach ($data as $key => $value) {

            $data[$key]['sale_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['sale_fry_id'],'fry_name');
            // $data[$key]['sale_record_id'] = M('record')->getFieldByrecord_id($data[$key]['sale_record_id'],'record_batch');
        }

        return $data;
    }
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("sale_id = $params")->find();
            // $data['sale_fry_id'] = M('fry')->getFieldByfry_id($data['sale_fry_id'],'fry_name');
            // $data['sale_cage_id'] = M('cage')->getFieldBycage_id($data['sale_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

	   $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       $count = $this->where("sale_member_id = $member_id")->count();

       $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("sale_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->select();
       
       foreach ($data as $key => $value) {

            $data[$key]['sale_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['sale_fry_id'],'fry_name');
            // $data[$key]['sale_record_id'] = M('record')->getFieldByrecord_id($data[$key]['sale_record_id'],'record_batch');
       }
      
       $result['page'] = $show;
       $result['data'] = $data;
       return $result;
	}
  public function modify(){

      if(IS_POST) { 
           $data = I('post.');
           $id = $data['sale_id'];
           if(!($this->where("sale_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}