<?php 
namespace Superadmin\Model;
use Think\Model;
class FeedModel extends Model{

	public function getFeedInfo() {

		$data = $this->select();
		return $data;
	}
	public function addFeed(){

    	if(IS_POST) {

           $params = I("post.");
           if(! $this->add($params)) {
              echo 'addfeed 插入失败';
           }
    	}else {
    		echo 'addFeed wrong';
    	}
    }
    public function getChooseFeed(){

       if(IS_GET) {
           $params = I('get.val');
           $chooseFeed = $this->where("Feed_id = $params")->find();
           return $chooseFeed;
       }else {
         echo 'getChooseFeed wrong';
       }
    }
    public function ModifyFeed(){
        //用echo输出 可以在$.post()中的data中读到，可判断数据正确否
      if(IS_POST) { 
           $data = I('post.');
           $id = $data['feed_id'];
           if(!($this->where("feed_id = $id")->save($data))) {
               echo 'modifyfeedinfo_save wrong';
           }
      }else {
        echo 'wrong';
      }
    }
}