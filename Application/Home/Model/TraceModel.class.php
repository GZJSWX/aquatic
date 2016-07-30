<?php
namespace Home\Model;
use Think\Model;
class TraceModel extends Model{
  
  
	public function adds() {
        
    	if(IS_POST) {
           
           $userInfo  = \Org\Util\User::_getUserInfo();
           $member_id = $userInfo['member_id'];
           $base_id   = $userInfo['member_base_id'];
           $pool_id   = $userInfo['member_pool_id'];
           $params    = I("post.");
           $params['trace_member_id'] = $member_id;
           $params['trace_pool_id']   = $pool_id;
           $params['trace_base_id']   = $base_id;
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
            $query['trace_member_id']=$member_id;
            $params['trace_sale_id'] = I("get.trace_sale_id");
            $params['trace_fry_id'] = I('get.trace_fry_id');

            if ($params['trace_sale_id'] != 0)
                $query['trace_sale_id'] = $params['trace_sale_id'];
            if ($params['trace_fry_id'] != 0)
                $query['trace_fry_id'] = $params['trace_fry_id'];
            $data = $this->where($query)->select();
                foreach ($data as $key => $value) {
                    $data[$key]['trace_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['trace_fry_id'],'fry_name');
                    // $data[$key]['trace_sale_id'] = M('sale')->getFieldBysale_id($data[$key]['trace_sale_id'],'sale_client_name');
                }
                return $data;
            }
    }
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("trace_id = $params")->find();
            // $data['trace_fry_id'] = M('fry')->getFieldByfry_id($data['trace_fry_id'],'fry_name');
            // $data['trace_cage_id'] = M('cage')->getFieldBycage_id($data['trace_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

	     $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       $count = $this->where("trace_member_id = $member_id")->count();

       $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("trace_member_id = $member_id")->order("trace_finish_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
       
       foreach ($data as $key => $value) {

            $data[$key]['trace_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['trace_fry_id'],'fry_name');
            // $data[$key]['trace_sale_id'] = M('sale')->getFieldBysale_id($data[$key]['trace_sale_id'],'sale_client_name');
       }
       $result['page'] = $show;
       $result['data'] = $data;
       return $result;
	}
  public function modify(){

      if(IS_POST) { 
           $data = I('post.');
           $id = $data['trace_id'];
           if(!($this->where("trace_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}