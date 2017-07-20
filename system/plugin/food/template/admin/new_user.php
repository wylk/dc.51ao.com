
<!DOCTYPE html>
<html>
<head>
	<title>创建门店</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/elements.css">
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/icons.css">

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/lib/font-awesome.css">

    <!-- this page specific styles -->
    <link rel="stylesheet" href="<?php echo FOOD_PATH?>css/compiled/new-user.css" type="text/css" media="screen" />


</head>
<body>

    <?php include PLUGIN_PATH.PLUGIN_ID.'/template/admin/public/header.php';?>
    <!-- end navbar -->

    <!-- sidebar -->
    <?php include PLUGIN_PATH.PLUGIN_ID.'/template/admin/public/left.php';?>


	<!-- main container -->
    <div class="content">

        <!-- settings changer -->
        <div class="skins-nav">
            <a href="#" class="skin first_nav selected">
                <span class="icon"></span><span class="text">Default</span>
            </a>
            <a href="#" class="skin second_nav" data-file="css/compiled/skins/dark.css">
                <span class="icon"></span><span class="text">Dark skin</span>
            </a>
        </div>

        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>创建门店</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                        <!-- <form class="new_user_form"> -->
                            <div class="col-md-12 field-box">
                                <label>门店名称:</label>
                                <input class="form-control" type="text" name="shop_name"/>
                            </div>

                            <div class="col-md-12 field-box">
                                <label>门店类型:</label>
                                <div class="ui-select span5">
                                    <select name="type_id" id="se">
                                    <?php if(!empty($data)){
                                        foreach($data as $v):
                                        ?>

                                        <option value="<?php echo $v['id']?>"><?php echo $v['typename']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店状态:</label>
                                <label>
                                <input type="radio" name="shop_status" id="optionsRadios1" value="1" checked>开启
                                  </label>
                                  <label>
                                    <input type="radio" name="shop_status" id="optionsRadios1" value="0">关闭
                                  </label>

                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店公告:</label>
                                <input class="col-md-9 form-control" name="shop_notice" type="text" />
                            </div>

                            <div class="col-md-12 field-box">
                                <label>人均消费:</label>
                                <input class="col-md-9 form-control" type="text" name="cost_per"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店地址:</label>
                                <div class="address-fields">

                                    <input class="form-control" type="text" placeholder="详细地址" name="shop_detail_address" />
                                    <input class="small form-control" type="text" placeholder="省" name="province" />
                                    <input class="small form-control" type="text" placeholder="市" name="city"/>
                                    <input class="small last form-control" type="text" placeholder="区" name="town" />

                                </div>
                            </div>
                            <div class="col-md-12 field-box textarea">
                                <label>门店介绍:</label>
                                <textarea class="col-md-9" name="shop_introduction" id="aa"></textarea>
                                <span class="charactersleft">门店介绍至少10个汉字</span>
                            </div>
                            <div class="col-md-11 field-box actions">
                                <input type="submit" class="btn-glow primary" value="确定创建">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>
                        <!-- </form> -->
                    </div>
                </div>

                <!-- side right column -->
                <div class="col-md-3 form-sidebar pull-right">
                    <div class="btn-group toggle-inputs hidden-tablet">
                        <button class="glow left active" data-input="normal">NORMAL INPUTS</button>
                        <button class="glow right" data-input="inline">INLINE INPUTS</button>
                    </div>
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>
                        Click above to see difference between inline and normal inputs on a form
                    </div>
                    <h6>Sidebar text for instructions</h6>
                    <p>Add multiple users at once</p>
                    <p>Choose one of the following file types:</p>
                    <ul>
                        <li><a href="#">Upload a vCard file</a></li>
                        <li><a href="#">Import from a CSV file</a></li>
                        <li><a href="#">Import from an Excel file</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end main container -->


	<!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/theme.js"></script>

    <script type="text/javascript">
        $(function () {

            // toggle form between inline and normal inputs
            var $buttons = $(".toggle-inputs button");
            var $form = $("form.new_user_form");

            $buttons.click(function () {
                var mode = $(this).data("input");
                $buttons.removeClass("active");
                $(this).addClass("active");

                if (mode === "inline") {
                    $form.addClass("inline-input");
                } else {
                    $form.removeClass("inline-input");
                }
            });
        });
    </script>
</body>
</html>
<script>
    $(function(){
        $(':submit').click(function(){
            var a1=$("input[name='shop_name']").val();
            var a2=$("input[name='shop_notice']").val();
            var a3=$("input[name='cost_per']").val();
            var a4=$("input[name='shop_detail_address']").val();
            // alert(a4);
            // return false;
            var a5=$("input[name='province']").val();
            var a6=$("input[name='city']").val();
            var a7=$("input[name='town']").val();
            var a8=$("#aa").val();
            // alert(a8);
            // return false;
            var a9=$("input:radio:checked").val();
            var a10=$("#se").val();

            if(a1=='')
            {
                alert('门店名称不能为空');
                return false;
            }
            if(a2=='')
            {
                alert('门店公告不能为空');
                return false;
            }
            if(a3=='')
            {
                alert('人均消费不能为空');
                return false;
            }
            if(a4=='')
            {
                alert('门店地址不能为空');
                return false;
            }
            if(a5=='' || a6=='' || a7=='')
            {
                alert('省市区不能为空');
                return false;
            }
            if(a8=='')
            {
                alert('门店简介不能为空');
                return false;
            }
            var postData={shop_name:a1};
            postData.shop_notice=a2;
            postData.cost_per=a3;
            postData.shop_address=a5+'省'+a6+'市'+a7+'区'+a4;
            postData.shop_introduction=a8;
            postData.shop_status=a9;
            postData.type_id=a10;
            console.log(postData);
            $.post('?m=plugin&p=admin&cn=index1&id=food:sit:create_shop',postData,function(re){
                if(re.error==0)
                {
                    alert(re.msg);
                }else
                {
                    alert(re.msg);
                }
            },'json');
        });
    });
</script>