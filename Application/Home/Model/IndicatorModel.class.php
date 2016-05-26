<?php
namespace Home\Model;
use Think\Model;
class IndicatorModel extends Model{

	public function adds() {
        
    	if(IS_POST) {
           
           // date_default_timezone_set('prc');
           // $time = date('Y-m-d H:i', time());
           $userInfo = \Org\Util\User::_getUserInfo();
           $params = I("post.");
           $params['indicator_pool_id'] = $userInfo['member_pool_id'];
           $params['indicator_member_id'] = $userInfo['member_id'];
           //$params['indicator_time'] = $time;

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
           $data = $this->where("indicator_id = $params")->find();
           //$data['indicator_feed_id'] = M('feed')->getFieldByfeed_id($data['indicator_feed_id'],'feed_name');
           //$data['indicator_cage_id'] = M('cage')->getFieldBycage_id($data['indicator_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

       $userInfo = \Org\Util\User::_getUserInfo();
       $member_id = $userInfo['member_id'];
       $count = $this->where("indicator_member_id = $member_id")->count();

       $Page  = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(2)
       $Page->setConfig('prev',  '上一页');//上一页
       $Page->setConfig('next',  '下一页');//下一页
       $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
       $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
       $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
       $show = $Page->show();
       $data = $this->where("indicator_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->select();
       foreach ($data as $key => $value) {
          
          $cage = $data[$key]['indicator_cage_id'];
          if($cage == '0') {
             $data[$key]['indicator_cage_id'] = '无网箱';
          }
       }  
       foreach ($data as $key => $value) {

            $data[$key]['indicator_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['indicator_cage_id'],'cage_rowname');
       }
       $result['page'] = $show;
       $result['data'] = $data;
      
       return $result;
  }

  public function modify(){

      if(IS_POST) { 

           $data = I('post.');
           $id = $data['indicator_id'];
           if(!($this->where("indicator_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}