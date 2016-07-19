<?php
namespace Home\Controller;
use Think\Controller;
class SaleController extends Controller {
    
    private  $userInfo  = array();
    private  $record    = array();
    private  $sale      = array();
    private  $trace     = array();
    private  $fry       = array();
    private  $pool      = array();
    private  $this_pool = array();
    private  $cage      = array();

	public function _initialize(){
  
		  $this->userInfo = \Org\Util\User::_getUserInfo();
          if(empty($this->userInfo)) {
              redirect(U('Home/Index/index'));
          }

          $this->record = D('record')->get();
          $this->sale   = D('sale')->get();
          $this->trace  = D('trace')->get();
          $this->fry    = D('fry')->get();
          $this->pool   = D('pool')->getAll();
          $this->this_pool = D('pool')->get();
          $this->cage   = D('cage')->get();

	}
     
	public function sale(){
        
        date_default_timezone_set('prc');
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
		$name = I('get.name');

        switch ($name) {
             
            case 'record':
                 $data = $this->record;
                 $this->assign('record',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'sale':
                 $data = $this->sale;
                 $this->assign('sale',$data['data']);
                 $this->assign('page', $data['page']);
                break;
            case 'trace':
                 $data = $this->trace;
                 $this->assign('trace',$data['data']);
                 $this->assign('page', $data['page']);  
            break;
            default:
                echo 'name wrong ';
                break;	
        }
        $this->assign('record_data',$this->record['data']);
        $this->assign('sale_data', $this->sale['data']);
        $this->assign('this_pool', $this->this_pool);
        $this->assign('pool',$this->pool);
        $this->assign('fry',$this->fry);
        $this->assign('cage',$this->cage);

        $this->display($name);
	}
    public function querys() {
        $name = I('get.name');
        $data = D($name)->querys();
        $this->ajaxReturn($data);
    }
    public function adds() {
        
        $name = I('get.name');
        $data = D($name)->adds();
     }
     public function getChoose(){

        $data = D(I('get.name'))->getChoose();
        $this->ajaxReturn($data);
     }
     public function modify() {
        
        $result = D(I('get.name'))->modify();
     }
     public function transfer(){
        
        $data = D('cage')->transfer();
        $this->ajaxReturn($data);
     }

     public function traceQr(){
        if (IS_GET) {
            //dump($_GET);exit();
            $name = I('get.name',null);
            $producers = I('get.producers',null);
            $weight = I('get.weight',null);
            $time = I('get.time',null);
            $traceCode = I('get.traceCode',null);

            $data = "扫描结果\n No:".$traceCode."\n 名称:".$name."\n 养殖商:".$producers."\n 捕捞时间:".$time."\n 产品重量:".$weight."\n 溯源链接:http://hdsy.scau.edu.cn/sy.php?no=".$traceCode;
            $this->qr($data);
        }else{
            $this->error('生成二维码失败，请重试！');
        }
     }

     private function qr($data)
      {
            vendor("phpqrcode.phpqrcode");
            // 纠错级别：L、M、Q、H
            //$level = 'L';
            // 点的大小：1到10,用于手机端4就可以了
            //$size = 5;
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            //$path = "images/";
            // 生成的文件名
            //$fileName = $path.$size.'.png';
            $QRcode = new \QRcode();
            $QRcode::png($data, false);
            //echo '<div align="center"><img src="http://hwlbz.scau.edu.cn/aquaticproduct/index.php/Home/Sale/traceQr/kind/%E9%B2%AB%E9%B1%BC.html" height="290" width="290"></div>';
      }

    public function showTraceQr(){
        if(IS_GET){
            $id = I('get.id',null);
            $data['name'] = I('get.name',null);
            $data['producers'] = '海大';
            $data['weight'] = '1KG';
            $data['time'] = date(Ymd);
            $data['traceCode'] = $this->traceCode($id);

            //$data['traceCode'] = '01969209520720171115120810011066011022';
            $this->assign('data',$data);
            $this->display();
        }else{
            $this->error('生成二维码失败，请重试！');
        }
    }

    public function traceCode($trace_id){
        $trace = M('trace')->where(array('id'=>$trace_id))->find();
        $signal1 = '01';//应用标识符2位数字
        $packCode = '9';//包装指示符1位数字
        $company = '6920952';//企业编码，7位数字
        $product = M('fry')->where(array('fry_id'=>$trace['trace_fry_id']))->getField('fry_code');//产品类别品种4位数字
        $spec = '1';//产品规格1位数字
        $checkCode = $this->getCheckCode($packCode,$company,$product,$spec);//检验码1位数字
        $signal2 = '11'; //应用标识符2位数字

        $time = strtotime($trace['trace_finish_time']);
        $date = date('ymd',$time);//出塘日期6位

        $signal3 = '10';//应用标识符2位数字
        $base = M('base')->where(array('base_id'=>$trace['trace_base_id']))->getField('base_code');//基地3位数字
        $pool = M('pool')->where(array('pool_id'=>$trace['trace_pool_id']))->getField('pool_code');//鱼塘3位数字

        $sale = M('sale')->where(array('sale_id'=>$trace['trace_sale_id']))->getField('sale_record_id');
        $record = M('record')->where(array('record_id'=>$sale))->getField('record_cage_id');
        $cage = M('cage')->where(array('cage_id'=>$record))->getField('cage_code');//鱼排3位数字
        //dump($cage);exit();
        $box = '000';//鱼箱3位数字
        $code = $signal1.$packCode.$company.$product.$spec.$checkCode.$signal2.$date.$signal3.$base.$pool.$cage.$box;
        return $code;
    }

    //生成检验码位
    public function getCheckCode($packCode,$company,$product,$spec){
        $pack = intval($packCode);
        $com = intval($company);
        $pro = intval($product);
        $spe = intval($spec);
        $even = 0;//偶数位
        $odd = 0;//奇数位
        for($i=7;$i>0;$i--){
            $a = $com%10;
            if($i%2==0){
                $odd = $odd + $a;
            }else{
                $even = $even + $a;
            }
            $com = $com/10;
        }
        for($i=4;$i>0;$i--){
            $a = $pro%10;
            if($i%2==0){
                $odd = $odd + $a;
            }else{
                $even = $even + $a;
            }
            $pro = $pro/10;
        }
        $c = 10-(($even+$spe+$pack)*3+$odd)%10;
        return $c;
    }

}