<?php
namespace Superadmin\Controller;
use Think\Controller;
class SafeController extends Controller{
    
    public function _initialize(){
          
          $userInfo = \Org\Util\User::_getUserInfo();
          if(empty($userInfo)) {
              redirect(U('Home/Index/index'));
          }
    }
    public function index() {
        date_default_timezone_set('prc');
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
        $name = I('get.name');
        switch($name) {
            case 'base':
                $result = D('Base')->getBaseInfo();
                $this->assign('base_data', $result['data']);
                break;
            case 'feed':
                $feed = D('feed')->getFeedInfo();
                $this->assign('feed', $feed);
                break;
            case 'fry':
                $fry = D('fry')->getFryInfo();
                $this->assign('fry', $fry);
                break;
            case 'medicine':
                $medicine = D('medicine')->getMedicineInfo();
                $this->assign('medicine', $medicine);
                break;
            default:
                echo 'name wrong ';
                break;
        }

        $this->display($name);

    }

	public function modifyBase() {
        
        $result = D("Base")->modifyBase();
    }
    public function modifyMedicine() {
        
        $result = D("medicine")->modifyMedicine();
    }
    public function modifyFeed() {
        
        $result = D("feed")->modifyFeed();
    }
    public function modifyFry() {
        
        $result = D("fry")->modifyFry();
    }

    public function addBase(){

    	$result = D("base")->addBase();
        $this->ajaxReturn($result);

    }
    
    public function addFeed(){

        $result = D("feed")->addFeed();
    }
    public function addFry(){

        $result = D("fry")->addFry();
    }
    public function addMedicine(){

        $result = D("medicine")->addMedicine();
    }
    public function getChooseBase(){

        $data = D("base")->getChooseBase();
        $this->ajaxReturn($data);
    }
    public function getChooseFeed(){

        $data = D("feed")->getChooseFeed();
        $this->ajaxReturn($data);
    }
    public function getChooseFry(){

        $data = D("fry")->getChooseFry();
        $this->ajaxReturn($data);
    }
    public function getChooseMedicine(){

        $data = D("medicine")->getChooseMedicine();
        $this->ajaxReturn($data);
    }

    public function feedQr(){
        if(IS_GET){
            
            $name = I('get.name',null);
            $time = I('get.time',null);
            $code = I('get.code',null);
            $data = "扫描结果\n\n 产品名称:".$name."\n 时  间:".$time."\n 饲料编码:".$code;
            $this->qr($data);
        }else{
            $this->error('生成二维码出错，请重试');
        }
        
    }

    public function medicineQr(){
        if(IS_GET){
            //dump($_GET);exit();
            $name = I('get.name',null);
            $use = I('get.use',null);
            $time = I('get.time',null);
            $code = I('get.code',null);
            $data = "扫描结果\n\n 产品名称:".$name."\n 作  用:".$use."\n 时  间:".$time."\n 药品编码:".$code;
            //dump($data);exit();
            $this->qr($data);
        }else{
            $this->error('生成二维码出错，请重试');
        }
        
    }

    private function qr($data)
      {
            vendor("phpqrcode.phpqrcode");
            // 纠错级别：L、M、Q、H
            $level = 'L';
            // 点的大小：1到10,用于手机端4就可以了
            $size = 7;
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            //$path = "images/";
            // 生成的文件名
            //$fileName = $path.$size.'.png';
            $QRcode = new \QRcode();
            $QRcode::png($data, false, $level, $size);
      }

    public function showFeedQr(){
        if(IS_GET){
            $data = D('feed')->getChooseFeed();
            //dump($data);exit();
            $data['time'] = date('Y-m-d');
            $this->ajaxReturn($data,'JSON');
//            $this->assign('data',$data);
//            $this->display();
        }else{
            $this->ajaxReturn(0);
        }

    }

    public function showMedicineQr(){
        if(IS_GET){
            $data = D('medicine')->getChooseMedicine();
            //dump($_GET);exit();
            $data['time'] = date('Y-m-d');
            $this->ajaxReturn($data,'JSON');
        }else{
            $this->error("生成二维码出错，请重试");
        }

    }

}