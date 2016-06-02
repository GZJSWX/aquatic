<?php
namespace Home\Controller;
use Think\Controller;
class WechatController extends Controller{
  
  private $appId  = "wx9439cbf94f9235f0";
  private $appSecret = "22fef2fa1ebd5bfc7bad9a691651a125";

  public function index(){

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('cage', D('cage')->get());
        $this->assign('fry',D('fry')->get());
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
        $this->display();
  }
  public function auto_medication(){
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('cage', D('cage')->get());
        $this->assign('fry',D('fry')->get());
        $time = date('Y-m-d H:i', time());
        $this->assign('time',$time);
        $this->display();    
  }
   public function auto_patrol(){
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('cage', D('cage')->get());
        $this->assign('fry',D('fry')->get());
        $time = date('Y-m-d H:i');
        $this->assign('time',$time);
        $this->display();    
  }
  //测试 未完成
  public function savePic(){
        $data['status'] = 0;
        $access_token = $this->getAccessToken();
        $media_id = I('get.serverId');
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$media_id";
        file_put_contents("test.txt", $url);
        $dir_name = "wechat_img";
        $img_path = "Public/uploads/";
        $to_save = "Public/uploads/".$dir_name.date('/Y/m/d/');
        if($this->create_my_file_path($to_save, 0755) !== false) {
          $filename = $this->curl_get_img($url,$to_save); 
          $img = str_replace($img_path, '', $filename);
            if(!empty($filename)){
              $data['status'] = 1;
                $data['pool_img'] = $img;
             }
        }
        $this->ajaxReturn($data);
  }
  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();
    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
    $signature = sha1($string);
    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage;
  }
  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }
  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("jsapi_ticket.json"));
    if ($data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen("jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }
    return $ticket;
  }
  public  function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("access_token.json"));
    if ($data->expire_time < time()) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen("access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }
  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
  }
  /**
 * @name: create_my_file_path
 * @description:建立文件目录
 * @param:目标路径
 * @author: Hongxiaobo
 * @create: 2016-04-10 14:00
 * @return: boolean
 **/
  function create_my_file_path($file_path='' , $mod_num=0777){
    if(empty($file_path)) return false;
    if(file_exists($file_path)) return true;
    return mkdir($file_path,$mod_num,true) ? true : false;
  }
      /**
     * @name:curl_get_img
     * @description:通过响应头来判断，响应头有一个属性 Content-Type ，它就是 mime ，做好 mime 和 文件扩展名的映射，就可以知道文件的扩展名了。
     * @param:$url=图片的URL地址，$to_save=图片保存的目录,如/Data/image/
     * @return:一般返回图片的相对地址，如2014/10/01/a6c624822a1735de1dad8930b4c9c1cc.gif，如果不是图片则返回FALSE
     * @create: 2016-4-10
     * @author: hongxiaobo
     * @demo:$img=save_remote_image('http://www.php100.com/statics/images//php100/logo.gif','/Data/image/');
     */
    function curl_get_img($url = "",$to_save_dir="") {
        $mimes=array(
                'image/bmp'=>'bmp',
                'image/gif'=>'gif',
                'image/jpeg'=>'jpg',
                'image/png'=>'png',
        );
        $headers=@get_headers($url, 1);
        // 获取响应的类型
        $type=$headers['Content-Type'];
        if(isset($mimes[$type])){
            $url = preg_replace( '/(?:^[\'"]+|[\'"\/]+$)/', '', $url );
            $filename= md5(uniqid().$url);
            $ext=$mimes[$type];
            $filename="{$to_save_dir}{$filename}.$ext";
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$url);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
    //      curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
            return $filename;
        }
        return FALSE;
    }
    public function feeding_submit() {
        $data['status'] = 1;
        if(D('feeding')->adds())
          $this->ajaxReturn($data);
        else {
          $data['status'] = 0;
          $this->ajaxReturn($data);
        }

    }
    public function medication_submit() {
        $data['status'] = 1;
        if(D('medication')->adds())
          $this->ajaxReturn($data);
        else {
          $data['status'] = 0;
          $this->ajaxReturn($data);
        }

    }
    public function patrol_submit() {
        $data['status'] = 1;
        if(D('patrol')->adds())
          $this->ajaxReturn($data);
        else {
          $data['status'] = 0;
          $this->ajaxReturn($data);
        }

    }

}