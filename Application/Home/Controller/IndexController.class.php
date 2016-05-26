<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    
    public function index(){
        
        $userInfo = \Org\Util\User::_getUserInfo();
        
        if(empty($userInfo)) {

          $this->display();
        }else {
            $member_role = M('member')->getFieldBymember_id($userInfo['member_id'], 'member_role');
            switch ($member_role) {
                case '1':
                    redirect(U('Superadmin/Index/index'));
                    break;
                case '2':
                    redirect(U('Baseadmin/Index/index'));
                    break;
                case '3':
                    redirect(U('Home/Index/iindex'));
                break;
                default:
                    echo '您的账号有误！请联系管理员';
                    break;
            }
        }
    }
    public function _before_iindex(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    public function iindex(){
        $this->display();
    }
    /**
     * 判断用户类型
     */
    public function login(){

        if(IS_POST) {

        	$params = I('post.');
	    	$radio = $params['user'];
	    	redirect(U("Home/User/login/",array('member_role' => $radio,'member_username'=>$params['member_username'], 'member_password'=>$params['member_password'])));
        }else {
        	echo 'login wrong';
        }
        
    }
    public function logout(){

        session_destroy();
        redirect(U('Home/Index/index'));
    }
    
}