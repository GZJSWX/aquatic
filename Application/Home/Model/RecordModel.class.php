<?php
namespace Home\Model;
use Think\Model;
class RecordModel extends Model{

    private  $query  = array();
	public function adds() {
        
    	if(IS_POST) {
           
           $userInfo  = \Org\Util\User::_getUserInfo();
           $member_id = $userInfo['member_id'];
           $pool_id   = $userInfo['member_pool_id'];
           $params = I("post.");
           $params['record_member_id'] = $member_id;
           $params['record_pool_id'] = $pool_id;
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

        $params['record_id'] = I("get.record_id");
        $params['record_type']=I('get.record_type');
        $params['record_batch']=I('get.record_batch');
        $params['record_time']=I('get.record_time');

        if($params['record_type']!=0)
            $query['record_type']=$params['record_type'];
        if($params['record_id']!=null&&$params['record_id']!=0)
            $query['record_id']=$params['record_id'];
        if($params['record_batch']!=null&&$params['record_batch']!=0)
            $query['record_batch']=$params['record_batch'];
        if($params['record_time']!=null&&$params['record_time']!=0)
            $query['record_time']=$params['record_time'];

        $data= $this->where($query)->select();

        foreach ($data as $key => $value) {

            $data[$key]['record_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['record_fry_id'],'fry_name');
            $data[$key]['record_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['record_cage_id'],'cage_rowname');
            $data[$key]['record_transfer_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['record_transfer_cage_id'],'cage_rowname');
            $data[$key]['record_transfer_pool_id'] = M('pool')->getFieldBypool_id($data[$key]['record_transfer_pool_id'],'pool_name');
        }
        foreach ($data as $key => $value) {
            $cage = $data[$key]['record_cage_id'];
            if($cage == '0') {
                $data[$key]['record_cage_id'] = '无';
            }
            $cage = $data[$key]['record_transfer_cage_id'];
            if($cage == '0') {
                $data[$key]['record_transfer_cage_id'] = '无';
            }

        }
        return $data;
    }
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("record_id = $params")->find();
            // $data['record_fry_id'] = M('fry')->getFieldByfry_id($data['record_fry_id'],'fry_name');
            // $data['record_cage_id'] = M('cage')->getFieldBycage_id($data['record_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

	   $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       $count = $this->where("record_member_id = $member_id")->count();

       $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("record_member_id = $member_id")->order('record_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
       
       foreach ($data as $key => $value) {

            $data[$key]['record_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['record_fry_id'],'fry_name');
            $data[$key]['record_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['record_cage_id'],'cage_rowname');
            $data[$key]['record_transfer_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['record_transfer_cage_id'],'cage_rowname');
            $data[$key]['record_transfer_pool_id'] = M('pool')->getFieldBypool_id($data[$key]['record_transfer_pool_id'],'pool_name');
       }
       foreach ($data as $key => $value) {
       	  
       	  $cage = $data[$key]['record_cage_id'];
       	  if($cage == '0') {
       	  	 $data[$key]['record_cage_id'] = '无';
       	  }
       	  $cage = $data[$key]['record_transfer_cage_id'];
       	  if($cage == '0') {
       	  	 $data[$key]['record_transfer_cage_id'] = '无';
       	  }

       }  
       $result['page'] = $show;
       $result['data'] = $data;
       return $result;
	}
  public function modify(){

      if(IS_POST) { 
           $data = I('post.');
           $id = $data['record_id'];
           if(!($this->where("record_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}