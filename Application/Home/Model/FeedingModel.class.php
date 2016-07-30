<?php
namespace Home\Model;
use Think\Model;
class FeedingModel extends Model{


	public function adds()
    {

        if (IS_POST) {

            $userInfo = \Org\Util\User::_getUserInfo();
            $params = I("post.");
            $params['feeding_member_id'] = $userInfo['member_id'];
            $params['feeding_time'] = date('Y-m-d H:i:s', time());
            if (!$this->add($params)) {
                return 0;
            }
            return 1;
        }
    }
    public function querys()
    {
        if (IS_GET) {
            $userInfo = \Org\Util\User::_getUserInfo();
            $member_id = $userInfo['member_id'];
            $query['feeding_member_id']=$member_id;
            $params['feeding_pool_id'] = I("get.feeding_pool_id");
            $params['feeding_cage_id'] = I('get.feeding_cage_id');
            $params['feeding_feed_id'] = I('get.feeding_feed_id');
            if ($params['feeding_pool_id'] != 0)
                $query['feeding_pool_id'] = $params['feeding_pool_id'];
            if ($params['feeding_cage_id'] != 0)
                $query['feeding_cage_id'] = $params['feeding_cage_id'];
            if ($params['feeding_feed_id'] != 0)
                $query['feeding_feed_id'] = $params['feeding_feed_id'];
            /*if($params['stocking_cage_id']!=0)
                $query['stocking_cage_id']=$params['stocking_cage_id'];*/
            $data = $this->where($query)->select();
            foreach ($data as $key => $value) {
                $cage = $data[$key]['feeding_cage_id'];
                if ($cage == null || $cage == 0) {
                    $data[$key]['medication_cage_id'] = '无网箱';
                }
                $data[$key]['feeding_feed_id'] = M('feed')->getFieldByfeed_id($data[$key]['feeding_feed_id'], 'feed_name');
                $data[$key]['feeding_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['feeding_cage_id'], 'cage_rowname');
                $data[$key]['feeding_pool_id'] = M('pool')->getFieldBypool_id($data[$key]['feeding_pool_id'], 'pool_name');
                $data[$key]['feeding_pool_img'] = C('PIC_UPLOADS') . $data[$key]['feeding_pool_img'];
            }
            return $data;
        }
    }
	public function getChoose(){

       if(IS_GET) {
           $params = I('get.val');
           $data = $this->where("feeding_id = $params")->find();
           //$data['feeding_feed_id'] = M('feed')->getFieldByfeed_id($data['feeding_feed_id'],'feed_name');
           //$data['feeding_cage_id'] = M('cage')->getFieldBycage_id($data['feeding_cage_id'],'cage_rowname');
           return $data;
       }else {
         echo 'getChoosePool wrong';
       }
    }
	public function get(){

        $userInfo = \Org\Util\User::_getUserInfo();
        $member_id = $userInfo['member_id'];
        $count = $this->where("feeding_member_id = $member_id")->count();

        $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
        $Page->setConfig('prev',  '上一页');//上一页
        $Page->setConfig('next',  '下一页');//下一页
        $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
        $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
        $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
        $show = $Page->show();
        $data = $this->where("feeding_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->order('feeding_time desc')->select();
        //获取图片地址

        foreach ($data as $key => $value) {
       	  
       	   $cage = $data[$key]['feeding_cage_id'];
       	   if($cage == null || $cage == 0) {
             $data[$key]['medication_cage_id'] = '无网箱';
           }
            $data[$key]['feeding_feed_id'] = M('feed')->getFieldByfeed_id($data[$key]['feeding_feed_id'],'feed_name');
            $data[$key]['feeding_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['feeding_cage_id'],'cage_rowname');
            $data[$key]['feeding_pool_id'] = M('pool')->getFieldBypool_id($data[$key]['feeding_pool_id'],'pool_name');
            $data[$key]['feeding_pool_img'] = C('PIC_UPLOADS').$data[$key]['feeding_pool_img'];
        }
//        var_dump($data);die;
        $result['page'] = $show;
        $result['data'] = $data;

        return $result;
	}

  public function modify(){

      if(IS_POST) { 

           $data = I('post.');
           $id = $data['feeding_id'];
           if(!($this->where("feeding_id = $id")->save($data))) {
               echo ' wrong';
           }
      }else {
        echo 'wrong';
      }
    }

}