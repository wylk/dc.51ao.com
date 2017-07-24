<?php
class test extends plugin
{
	public function index()
	{

		echo 1;die;
		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$appid = 'LB06yeov34iw1vs9lo';
		$oaut_url = 'http://test.com?code=userinfo&appid_api='.$appid.'&redirect='.urlencode($url);
		echo $oaut_url;die;
	        	header('Location: ' . $oaut_url);exit;

		//$this->display('test-ucenter');

	}

	public function adduser()
	{
		if (IS_POST) {
			$data = $this->clear_html($_POST);
			$uid = uc_user_register($data['username'], $data['password'], $data['email']);
			$this->dexit($uid);
		}

	}

	public function register()
	{
		if (empty($_SESSION['userinfo'])) {
			$wx_user['appid'] = 'wxcf1349c1fd949597';
	        $wx_user['appSecret'] = '0d5e3d5ee7955e524088291d4fbe7546';
	        require_once(UPLOAD_PATH.'WxUserinfo.class.php');
	        $wxCardPack = new Wxcard($wx_user);
	        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];   
	        $userinfo = $wxCardPack->auth_openid($url);    
	        $_SESSION['userinfo'] = $userinfo;
		}

		$userinfo = $_SESSION['userinfo'];
		$a = json_encode($userinfo);
		file_put_contents('./userinf.text',$a);
		dump($userinfo);
        $id = uc_user_register($userinfo['nickname'],$userinfo['openid'],$userinfo['headimgurl']);
		echo $id;
			

	}

	public function login()
	{
		$a = '{"openid":"ovLImwWT9CUFzIG1DTatSFIdm9E0","nickname":"6","sex":1,"language":"zh_CN","city":"","province":"","country":"BE","headimgurl":"http:\/\/wx.qlogo.cn\/mmhead\/PiajxSqBRaEJRpdqJKphWwyOyR7iaQLRiceDFqSQNZopANtelFOqWyWug\/0","privilege":[]}';
		$data = json_decode($a,true);
		//list($uid, $username, $password, $email) = uc_user_login($data['openid']);
		 $user = uc_user_login_openid($data['openid']);
		 dump($user);
	}

	public function weixing()
	{
		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$appid = 'LB06yeov34iw1vs9lo';
		if(empty($_GET['userinfo'])){

	        if (isset($_GET['openid'])) {
	        	$user = uc_user_login_openid($_GET['openid']);
	        	if($user){
                    $_SESSION['userinfo']['uid'] = $user['uid'];
                    $_SESSION['userinfo']['openid'] = $user['openid'];
                }
	        }else{
		         	$oaut_url = 'https://lepay.51ao.com/pay/api/openid.php?appid_api='.$appid.'&redirect='.urlencode($url);
		        	header('Location: ' . $oaut_url);exit;
	        }
		}

        if (!$user) {
	        if(!$_GET['userinfo']){
	        	$oaut_url = 'https://lepay.51ao.com/pay/api/openid.php?code=userinfo&appid_api='.$appid.'&redirect='.urlencode($url);
	        	header('Location: ' . $oaut_url);exit;

	        }else{
               $userinfo = json_decode(base64_decode($_GET['userinfo']), true);
               if($userinfo['nickname']){
                    $id = uc_user_register($userinfo['nickname'],$userinfo['openid'],$userinfo['headimgurl']);
                    if ($id > 0) {
                    	$_SESSION['userinfo']['uid'] = $id;
                        $_SESSION['userinfo']['openid'] = $userinfo['openid'];
                    }
                }
	        }
        	
        }
       dump($_SEEEION);
		
	}

	public function do_test()
	{

		
		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$appid = 'LB06yeov34iw1vs9lo';
		$oaut_url = 'http://test.com/index.php?code=userinfo&appid_api='.$appid.'&redirect='.urlencode($url);
	        	header('Location: ' . $oaut_url);exit;

	}

	
}