
    <!-- navbar -->
<?php include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/header.php';?>
    <!-- end navbar -->

    <!-- sidebar -->
<!-- <?php include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/left_menu.php';?> -->
    <!-- end sidebar -->
  <style type="text/css">

 .sortable{
     text-align: center;
 }

  .ul1{
   list-style:none;
  }
  .ul1 li {
     border: 1px solid #dae3e9;
     width:70%;
     float: left;
     min-height:40px;
    line-height: 40px
  }
  </style>

	<!-- main container -->
   <div class="content">
        
        <!-- settings changer -->  
        <div id="pad-wrapper" class="users-list">
            <div class="row header">
                <h3>添加角色</h3>
            </div>

            <!-- Users table -->
            <div class="row" style="border:1px solid #dae3e9; min-height: 500px" >
                <div class="col-md-12">
                   <div class="col-md-12 field-box" style="margin-top:30px">
                                <label>角色名</label>
                                <input class="form-control" type="text" / style="width: 46%" id="role_name">
                    </div>
                   <p style="clear:both;"></p>
                    <div  style="border:1px solid #dae3e9; min-height: 500px; margin: 19px 19px;padding-top:20px">
                    <ul class="ul1">
                        <?php foreach ($auth1 as $k => $value) {?>
                        
                            <li style="width:20%;text-align: center;font-size: 16px;">
                               <input name="auth_id[]" type="checkbox" value="<?php echo $value['id'];?>" id='pid' class="id<?php echo  $value['id'];?>"/><?php echo $value['auth_name'];?>
                            </li>
                             
                            <li>
                                <?php foreach ($auth2 as $v) {?> 
                                    <?php if($value['id'] == $v['auth_pid']){?> 
                                        <span style="margin-left: 30px"><input name="auth_id[]" type="checkbox" value="<?php echo $v['id'];?>" onClick="find_fid(<?php echo $value['id'];?>)" id='id<?php echo $value['id'];?>'/><?php echo $v['auth_name']?></span>
                                    <?php }?>
                                <?php }?> 
                            </li>
                             <?php if(($k+1)%2==0){ echo '</ul><ul class="ul1" style="clear:both">';}?>
                        
                         <?php }?>
                    </ul>
                    <div style="clear:both "><a href="javascript:;"   class="btn btn-default" style="margin-top:20px;margin-right: 90px;float: right;" id="add">添加</a></div>
                    </div>
                </div>                
            </div>
            
            <!-- end users table -->
        </div>
    </div>
    <!-- end main container -->


	<!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH;?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH;?>js/theme.js"></script>
</body>
</html>

<script type="text/javascript">
    $(function(){
      var i = 1;
      $('[id=pid]').click(function(){
           var id = $(this).val();
           if($(this).is(":checked")){
             $('[id = id'+id+']').prop('checked', true);
           }else{
             $('[id = id'+id+']').prop('checked', false);
           }
            
      });

       $('#add').click(function(){
           var a1='';
        $('input[name="auth_id[]"]:checked').each(function(){
            a1+=$(this).val()+",";
        });
        if(a1=='')
        {
            alert('至少选择一项');
            return false;
        }
        var role_name = $('#role_name').val();
        if (role_name.length<1) {
            alert('角色名不能太短，请从新添加');return false;
        }
        var data= {}
        data.role_name = role_name;
        data.all_id = a1;
        $.post('./index.php?m=plugin&p=shop&cn=index&id=food:sit:do_employee_role_add',data,function(re){
            console.log(re);
               if (re.error == 0) {
                    alert(re.msg);
                    window.location.href='./index.php?m=plugin&p=shop&cn=index&id=food:sit:do_employee_role';
               }else{
                    alert(re.msg);
               }
           },'json');
       });
       
    });
    function find_fid(id){
          $('.id'+id).prop('checked', true); 
       }
</script>