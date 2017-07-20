<?php

class wxcard

{

	private $wxinfo = '';

	//public $error = array();



    function __construct($wxinfo) {

		$this->wxinfo = $wxinfo;

		

    }

//demo  获取用户微信 信息

 /* public function get_user_openid()

  {

         //判断是不是微信is_weixin()  is_mobile()

      $wx_user['appid'] = '';

      $wx_user['appSecret'] = '';

      $wxCardPack = new Wxcard($wx_user);

  

     $url = "https://lepay.51ao.com/merchants.php?m=Index&c=index&a=addbonus&mid=$b";

     $info_arr = $wxCardPack->auth_openid($url);

      //$this->fanSave($info_arr,$b);

      //header("Location:".WUYI_PATH."merchants.php?m=Index&c=index&a=bonus&mid=$b");die;

  }*/

    public function one_openid($url) 

    {

      

    if (empty($_GET['code'])){

        $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->wxinfo['appid'] . '&redirect_uri=' . urlencode($url) . '&response_type=code&scope=snsapi_base&state=1#wechat_redirect';

        header('Location: ' . $oauthUrl);

        exit;

    } else if (isset($_GET['code'])) {

    //echo $_GET['code'];die;

        $jsonrt = $this->post('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->wxinfo['appid'] . '&secret=' . $this->wxinfo['appSecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');

        $jsonrt = json_decode($jsonrt,true);
        
        if ($jsonrt['errcode'] || empty($jsonrt['openid'])) {

        return array('error' => 1, 'msg' => '授权发生错误：' . $jsonrt['errcode']);

        }

        if ($jsonrt['openid']) {

          $openid = $jsonrt['openid'];

          return array('openid' => $openid);die;        

        }

    } else {

        return array('error' => 2);

    }



    }





     public function auth_openid($url) 

    {

    	

		if (empty($_GET['code'])){
		    //$_SESSION['weixinstate'] = md5(uniqid());
		    $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->wxinfo['appid'] . '&redirect_uri=' . urlencode($url) . '&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
		    header('Location: ' . $oauthUrl);

		    exit;

		} else if (isset($_GET['code'])) {

		//echo $_GET['code'];die;

		    $jsonrt = $this->post('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->wxinfo['appid'] . '&secret=' . $this->wxinfo['appSecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');

        $jsonrt = json_decode($jsonrt,true);

		    if ($jsonrt['errcode'] || empty($jsonrt['openid'])) {

				return array('error' => 1, 'msg' => '授权发生错误：' . $jsonrt['errcode']);

		    }

		    if ($jsonrt['openid']) {

				//$_SESSION['openid'] = $jsonrt['openid'];

				//var_dump($jsonrt);die;

				$access_token=$jsonrt['access_token'];

				$openid = $jsonrt['openid'];

                

				//$userinfo_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";

				$userinfo_url="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";

		        $userinfo_json=$this->post($userinfo_url);

		        $userinfo_array=json_decode($userinfo_json,true);

		        return $userinfo_array;			   		        

                //var_dump($userinfo_array);die;				

		    }

		} else {

		    return array('error' => 2);

		}



    }

   public function GetwxUserInfoByOpenid($wxAccessToken,$openid)
   {     
      $url    = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $wxAccessToken.'&openid='.$openid.'&lang=zh_CN';
      $result = $this->post($url);
      $result = json_decode($result,true); 
      return $result;      
    }

  public function getToken()
  {
      //getToken
        $filename = DOC_ROOT.'caches/common/token/accesstoken';
        echo $filename;die;
      if(!file_exists($filename) || (file_exists($filename) && (time()-filemtime($filename)) > 5000)){
        //1.url地址
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->wxinfo['appid'].'&secret='.$this->wxinfo['appSecret'];
        //2.判断是否为post请求
        //3.发送请求
        $content = $this->post($url);
        //4.处理返回值
        //返回数据格式为json，php不可以直接操作json格式，需要json_decode转化一下
        $content = json_decode($content);
        $access_token = $content->access_token;
        //把access_token保存到文件
        file_put_contents($filename, $access_token);
      }
      //如果没有过期，那么就去读取缓存文件里的access_token
      else{
        $access_token = file_get_contents($filename);
      }
      //把access_token返回
        return $access_token;
    }



    public function post($url)

    {

    // 创建curl对象

    $ch = curl_init ();

    // 配置这个对象

    curl_setopt ($ch, CURLOPT_URL, $url);  // 请求的URL地址

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在



    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  // 返回接口的结果，而不是输出



    // 发出请求

    $data = curl_exec ( $ch );

    if(curl_errno($ch))

    {

        return 'error'.curl_error($ch);

    }

    // 关闭对象

    curl_close ( $ch );

    // 返回数据

    return $data;

    }

}