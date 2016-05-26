<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
   
    public function login(){
        
        $result=D('member')->login();

        if($result['status']) {
        	
        	redirect(U('Home/Safe/index'));
        }else {
            echo '登录失败';
        }

    }
}