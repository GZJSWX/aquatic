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

		$result = D('Base')->getBaseInfo();
     	$this->assign("base_data", $result['data']);
        $this->assign('time', $result['time']);

        $feed = D('feed')->getFeedInfo();
        $fry  = D('fry')->getFryInfo();
        $medicine = D('medicine')->getMedicineInfo();

        $this->assign('feed',$feed);
        $this->assign('fry',$fry);
        $this->assign('medicine',$medicine);
		$this->display();
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

            $data = "扫描结果\n\n 产品名称:".$name."\n 时  间:".$time;
            //$data = "123486dfhuksfuihkishdiauhlg;iahkyuid hsikhjusdhfsdkhfkjah";
            //dump($data);exit();
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
            $data = "扫描结果\n\n 产品名称:".$name."\n 作  用:".$use."\n 时  间:".$time;
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
            //dump($_GET);exit();
            $data['name'] = I('get.name',null);
            $data['time'] = date('Y-m-d');
            $this->assign('data',$data);
            $this->display();
        }else{
            $this->error("生成二维码出错，请重试");
        }

    }

    public function showMedicineQr(){
        if(IS_GET){
            //dump($_GET);exit();
            $data['name'] = I('get.name',null);
            $data['use'] = I('get.use',null);
            $data['time'] = date('Y-m-d');
            $this->assign('data',$data);
            $this->display();
        }else{
            $this->error("生成二维码出错，请重试");
        }

    }

}