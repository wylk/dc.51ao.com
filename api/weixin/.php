<?php
// $xml = file_get_contents('php://input');
// file_put_contents('./xml.txt', $xml);
// exit($xml);
$_GET['m'] = 'plugin';
$_GET['cn'] = 'index';
$_GET['id'] = 'food:sit:weixinPay';
include dirname(__FILE__).'/../../index.php';