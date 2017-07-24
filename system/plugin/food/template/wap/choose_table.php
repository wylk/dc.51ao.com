<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title>选桌台</title>
	<style type="text/css">
		*{padding:0; margin: 0; list-style: none; font-size: 1rem;}
		/*头部开始*/
		.header{position:relative;width:100%;height:44px;background:#fff;margin-bottom:1px;}
		.header h1{font-size:16px;color:#333;height:44px;line-height:44px;display:block;text-align:center; font-weight: normal;}
		.header a{position: absolute;top:0;display:block;height:44px;line-height:44px;}
		.header a.back{left:0px;}
		.header a.back span{display:inline-block;width:25px;height:25px;margin:10px 5px;background: url("images/icon/icon-back.png") no-repeat;background-size:100%;}
		/*头部结束*/

		html{width:100%; background: url(<?php echo FOOD_PATH?>wap/img/302.jpg) no-repeat; background-size:100% 100%;  height: 100%; }
		main{ margin: 0 auto;}/*设置居中*/
		/*.main{text-align: center; padding:35px 0; background: #FFF; width:100%; filter:alpha(Opacity=60);-moz-opacity:0.6;opacity: 0.6;}*/
		/*//设置透明度为60%*/
		.minor{width:100%; height: 100%; padding-left: 5px;}
		.minor li{width:80px; height:80px;border:0px solid #E0E; float:left; border-radius: 50%; margin:10px; background:#00FF00; line-height: 80px; text-align: center; background-size:100% 100%;}
		/*.minor li:hover{background: #00FF00}
		.minor li:visited{background: #000;}
		.minor li:active{background: #FF0000;}*/
		.minor li span{color: #FF0000; }


/*a:link{} 未被访问
a:visited{} 已被访问
a:hover{} 鼠标悬浮在上面
a:active{} 鼠标点中激活链接*/
	</style>
</head>
<body>
<!--头部开始-->
<div class="header">  <h1>选桌台</h1>  <a href="javascript:window.history.go(-1);" class="back"><span></span></a>  <a href="#" class=""></a>
</div>
<!--头部结束-->
<main>
	<ul class="minor">
	<?php if(!empty($data1))
	{
		foreach($data1 as $v):
	?>
		<a href="?m=plugin&p=wap&cn=index&id=food:sit:test&shop_id=<?php echo $data['shop_id']?>&table_id=<?php echo $v['id']?>"><li><?php echo $v['id']?><span>空闲</span></li></a>
		<?php endforeach;}else{?>
			暂无数据
		<?php };?>

	</ul>
</main>
</body>
</html>