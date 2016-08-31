<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends Controller {
    public function index(){
        if(IS_GET){
            $no=I('get.no');
            $cage_code=substr($no,-6,3);
            $cage=M('cage')->getfieldBycage_code($cage_code,'cage_id');
            $patrol=D('patrol')->syPatrol($cage);
            $feeding=D('feeding')->syFeeding($cage);
            $medication=D('medication')->syMedication($cage);
            $record=D('record')->syRecord($cage);
            $sale=D('sale')->sySale($record['record_id']);
            $trace=D('trace')->syTrace($sale['sale_id']);
            $this->assign('trace',$trace);
            $this->assign('sale',$sale);
            $this->assign('record',$record);
            $this->assign('patrol',$patrol);
            $this->assign('feeding',$feeding);
            $this->assign('medication',$medication);
            $this->display();
        }
    }

}