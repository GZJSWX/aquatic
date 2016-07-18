<?php
namespace Baseadmin\Model;
use Think\Model;
class StockingModel extends Model{

    public function search_breed()
    {
        /* var_dump($params);die;*/
        /*$map['record_pool_id'] = I('get.pool_id');
        if ($map['record_pool_id'] != null)
        strtotime($zero1)<strtotime($zero2)
            $parms['record_pool_id'] = $map['trace_pool_id'];*/
        $map['stocking_batch'] = I('get.batch');
        $start_time= I('get.start_time');
        $end_time=I('get.end_time');
        /*$map['stocking_finish_time'] = array(array('elt', I('get.end_time')), array('egt', I('get.start_time')));*/
        $stocking=$this->where($map)->where(strtotime($start_time)<strtotime('stocking_finish_time')&&strtotime($end_time)>strtotime('stocking_finish_time'))->find();

        $map2['record_batch']=I('get.batch');
        $map2['record_pool_id']=I('get.pool_id');
        $record=M('record')->where($map2)->find();

        $data['pool_id']=$record['record_pool_id'];
        $data['stocking_batch']=$stocking['stocking_batch'];
        $data['cage_id']=M('cage')->getFieldBycage_id($record['record_cage_id'],'cage_rowname');
        $data['fry_id']=M('fry')->getFieldByfry_id($stocking['stocking_fry_id'],'fry_name');
        $data['stocking_specifications']=$stocking['stocking_specifications'];
        $data['stocking_number']=$stocking['stocking_number'];
        $data['record_weight']=$record['record_weight'];
        $data['record_number']=$record['record_number'];
        $data['die_number']=$data['stocking_number']-$data['record_number'];
        $data['die_weight']=$data['stocking_specifacations']-$data['record_weight'];

        return $data;
    }

    public function adds() {

        if(IS_POST) {

            $userInfo = \Org\Util\User::_getUserInfo();
            $member_id = $userInfo['member_id'];
            $params = I("post.");
            $params['stocking_member_id'] = $member_id;
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

        $params['stocking_fry_id'] = I("get.stocking_fry_id");
        $params['stocking_batch']=I('get.stocking_batch');
        $params['stocking_cage_id']=I('stocking_cage_id');

        if($params['stocking_fry_id']!=0)
            $query['stocking_fry_id']=$params['stocking_fry_id'];
        if($params['stocking_batch']!=null)
            $query['stocking_batch']=$params['stocking_batch'];
        if($params['stocking_cage_id']!=0)
            $query['stocking_cage_id']=$params['stocking_cage_id'];

        $data= $this->where($query)->order('stocking_start_time desc')->select();
        foreach ($data as $key => $value) {
            $cage = $data[$key]['stocking_cage_id'];
            if($cage == '0') {
                $data[$key]['stocking_cage_id'] = '无网箱';
            }
            $data[$key]['stocking_fry_id'] = M('fry')->getFieldByfry_id($data[$key]['stocking_fry_id'],'fry_name');
            $data[$key]['stocking_cage_id'] = M('cage')->getFieldBycage_id($data[$key]['stocking_cage_id'],'cage_rowname');
        }
        return $data;
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
        $Page  = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(2)
        $Page->setConfig('prev',  '上一页');//上一页
        $Page->setConfig('next',  '下一页');//下一页
        $Page->setConfig('first', '<span aria-hidden="true">首页</span>');//第一页
        $Page->setConfig('last',  '<span aria-hidden="true">尾页</span>');//最后一页
        $Page->setConfig ( 'theme', '<li><a>当前%NOW_PAGE%/%TOTAL_PAGE%</a></li>  %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
        $show = $Page->show();
        $data = $this->where("stocking_member_id = $member_id")->limit($Page->firstRow.','.$Page->listRows)->order('stocking_start_time desc')->select();
        foreach ($data as $key => $value) {

            $cage = $data[$key]['stocking_cage_id'];
            if($cage == '0') {
                $data[$key]['stocking_cage_id'] = '无网箱';
            }

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