<?php include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/header.php';?>
    <!-- main container -->
    <div class="content">

        <!-- settings changer -->
        <div id="pad-wrapper" class="users-list">
            <div class="row header">
                <h3>商品待处理列表</h3>

            </div>
            <?php echo $_SESSION['employee']['id']?>
            <!-- Users table -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" style="text-align: center">
                        <thead >
                            <tr>
                                <th class="col-md-3 sortable">
                                    <span class="line"></span>商品图片
                                </th>
                                <th class="col-md-3 sortable">
                                    <span class="line"></span>商品名称
                                </th>
                                <th class="col-md-3 sortable ">
                                    <span class="line"></span>商品数量
                                </th>
                                 <th class="col-md-3 sortable ">
                                    <span class="line"></span>
                                </th>

                                <th class="col-md-3 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                     <?php

                     if(!empty($data2))
                     {

                        foreach ($data2 as $key => $v):


                      ?>
                        <!-- row -->
                        <tr>
                            <td>
                               <img src="<?php echo $v['goods_img']?>" style="width:50px;height:50px;">
                            </td>
                            <td>
                                <?php echo $v['goods_name']?>
                            </td>
                            <td>
                                <?php echo $v['goods_num']?>
                            </td>

                            <td>
                            <?php if($v['status']==2):?>
                                    已完成
                              <?php else:?>
                              <?php if($v['status']==1):?>
                             <a href="javascript:;">处理中</a>
                              <?php elseif($v['status']==0):?>
                               <a href="javascript:;" class="receive"  data-id="<?php echo $v['order_id']?>" eid="<?php echo $v['id']?>">接单</a>
                               <?php endif;?>
                              |
                              <a href="javascript:;" class="send"  data-id="<?php echo $v['order_id']?>" eid="<?php echo $v['id']?>">出单</a>
                              <?php endif;?>
                            </td>
                        </tr>
                        <!-- row -->
                       <?php endforeach;}else{?>
                        暂无数据
                        <?php };?>
                        </tbody>
                    </table>
                </div>
            </div>
           <?php echo $pagebar;?>
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
       $('.receive').click(function(){
        if(confirm('是否确定接单?')==false)
        {
            return false;
        }
           var order_id = $(this).data('id');
           var postData={order_id:order_id};
           postData.eid=$(this).attr('eid');
           console.log(postData);
           $.post('?m=plugin&p=shop&cn=index&id=food:sit:receive',postData,function(re){

               if (re.error == 0) {
                    alert(re.msg);
                    window.location.reload();
               }else{
                    alert(re.msg);
               }
           },'json');
       });
       $('.send').click(function(){
        if(confirm('是否确定出单?')==false)
        {
            return false;
        }
           var order_id = $(this).data('id');
           var postData={order_id:order_id};
           postData.eid=$(this).attr('eid');
           console.log(postData);
           $.post('?m=plugin&p=shop&cn=index&id=food:sit:do_send_goods',postData,function(re){

               if (re.error == 0) {
                    alert(re.msg);
                    window.location.reload();
               }else{
                    alert(re.msg);
               }
           },'json');
       });
    });
</script>