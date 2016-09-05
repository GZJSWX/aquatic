<?php
/**
 * Created by PhpStorm.
 * User: honor
 * Date: 2016/9/3
 * Time: 18:07
 */

namespace Baseadmin\Controller;

use Think\Controller;

class ChartsController extends Controller
{
    public function index(){

        $this->display();
    }

    public function getData(){
        $data = D('DeviceOnlineT')->getData();
        //dump($data);exit();
        $this->ajaxReturn($data);
    }

}