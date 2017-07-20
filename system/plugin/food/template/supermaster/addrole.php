<style type="text/css">
	.content{
       width:90%;
      margin:0px auto ;
	}
	.contents{
		border:1px solid #f1f1f1;
        width:50%;
       margin:80px auto 0px;
	}	
</style>

<?php include(PLUGIN_PATH . PLUGIN_ID . '/template/supermaster/publictop.php');?>
<div style="min-height: 600px;clear: both;margin-top: 40px;" >
<div class="contents">
<div class="content">
<div class="container-fluid" style="text-align: center;">
	<div class="row-fluid">
		<div class="span12">
			<h3>
				添加权限模块
			</h3>
		</div>
	</div>
</div>
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">模块名</label>
    <input type="email" class="form-control"  placeholder="模块名" id="auth_name">
  </div>
  <div class="form-group">
  <label for="exampleInputEmail1">选择父类</label>
	  <select  class="form-control" id="auth_pid">
		  <option value="0">顶级</option>
		  <?php foreach ($authInfo as $key => $value) {?>
		   <option value="<?php echo $value['id'];?>"><?php echo $value['auth_name']?></option>
		  <?php }?>
	 </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">控制器</label>
    <input type="email" class="form-control"   id="auth_a" placeholder="控制器">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">方法</label>
    <input type="email" class="form-control"   id="auth_c" placeholder="方法">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">全路径</label>
    <input type="email" class="form-control"   id="auth_url" placeholder="全路径">
  </div>
    <div class="form-group">
        <label>是否显示</label>&nbsp;
        显示：<input  type="radio" name="status" checked="checked" value="1"/> &nbsp;&nbsp;不显示：<input  type="radio" name="status" value='0'/>
    </div>
  <p style="margin-left: 50%"><a href="javascript:;" class="btn btn-default" id="submit">保存</a></p>
 
 </form>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
	
	$(function(){
		$('#submit').click(function(){
               var auth_pid = $("#auth_pid").val();
               var auth_name= $("#auth_name").val();
               var auth_a= $("#auth_a").val();
               var auth_c = $("#auth_c").val();
               var auth_url = $("#auth_url").val();
               if (auth_name.length < 2) {
               	  alert('输入模块名格式不对请重新输入'); return false;
               }
               if (auth_a.length < 2) {
               	  alert('输入控制器格式不对请重新输入'); return false;
               }
                if (auth_c.length < 2) {
               	  alert('输入方法名格式不对请重新输入'); return false;
               }
               if ( auth_url.length < 6) {
               	  alert('输入url格式不对请重新输入'); return false;
               }

              var status = $('input:radio[name="status"]:checked').val();
              if (status.length<0) {
                   alert('请选择是否展示'); return false;  
              }
	            var adddata = {}
	            adddata.auth_name = auth_name;
	            adddata.auth_pid = auth_pid;
	            adddata.auth_a = auth_a;
	            adddata.auth_c = auth_c;
              adddata.auth_url = auth_url;
	            adddata.is_show = status;
	            $.post('/index.php?m=admin&c=app&a=module&mod=food&type=doaddrole',adddata,function(re){
	               	if (re.error == 0) {
	               		console.log(re.msg);
                        alert(re.msg);
                        window.location.href='/index.php?m=admin&c=app&a=module&mod=food&type=doroleLidt'
	               	}else{
                        alert(re.msg);
	               	}

	            },'json');
		});
	}); 
</script>
