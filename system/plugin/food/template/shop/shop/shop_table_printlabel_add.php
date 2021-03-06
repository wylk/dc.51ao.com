<?php include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/header.php';?>
    <!-- end navbar -->
<!-- libraries -->
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH;?>css/lib/font-awesome.css">
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="<?php echo FOOD_PATH;?>css/compiled/new-user.css" type="text/css" media="screen" />
    <!-- sidebar -->
<!-- <?php include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/left_menu.php';?> -->
    <!-- end sidebar -->
    <!-- main container -->
    <div class="content">
        
        <!-- settings changer -->
        
        
        <div id="pad-wrapper" class="new-user">

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar" style="border-right: 1px solid #fff;padding-left: 85px">
                    <div class="container">
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="?m=plugin&p=shop&cn=index&id=food:sit:do_shop_table">返回餐桌管理
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">
                标签详细设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="number" name="displayorder" class="form-control" value="0"  placeholder=""/>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">标签名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="" placeholder=""/ style="width: 100%;">
                    </div>
                </div>
                 
            </div>
            <div class="form-group col-sm-12" style="margin-top: 20px;">
                <a href="javascript:;" id="add" class="btn btn-primary col-lg-3">提交</a>
            </div>
        </div>
       
    </form>


</div>
                </div>  
            </div>
        </div>
    </div>
    <!-- end main container -->


    <!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH;?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH;?>js/theme.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#add').click(function(){
              var displayorder = $("input[name='displayorder']").val();
              var title = $('input[name="title"]').val();
              if (displayorder.length<0) {
                alert('排序不能为空');return false;
              }
              if (title.length<0) {
                alert('标签名称不能为空');return false;
              }
              var data = {}
              data.title = title;
              data.displayorder = displayorder;
              console.log(data);
             $.post('./index.php?m=plugin&p=shop&cn=index&id=food:sit:do_shop_table_printlabel_add',data,function(re){
                console.log(re);
                if (re.error == 0) {
                    swal({
                     title: "友情提示！",
                         text: re.msg,
                         type: "success"
                     }, function () {
                            window.location.href='?m=plugin&p=shop&cn=index&id=food:sit:do_shop_table'
                         });
                }else{
                   swal("友情提示！", re.msg,"error")
                }

             },'json');
            });
           
        });
    </script>
</body>
</html>