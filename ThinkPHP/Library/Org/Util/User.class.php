<?php 
  namespace Org\Util;
  session_start();
  class User{
  	public static function _setUserInfo($userInfo) {
  		$_SESSION['member_username'] = $userInfo['member_username'];
  		$_SESSION['member_password'] = $userInfo['member_password'];
      $_SESSION['member_id'] = $userInfo['member_id'];
      $_SESSION['member_base_id'] = $userInfo['member_base_id'];
      $_SESSION['member_pool_id'] = $userInfo['member_pool_id'];
  	}
  	public static function _getUserInfo() {
  		if(empty($_SESSION)) {
        return false;
      }
      $userInfo['member_base_id'] = $_SESSION['member_base_id'];
      $userInfo['member_id'] = $_SESSION['member_id'];
  		$userInfo['member_username'] = $_SESSION['member_username'];
  		$userInfo['member_password'] = $_SESSION['member_password'];
      $userInfo['member_pool_id'] = $_SESSION['member_pool_id'];
  		return $userInfo;
  	}
  }