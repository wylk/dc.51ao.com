<?php
$xml = file_get_contents('php://input');
file_put_contents('./code.txt', $xml);
$_GET['m'] = 'plugin';
$_GET['cn'] = 'index';
$_GET['id'] = 'food:sit:weixin_qrcode';
include dirname(__FILE__).'/../../index.php';