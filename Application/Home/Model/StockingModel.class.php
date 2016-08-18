<?php
namespace Home\Model;
use Think\Model;
class StockingModel extends Model{
  
  
	public function adds() {
        
    	if(IS_POST) {
            //dump($_POST);exit();
           $userInfo = \Org\Util\User::_getUserInfo();
           $member_id = $userInfo['member_id'];
           $params = I("post.");
            if($params['stocking_pool_id']==0 || $params['stocking_cage_id'] == 0)
                return 2;
           $params['stocking_member_id'] = $member_id;
           $cage = M('cage')->getFieldBycage_id($params['stocking_cage_id'], 'cage_rowid');
            if($cage == null)
                $cage = "00";

            $pool = M('pool')->getFieldBypool_id($params['stocking_pool_id'], 'pool_code');

            $params['stocking_batch'] = date('Ymd',strtotime($params['stocking_start_time'])).$pool.$cage;

           if(! $this->add($params)) {
              return 0;
           }
            return 1;
    	}else {
            echo 'error';
            return;
    	}
	}
    public function querys()
    {
        if (IS_GET) {
            $userInfo = \Org\Util\User::_getUserInfo();
            $member_id = $userInfo['member_id'];
            $query['stocking_member_id']=$member_id;
            $params['stocking_fry_id'] = I("get.stocking_fry_id");
            $params['stocking_batch'] = I('get.stocking_batch');
            $params['stocking_cage_id'] = I('stocking_cage_id');

            if ($params['stocking_fry_id'] != 0)
                $query['stocking_fry_id'] = $params['stocking_fry_id'];
            if ($params['stocking_batch'] != null)
                $query['stocking_batch'] = $params['stocking_batch'];
            if ($params['stocking_cage_id'] != 0)
                $query['stocking_cage_id'] = $params['stocking_cage_id'];
           if( $data = $this->where($query)->order('stocking_start_time desc')->select()) {
               foreach ($data as $key => $value) {
                   $cage = $data[$key]['stocking_cage_id'];
                   if ($cage == '0') {
                       $data[$key]['stocking_cage_id'] = '无网箱';
                   }
                   $data[$key]['stocking_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['stocking_fry_id'], 'fry_name');
                   $data[$key]['stocking_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['stocking_cage_id'], 'cage_rowname');
               }
               return $data;
           }
            else return null;

        }
    }


	public function getChoose(){
       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("stocking_id = $params")->find();
//           $startTime = $this->getFieldBystocking_id($data['stocking_id'],'stocking_start_time');
//           $data['stocking_start_time'] = date('d F Y',strtotime($startTime));
//           $finishTime = $this->getFieldBystocking_id($data['stocking_id'],'stocking_finish_time');
//           $data['stocking_finish_time'] = date('d F Y',strtotime($finishTime));
           //$data['stocking_fry_id'] = M('fry')->getFieldByfry_id($data['stocking_fry_id'],'fry_name');
           //$data['stocking_cage_id'] = M('cage')->getFieldBycage_id($data['stocking_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){
        $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       $count = $this->where("stocking_member_id = $member_id")->count();
       $Page  = new \Think\Page($count,15);
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("stocking_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->order('stocking_id desc')->select();
       foreach ($data as $key => $value) {
       	  
       	  $cage = $data[$key]['stocking_cage_id'];
       	  if($cage == '0') {
       	  	 $data[$key]['stocking_cage_id'] = '无网箱';
       	  }

          $data[$key]['stocking_poop_id'] = M('pool')->getFieldBypool_id($data[$key]['stocking_pool_id'],'pool_name');
          $data[$key]['stocking_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['stocking_fry_id'],'fry_name');
          $data[$key]['stocking_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['stocking_cage_id'],'cage_rowname');
       }  
      
       $result['page'] = $show;
       $result['data'] = $data;
      
       return $result;
	}
  
  public function modify(){

      if(IS_POST) { 
           $data = I('post.');
           $id = $data['stocking_id'];
           if(!($this->where("stocking_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}