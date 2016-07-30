<?php
namespace Superadmin\Model;
use Think\Model;
class BaseModel extends Model{

  	public $result;
  	public function getBaseInfo() {

      date_default_timezone_set('prc');
      $time = date('Y-m-d H:i', time());
  		$this->result['data'] = $this->select();
  		$this->result['time'] = $time;
  		return $this->result;
  	}

    public function getBase(){
        return $this->select();
    }

    public function getChooseBase(){

       if(IS_GET) {
           $params = I('get.val');
           $chooseBase = $this->where("base_id = $params")->find();
           return $chooseBase;
       }else {
         echo 'getChooseBase wrong';
       }
    }
    public function ModifyBase(){
        //用echo输出 可以在$.post()中的data中读到，可判断数据正确否
    	if(IS_POST) { 
           $data = I('post.');
           $id = $data['base_id'];
           if(!($this->where("base_id = $id")->save($data))) {
               echo 'modifybaseinfo_save wrong';
           }
    	}else {
    		echo 'wrong';
    	}
    }

    public function addBase()
    {

        if (IS_POST) {

            date_default_timezone_set('prc');
            $time = date('Y-m-d H:i', time());
            $params = I("post.");
            $params['base_time'] = $time;
            $data['status']=0;
            if ($this->where(array('base_code' => $params['base_code']))->select())
                $data['tishi']= '基地编码不可重复！';
            else {
                if(!(strlen($params['base_tel'])==11&&!preg_match('/\d+/',$params['base_tel'])))
                   $data['tishi'] ='电话为11位且不能为数字';
                else {
                    if (!$this->add($params)) {
                       $data['tishi']= 'addBase 插入失败';
                    } else {
                        $data['tishi']= 'addBase success';
                        $data['status']=1;
                    }
                }
            }
            return $data;
        }

    }
}