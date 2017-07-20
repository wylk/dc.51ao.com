<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<title>点餐系统</title>

<style>
html,body,div,p,form,label,ul,li,dl,dt,dd,ol,img,button,b,em,span,small,h1,h2,h3,h4,h5,h6{margin:0;padding:0;border:0;list-style:none;font-style:normal;}
body{margin: 0 auto;}
a, a.link{color:#666;text-decoration:none;font-weight:500;}
a, a.link:hover{color:#666;}
h1,h2,h3,h4,h5,h6{font-weight: normal;}
.left-menu::-webkit-scrollbar {width: 0px;}
.main{max-width: 100%;}
.left-menu{width:25%;float:left;background-color:#eee;position:relative;overflow-y:scroll;height: 500px;}
.left-menu ul li{line-height:55px;width:100%;text-align:center;font-size:14px;padding:3px 0;color:#333;border-bottom:1px dashed #ddd;}
.left-menu ul li.active{color:#f34b3f !important;background-color:#fff;}
.right-con{display:none;width:75%;float:left;overflow-y:scroll;background:#fff;position:relative;height:500px;}
.con .con-active{display:block;}




.right-con li{position:relative;height:75px;border-bottom:1px solid #e7eaeb;border-top:1px solid #fff;padding-bottom:8px;margin-bottom:2px;}
.right-con li .menu-img{position:absolute;margin-left:10px;top:15px;border-radius:3px;cursor:pointer;}
.right-con li .menu-img img{height:55px;width:55px;vertical-align:middle;border:0;}




.right-con li .menu-txt{margin:15px 15px 15px 75px;}
.right-con li .menu-txt h3{font-size:14px;margin-bottom:10px;margin-top:8px;}
.right-con li .menu-txt p{font-style:normal;line-height:20px;font-size:12px;vertical-align:bottom;}
.right-con li .menu-txt p.list2 b{font-size:14px;color:#f00;}
.right-con li .btn{background-color:transparent;position:absolute;right:0px;top:45%;cursor:pointer;padding:3px;height:38px;}
.right-con li .btn button.minus{margin-right:-10px;display:none;}
.right-con li .btn button{width:40px;height:40px;border:0;background:transparent;padding:0;}
.right-con li .btn button span{padding:5px 10px;font-size:15px;display:inline-block;text-indent:-100px;padding:5px 11px;height:12px;}
.right-con li .btn button.minus span{background:url(<?php echo FOOD_PATH?>/wap/img/down.png) no-repeat;background-size:22px 22px;}
.right-con li .btn i{display:none;width:22px;text-align:center;font-style:normal;vertical-align:top;margin-top:11px;line-height:18px;}
.right-con li .btn button.add{margin-left:-10px;}
.right-con li .btn button.add span{background:url(<?php echo FOOD_PATH?>/wap/img/up.png) no-repeat;background-size:22px 22px;}
.right-con li .btn .price{display:none;}
.footer{display:block;position:fixed;width:100%;z-index:3;bottom:0px;color:#f03c03;background:#fff;line-height:35px;font-size:15px;border-top:1px solid #e2e2e2;}
.footer .left{float:left;margin:5px 10px;}
.footer .right{float:right;}
.footer .right .disable{background:#dbdbdb;}
.footer .xhlbtn{display:block;text-align:center;line-height:45px;background-color:#F03C03;padding:0 15px;color:#fff;font-weight:bold;}
</style>
</head>

<body>
<div class="main">
	<div class="left-menu">
		<ul>
		<?php if(!empty($data))
		{
			foreach($data as $v):
				if($v['default']==1)
				{
					$class="class='active'";
				}else
				{
					$class='';
				}
		?>
           <li <?php echo $class;?>><?php echo $v['cat_name']?><span class="num-price"></span></li>

	    	<?php endforeach;}else{?>
	    		暂无数据
	    	<?php };?>
        </ul>
	</div>
	<div class="con">

<!-- 第一个菜单 -->
	<?php if(!empty($data)){


		foreach($data as $kk => $vv){?>


		<div <?php if(($kk+1) == 1){ echo 'class="right-con con-active"';}else{ echo 'class="right-con"';}?>>
		<ul>
		<?php foreach ($data1 as $key => $v1) {?>

             <?php if($vv['id'] == $v1['cat_id']){?>

				<li>
					<div class="menu-img"><img src="<?php echo $v1['goods_img']?>"/></div>
					<div class="menu-txt">

						<h4><?php echo $v1['goods_name']?></h4>
						<p class="list1"><?php echo $v1['cat_name']?></p>
						<p class="list2">
							<b>￥<?php echo $v1['goods_price'];?></b>
							<div class="btn">
								 <button class="minus" data-id="<?php echo $v1['id']?>">
									 <span></span>
								 </button>
								 <i id="number">0</i>
								  <button class="add" data-id="<?php echo $v1['id']?>">
									 <span></span>
								 </button>
								 <i class="price"><?php echo $v1['goods_price']?></i>
							 </div>
						</p>
					</div>
				</li>
          <?php } } ?>
          </ul>
		</div>
		<?php }}else{?>
			暂无数据
		<?php };?>

	</div>
	<div class="footer">
		<div class="left">已选：
		<span id="cartN">
			<span id="totalcountshow">0</span>份　总计：￥<span id="totalpriceshow">0</span></span>元
		</div>
		<span  id=aa></span>
		<div class="right">
			<a id="btnselect" class="xhlbtn" href="?m=plugin&p=wap&cn=index&id=food:sit:cart_index">选好了</a>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo FOOD_PATH;?>/wap/js/jquery.min.js"></script>
<!-- <script>
	$(function(){
		$('#btnselect').click(function(){
			var total=$("#totalpriceshow").html();
			var gid=$('#aa').html();
			var num=$("#totalcountshow").html();
			var postData={total:total};
			postData.gid=gid;
			postData.num=num;
			console.log(postData);
			$.get('?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7',postData,function(re){
				if(re.error==0)
				{
					console.log(re.msg);
					window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
				}else
				{
					console.log(re.msg);
				}
			},'json');
		});
	});
</script> -->
<script type="text/javascript">
$(function () {
	//加的效果
	$(".add").click(function () {
		$(this).prevAll().css("display", "inline-block");
		var n = $(this).prev().text();
		var num = parseInt(n) + 1;
		if (num == 0) { return; }
		$(this).prev().text(num);

		var danjia = $(this).next().text();//获取单价

		// console.log(danjia);
		var a = $("#totalpriceshow").html();//获取当前所选总价

		$("#totalpriceshow").html((a * 1 + danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量

		var c=$("#totalcountshow").html(nm*1+1);
		var gid=$(this).data('id');
		// alert(gid);

		var postData={goods_id:gid};
		postData.goods_price=danjia;
		postData.num=num;
		console.log(postData);
		// return false;
		$.get('?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=7&shop_id=7',postData,function(re){
			if(re.error==0)
			{
				console.log(re.msg);
				// window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
			}else
			{
				console.log(re.msg);
			}
		},'json');
		jss();//<span style='font-family: Arial, Helvetica, sans-serif;'></span>   改变按钮样式
	});

	//减的效果
	$(".minus").click(function () {
		var n = $(this).next().text();
		var num = parseInt(n) - 1;

		$(this).next().text(num);//减1

		var danjia = $(this).nextAll(".price").text();//获取单价
		var a = $("#totalpriceshow").html();//获取当前所选总价
		$("#totalpriceshow").html((a * 1 - danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量
		$("#totalcountshow").html(nm * 1 - 1);
		//如果数量小于或等于0则隐藏减号和数量
		if (num <= 0) {
			$(this).next().css("display", "none");
			$(this).css("display", "none");
			jss();//改变按钮样式
			 return
		}
		var gid=$(this).data('id');
		var postData={goods_id:gid};
		postData.goods_price=danjia;
		postData.num=num;
		console.log(postData);
		$.get('?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=7&shop_id=7',postData,function(re){
			if(re.error==0)
			{
				console.log(re.msg);
				// window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
			}else
			{
				console.log(re.msg);
			}
		},'json');

	});
	function jss() {
		var m = $("#totalcountshow").html();
		if (m > 0) {
			$(".right").find("a").removeClass("disable");
		} else {
		   $(".right").find("a").addClass("disable");
		}
	};
	//选项卡
	$(".con>div").hide();
	$(".con>div:eq(0)").show();

	$(".left-menu li").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		var n = $(".left-menu li").index(this);
		$(".left-menu li").index(this);
		$(".con>div").hide();
		$(".con>div:eq("+n+")").show();
	});
});
</script>

</body>
</html>
