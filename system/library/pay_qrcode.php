<?php
class pay{

    public function paying($fee,$goods_name,$truename,$appid,$apiSecret,$mch_id,$trade_no)
    {
        $api='https://lepay.51ao.com/pay/api/pay_code.php';
        //构造参数
        $data=[
        'appid'=>$appid,
        'mch_id'=>$mch_id,
        'goods_name'=>$goods_name,
        'out_trade_no'=>$trade_no,
        'total_fee'=>$fee,//单位是分
        'notify_url'=>'http://dc.51ao.com/api/weixin/weixin_qrcode.php',
        'tname'=>$truename,
        'trade_type'=>'weixin',
        ];
        ksort($data);//以键名排序
        $string='';
        foreach($data as $k=>$v)
        {
            $string.="$k=$v&";
        }
        //把秘钥连接到参数上
        $string.='key='.$apiSecret;
        //把链接的字符串全部大写再MD5加密
        $sign=strtoupper(md5($string));
        //把参数和签名放到一起
        $data['sign']=$sign;
        //$a = json_encode($data);
        //exit($a);
        //参数转成xml
        $xml='<xml>';
        foreach($data as $k=>$v)
        {
            $xml.="<$k>$v</$k>";
        }
        $xml.='</xml>';
        // var_dump($xml);
        // die;
        $ret=$this->post($api,$xml);

        return json_decode(json_encode(simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        }


    public function post($url, $data, $isHttps = TRUE)
    {
        // 创建curl对象
        $ch = curl_init ();
        // 配置这个对象
        curl_setopt ( $ch, CURLOPT_URL, $url);  // 请求的URL地址
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        if($isHttps)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt ( $ch, CURLOPT_POST, true);  // 是否是POST请求
        curl_setopt ( $ch, CURLOPT_HEADER, 0);  // 去掉HTTP协议头
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);  // 返回接口的结果，而不是输出
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);  // 提交的数据
        // 发出请求
        $return = curl_exec ( $ch );
        // 关闭对象
        curl_close ( $ch );
        // 返回数据
        return $return;
     }

}
