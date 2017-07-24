<?php
  header("Content-type: text/html; charset=utf-8");
  class index extends plugin{
  public $c = '';
  public $mid = '';
  public function _initialize()
  {

    parent::_initialize();
    $id = $_GET['id'];
    $action = $_GET['cn'];
    list($id,$module,$c) = explode(':', $id);
    $this->c =  $c;

    if (isset($_GET['store_id'])) {

      $_SESSION['employee']['shop_id']= $_GET['store_id'];
      $this->mid  = $_SESSION['employee']['shop_id'];
    }else{
      $this->mid = $_SESSION['employee']['shop_id'];

    }

    if ($_SESSION['cid']) {
      $cid = $_SESSION['cid'];
      if (!model('shop')->where(array('company_id'=>$cid,'id'=>$this->mid))->find()) {
          echo "<script>alert('非法访问！');window.history.go(-1);</script>";die;
      }

    }

    $nowAC = $action.'-'.$c;
    if (empty($_SESSION['employee']) && empty($_SESSION['cid'])) {
      echo   '<script type="text/javascript"> window.top.location.href = "?m=plugin&p=public&cn=index&id=food:sit:manager";</script>';
    }else{

        if (isset($_SESSION['employee']) && $_SESSION['employee']['role_id'] != 0) {
            $role= model('store_role')->where(array('store_id'=>$this->mid,'id'=>$_SESSION['employee']['role_id']))->find();
        }
        $allAC = "index-doindex,index-left_menu";
        if (strpos($role['role_auth_ac'],$nowAC) === false && strpos($allAC,$nowAC) === false && $_SESSION['employee']['role_id'] != 0 && empty($_SESSION['cid']) ){
            echo "<script>alert('非法访问！');window.history.go(-1);</script>";die;
        }
    }

    }
    public function test111()
    {

      $data=model('food_order')->field('status')->where(array('id'=>208))->find();
      dump($data);
    }
    public function do_entrance_waiter()
    {
      dump($_SESSION);
      //手机端
      $data1=model('food_shop_tables')->where(array('status'=>0,'shop_id'=>$this->mid))->select();
      $this->displays('choose_table',array('data1'=>$data1));
    }
    public function do_send_goods()
    {
      //出单
      if(IS_POST)
      {
        $data=$this->clear_html($_POST);
        // $data2=model('food_order')->data(array('print_status'=>3))->where(array('id'=>$data['order_id']))->save();
        //  $this->dexit(array('error'=>1,'msg'=>$data2));
        //更改订单商品表状态
        $data1=model('food_order_goods')->data(array('status'=>2))->where(array('id'=>$data['eid']))->save();
        $data2=model('food_order')->where(array('id'=>$data['order_id']))->find();

        //订单表状态改为已接单
        if($data1)
        {
          if($data2['goods_num']==1)
          {
            //更改订单表状态
            $data2=model('food_order')->data(array('print_status'=>3))->where(array('id'=>$data['order_id']))->save();
          }else
          {
            //商品数量大于2时，循环遍历所有的商品订单表 状态全部为2的更改订单表
            $data3=model('food_order_goods')->where(array('order_id'=>$data['order_id'],'status'=>2))->count();
            // $this->dexit(array('error'=>1,'msg'=>$data3));
            if($data3==$data2['goods_num'])
            {
              //更改订单表状态
              $data2=model('food_order')->data(array('print_status'=>3))->where(array('id'=>$data['order_id']))->save();
            }
          }
        }

        if($data1)
        {

            $this->dexit(array('error'=>0,'msg'=>'出单成功'));
        }else
        {
            $this->dexit(array('error'=>1,'msg'=>'出单失败，请稍后再试'));
        }
      }

    }
    public function receive()
    {
      if(IS_POST)
      {
        $data=$this->clear_html($_POST);
        // $this->dexit(array('error'=>1,'msg'=>$data['eid']));
        //更改订单商品表状态
        $data1=model('food_order_goods')->data(array('status'=>1))->where(array('id'=>$data['eid']))->save();
        //订单表状态改为已接单
        $data2=model('food_order')->data(array('print_status'=>2))->where(array('id'=>$data['order_id']))->save();
        if($data1)
        {

            $this->dexit(array('error'=>0,'msg'=>'接单成功'));
        }else
        {
            $this->dexit(array('error'=>1,'msg'=>'接单失败，请稍后再试'));
        }
      }
    }
    public function do_entrance_cook()
    {

       $role_id=$_SESSION['employee']['role_id'];
       $data=model('store_role')->field('cat_id')->where(array('id'=>$role_id))->find();
       $cat_id=explode(',', $data['cat_id']);
       $cat_id_all=model('food_cat')->field('id')->where(array('shop_id'=>$this->mid))->select();
       $cid_all=$this->arr2_arr1($cat_id_all,'id');

        $data1=model('food_order')->query('select * from hd_food_order where status=2 and print_status in(0,1,2)');

        foreach($data1 as $v)
        {
          $data1['test'][]=model('food_order_goods')->query('select a.*,b.goods_name,b.cat_id,b.goods_img from hd_food_order_goods as a  left join hd_food_goods as b on a.goods_id=b.id where a.order_id='.$v['id']);
        }
        $data2=[];
        if($_SESSION['phone'] || $_SESSION['employee']['role_id']==0)
        {

            //店长或经理登录
          foreach($data1['test'] as $v)
          {
              foreach($v  as $k => $v1)
              {
                  if(in_array($v1['cat_id'],$cid_all))
                  {
                      $data2[]=array('goods_id'=>$v1['goods_id'],'goods_num'=>$v1['goods_num'],'goods_name'=>$v1['goods_name'],'goods_img'=>$v1['goods_img'],'order_id'=>$v1['order_id'],'id'=>$v1['id'],'status'=>$v1['status']);
                  }
              }
          }
        }elseif($_SESSION['employee']['role_id']!=0 && empty($_SESSION['cid']))
        {
            //员工登陆
          foreach($data1['test'] as $v)
          {
              foreach($v  as $k => $v1)
              {
                  if(in_array($v1['cat_id'],$cat_id))
                  {
                      $data2[]=array('goods_id'=>$v1['goods_id'],'goods_num'=>$v1['goods_num'],'goods_name'=>$v1['goods_name'],'goods_img'=>$v1['goods_img'],'order_id'=>$v1['order_id'],'id'=>$v1['id'],'status'=>$v1['status']);
                  }
              }
          }
        }
        dump($data2);
       $this->displays('do_entrance_cook',array('data2'=>$data2));
    }
  public function arr2_arr1($arrdata,$v)
  {
    $arrs = array();
    foreach ($arrdata as $key => $value) {
      $arrs[] = $value[$v];
    }
    return $arrs;
  }
    public function do_ntrance()
    {
       $_count=model('store_role')->where(array('store_id'=>$this->mid))->count();
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count, 10);
      $pagebar = $p->show(10);
        $role = model('store_role')->where(array('store_id'=>$this->mid))->limit($p->firstRow,$p->listRows)->select();
        $this->displays('ntrance',array('role'=>$role,'pagebar'=>$pagebar));
    }
    public function edit_cat_id()
    {
      //分配商品分类权限
      $role_id=$this->clear_html($_GET);

      $data=model('food_cat')->where(array('shop_id'=>$this->mid))->select();
      $cat_auth=model('store_role')->field('cat_id')->where(array('id'=>$role_id['role_id']))->find();
      $cat_auth=explode(',',$cat_auth['cat_id']);

      if(IS_POST)
      {

        $data=$this->clear_html($_POST);

        $data1=model('store_role')->data(array('cat_id'=>$data['cat_id']))->where(array('id'=>$data['role_id']))->save();
        if($data1)
        {
          $this->dexit(array('error'=>0,'msg'=>'操作成功'));
        }else
        {
          $this->dexit(array('error'=>1,'msg'=>'操作失败'));
        }
      }
      $this->displays('edit_cat_id',array('cat_auth'=>$cat_auth,'data'=>$data,'role_id'=>$role_id['role_id']));
    }
    public function do_order_paid()
    {
      $data=model('food_order')->query('select a.*,b.title from hd_food_order as a left join hd_food_shop_tables as b on a.table_id=b.id where a.shop_id='.$this->mid.' and a.status=3');
      $this->displays('do_order_paid',array('data'=>$data));
    }
    public function do_order_edit()
    {
      $data=$this->clear_html($_GET);
      $data2=model('food_order')->where(array('id'=>$data['order_id']))->find();
      $data1=model('food_order_goods')->query('select a.*,b.goods_name,b.goods_img,c.cook from hd_food_order_goods as a left join hd_food_goods as b on a.goods_id=b.id left join hd_food_goods as c on c.id=a.goods_id where order_id='.$data['order_id']);
      $this->displays('do_order_edit',array('data1'=>$data1,'data2'=>$data2));
    }
    public function do_order_unpay()
    {
      //订单列表
      $data=model('food_order')->query('select a.*,b.title from hd_food_order as a left join hd_food_shop_tables as b on a.table_id=b.id where a.shop_id='.$this->mid.' and a.status between 1 and 2');
      $this->displays('do_order_unpay',array('data'=>$data));
    }
    public function do_spec_del()
    {
      $data=$this->clear_html($_GET);
      $data1=model('food_spec')->where(array('id'=>$data['del_id']))->delete();
      if($data1)
      {
        $this->dexit(array('error'=>0,'msg'=>'删除成功'));
      }else
      {
        $this->dexit(array('error'=>1,'msg'=>'删除失败，请稍后再试'));
      }

    }
    public function do_spec_edit()
    {
      //修改商品规格
      $data=$this->clear_html($_GET);
      $data1=model('food_spec')->where(array('id'=>$data['cid']))->find();
      if(IS_POST)
      {
        $data2=$this->clear_html($_POST);
        $datas=[];
        foreach($data2['spec_value'] as $key=>$value)
        {
          foreach($data2['proportion'] as $k=>$v)
          {
            if($key==$k)
            {
              $datas[]=array('id'=>$key,'spec_name'=>$value,'proportion'=>$v);
            }
          }
        }
          $data2['spec_value']=json_encode($datas);
          $data2['shop_id']=$this->mid;
          unset($data2['proportion']);
          $return=model('food_spec')->data($data2)->where(array('id'=>$data2['cid']))->save();
          if($return)
          {
              echo "<script>alert('修改成功');history.go(-1);</script>";
              die;
          }else
          {
              echo "<script>alert('修改失败，请稍后再试');history.go(-1);</script>";
              die;
          }
      }
      $this->displays('do_spec_edit',array('data1'=>$data1));
    }
    public function do_goods_spec()
    {
       if(IS_POST)
      {
        $data1=$this->clear_html($_POST);
        if($data1['spec_name'])
        {
          $_SESSION['spec_name']=$data1['spec_name'];
          $where=' and spec_name like "%'.$_SESSION['spec_name'].'%"';
          $data2=model('food_spec')->where(array('spec_name'=>$_SESSION['spec_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
          unset($_SESSION['spec_name']);
        }

      }
      if($_GET['page'])
      {
        if($_SESSION['spec_name'])
        {
          $where=' and spec_name like "%'.$_SESSION['spec_name'].'%"';
          $data2=model('food_spec')->where(array('spec_name'=>$_SESSION['spec_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
          unset($_SESSION['spec_name']);
        }
      }
      //规格列表
      $shop_id=$this->mid;
      $_count=model('food_spec')->query('select count(*) as c from hd_food_spec where shop_id='.$shop_id.$where);
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count[0]['c'], 10);
      $pagebar = $p->show(10);

      $data=model('food_spec')->query('select * from hd_food_spec where shop_id='.$shop_id.$where.' order by sort desc limit '.$p->firstRow.','.$p->listRows);
      $this->displays('do_goods_spec',array('data'=>$data,'pagebar'=>$pagebar,'data2'=>$data2));
    }
    public function do_spec_add()
    {
      $shop_id=$this->mid;
      if(IS_POST)
      {
        $data=$this->clear_html($_POST);
        $data['shop_id']=$shop_id;
        $data['addtime']=time();
        $datas = [];
        foreach ($data['spec_value'] as $key => $value) {
          foreach ($data['proportion'] as $k => $v) {
             if ($key == $k) {
                $datas[] = array('id'=>$key,'spec_name'=>$value,'proportion'=>$v);
             }
          }
        }
        $data['spec_value'] = json_encode($datas);
        $return=model('food_spec')->data($data)->add();
        if($return)
        {
          echo "<script>alert('添加成功');history.go(-1);</script>";
          die;
        }else
        {
          echo "<script>alert('添加失败，请稍后再试');history.go(-1);</script>";
          die;
        }
      }
      $this->displays('do_spec_add');
    }
    public function do_cat_edit()
    {
      $data=$this->clear_html($_GET);
      $data1=model('food_cat')->where(array('id'=>$data['cid']))->find();
      $data2=model('food_cat')->where(array('shop_id'=>$this->mid,'pid'=>0))->select();
      if(IS_POST)
      {
        $data3=$this->clear_html($_POST);
        $data4=model('food_cat')->data($data3)->where(array('id'=>$data3['cid']))->save();
        if($data4)
        {
          $this->dexit(array('error'=>0,'msg'=>'修改成功'));
        }else
        {
          $this->dexit(array('error'=>1,'msg'=>'修改失败，请稍后再试'));
        }
      }
      $this->displays('do_cat_edit',array('data1'=>$data1,'data2'=>$data2));
    }
    public function do_cat_del()
    {
      //删除分类
      $data=$this->clear_html($_GET);
      $return=model('food_cat')->where(array('id'=>$data['del_id']))->delete();
      if($return)
      {
        $this->dexit(array('error'=>0,'msg'=>'删除成功'));
      }else
      {
        $this->dexit(array('error'=>1,'msg'=>'删除失败，请稍后再试'));
      }
    }
    public function do_goods_cat()
    {
      if(IS_POST)
      {
        $data2=$this->clear_html($_POST);
        if($data2['cat_name'])
        {
          $_SESSION['cat_name']=$data2['cat_name'];
          $where=' and cat_name like "%'.$_SESSION['cat_name'].'%"';
          $data3=model('food_cat')->where(array('cat_name'=>$_SESSION['cat_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
          unset($_SESSION['cat_name']);
        }

      }
      if($_GET['page'])
      {
        if($_SESSION['cat_name'])
        {
          $where=' and cat_name like "%'.$_SESSION['cat_name'].'%"';
          $data3=model('food_cat')->where(array('cat_name'=>$_SESSION['cat_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
            unset($_SESSION['cat_name']);
        }
      }
      $shop_id=$this->mid;
      $_count=model('food_cat')->query('select count(*) as c from hd_food_cat where shop_id='.$shop_id.$where);
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count[0]['c'], 10);
      $pagebar = $p->show(10);
      $data1=model('food_cat')->field('id,cat_name,pid')->where(array('shop_id'=>$shop_id,'pid'=>0))->select();
      $data=model('food_cat')->query('select * from hd_food_cat where shop_id='.$shop_id.$where.' order by sort desc limit '.$p->firstRow.','.$p->listRows);
      // $sql='select * from hd_food_cat where shop_id='.$shop_id.$where.' order by sort desc limit '.$p->firstRow.','.$p->listRows;
      // echo $sql;
      // $data4=[];
      // foreach($data as $v1)
      // {
      //   if($v1['pid']==0)
      //   {
      //     $data4=$this->GetTree($data,0,0);
      //   }else
      //   {
      //     $data4=$this->GetTree($data,$v1['pid'],0);
      //   }

      // }

       // dump($data4);
      // die;
      $this->displays('do_goods_cat',array('data'=>$data,'data1'=>$data1,'pagebar'=>$pagebar,'data3'=>$data3));
    }

    public function cat_add()
    {
      //添加商品分类
      $shop_id=$this->mid;
      $data=model('food_cat')->where(array('shop_id'=>$shop_id,'pid'=>0))->select();
      if(IS_POST)
      {
        $data=$this->clear_html($_POST);
        $data['shop_id']=$shop_id;
        $data['addtime']=time();

        $return=model('food_cat')->data($data)->add();
        if($return)
        {
          $this->dexit(array('error'=>0,'msg'=>'添加成功'));
        }else
        {
          $this->dexit(array('error'=>0,'msg'=>'添加失败，请稍后再试'));
        }
      }
      $this->displays('cat_add',array('data'=>$data));
    }
    public function do_goods_del()
    {
      $data=$this->clear_html($_GET);
      $return=model('food_goods')->where(array('id'=>$data['del_id']))->delete();
      if($return)
      {
        $this->dexit(array('error'=>0,'msg'=>'删除成功'));
      }else
      {
        $this->dexit(array('error'=>1,'msg'=>'删除失败，请稍后再试'));
      }
    }
    public function do_goods_edit()
    {
      $data=$this->clear_html($_GET);
      $data1=model('food_goods')->where(array('id'=>$data['cid']))->find();
      $data2=model('food_cat')->where(array('shop_id'=>$this->mid))->select();

      $data3=model('food_spec')->where(array('shop_id'=>$this->mid))->select();
      $phone=model('employee')->query('select b.phone from hd_employee as a left join hd_company as b on a.company_id=b.id where a.shop_id='.$this->mid);

      if(IS_POST)
      {
        $data4=$this->clear_html($_POST);

        $result=$this->file_upload($phone[0]['phone']);
        if($result)
        {
          unlink($data1['goods_img']);
          $data4['goods_img']=$result['goods_img'];
        }
        $data4['suppy_time']=implode(',',$data4['suppy_time']);
        // dump($data4);
        // die;
        $return=model('food_goods')->data($data4)->where(array('id'=>$data4['cid']))->save();
        if($return)
        {
          echo "<script>alert('修改成功');history.go(-1);</script>";
          die;
        }else
        {
          echo "<script>alert('修改失败，请稍后再试');history.go(-1);</script>";
          die;
        }

      }
      $this->displays('do_goods_edit',array('data'=>$data,'data1'=>$data1,'data2'=>$data2,'data3'=>$data3));

    }
    public function do_goods_list()
    {
      if(IS_POST)
      {
        $data1=$this->clear_html($_POST);
        if($data1['goods_name'])
        {
          $_SESSION['goods_name']=$data1['goods_name'];
          $where=' and goods_name like "%'.$_SESSION['goods_name'].'%"';
          $data2=model('food_goods')->where(array('goods_name'=>$_SESSION['goods_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
          unset($_SESSION['goods_name']);
        }

      }
      if($_GET['page'])
      {
        if($_SESSION['goods_name'])
        {
          $where=' and goods_name like "%'.$_SESSION['goods_name'].'%"';
          $data2=model('food_goods')->where(array('goods_name'=>$_SESSION['goods_name'],'shop_id'=>$this->mid))->find();
        }else
        {
          $where='';
          unset($_SESSION['goods_name']);
        }
      }

      $_count=model('food_goods')->query('select count(*) as c from hd_food_goods where shop_id='.$this->mid.$where);
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count[0]['c'], 10);
      $pagebar = $p->show(10);
      $data=model('food_goods')->query('select * from hd_food_goods where shop_id='.$this->mid.$where.' order by goods_sort desc limit '.$p->firstRow.','.$p->listRows);

      $this->displays('do_goods_list',array('data'=>$data,'pagebar'=>$pagebar,'data2'=>$data2));
    }
    public function do_goods_add()
    {
      $data=model('food_cat')->where(array('shop_id'=>$this->mid))->select();
      $data=$this->GetTree($data,0,0);
      // dump($data);
      // die;
      $data1=model('food_spec')->query('select spec_name,id from hd_food_spec where shop_id='.$this->mid.' order by sort desc');
       $phone=model('employee')->query('select b.phone from hd_employee as a left join hd_company as b on a.company_id=b.id where a.shop_id='.$this->mid);
      if(IS_POST)
      {
        $data2=$this->clear_html($_POST);
        // dump($data2);
        // die;
        $data2['shop_id']=$this->mid;
        $data2['addtime']=time();
        $result=$this->file_upload($phone[0]['phone']);
        if($result!='')
        {
          $data2['goods_img']=$result['goods_img'];
        }
        $data2['suppy_time']=implode(',',$data2['suppy_time']);

        $return=model('food_goods')->data($data2)->add();
        if($return)
        {
          echo "<script>alert('添加成功');history.go(-1)</script>";
          die;
        }else
        {
          echo "<script>alert('添加失败，请稍后再试');history.go(-1);</script>";
          die;
        }
      }
      $this->displays('do_goods_add',array('data'=>$data,'data1'=>$data1));
    }
    public function doindex()
    {
      // echo $_SESSION['employee']['id'];
      // die;
         $this->displays('index');
    }


    public function left_menu()
    {
        if (isset($_SESSION['cid']) || $_SESSION['employee']['role_id'] == 0) {
            $authInfoA = model('store_auth')->where(array('auth_level'=>0,'is_show'=>1))->select();
            $authInfoB = model('store_auth')->where(array('auth_level'=>1,'is_show'=>1))->select();
        }else{
            $role= model('store_role')->where(array('store_id'=>$this->mid,'id'=>$_SESSION['employee']['role_id']))->find();
            $authInfoA = model('store_auth')
                    ->where(array(
                        'auth_level'=>0,
                        'is_show'=>1,
                        'id'=>array('in',$role['role_auth_ids'])))
                    ->select();

            //var_dump($authInfoA);die
            $authInfoB = model('store_auth')
                    ->where(array(
                        'auth_level'=>1,
                        'is_show'=>1,
                        'id'=>array('in',$role['role_auth_ids'])))
                    ->select();
        }
        $c = $this->c;
        include PLUGIN_PATH.PLUGIN_ID.'/template/shop/public/left_menu.php';
    }
    //员工列表
    public function do_employee_list()
    {
      $_count=model('employee')->where(array('shop_id'=>$this->mid,'status'=>array(' in','0,1'),'role_id'=>array('neq',0)))->count();
      // echo $_count;
      // die;
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count, 10);
      $pagebar = $p->show(10);
         $employees = model('employee')->where(array('shop_id'=>$this->mid,'status'=>array(' in','0,1'),'role_id'=>array('neq',0)))->limit($p->firstRow,$p->listRows)->select();
         // dump($employees);
         // die;
         foreach ($employees as $key => &$v) {
            $roles = model('store_role')->where(array('store_id'=>$this->mid,'id'=>$v['role_id']))->find();
            $v['role_name'] = $roles['role_name'];
         }
        $this->displays('employee_list',array('employees'=>$employees,'pagebar'=>$pagebar));
    }
   //删除员工
    public function do_empolyee_del()
    {
        $id = $this->clear_html($_GET['del_id']);
        $sql = 'select a.role_id from hd_employee as a Left Join hd_store_role as b on a.role_id=b.id where a.id='.$id;
        $datas = model('employee')->query($sql);

        if ($datas[0]['role_id'] == 0) {
            $this->dexit(array('error'=>1,'msg'=>'店长不能删除'));
        }

        if (model('employee')->data(array('status'=>2))->where(array('id'=>$id))->save()) {
           $this->dexit(array('error'=>0,'msg'=>'删除成功'));
        }else{
        $this->dexit(array('error'=>1,'msg'=>'删除失败'));
        }

    }
    //编辑员工
    public function do_employee_edit()
    {   if (IS_POST) {
            $data = $this->clear_html($_POST);

            $employee = model('employee')->where(array('truename'=>$data['truename'],'status'=>array('in','0,1'),'id'=>array('neq',$data['employee_id'])))->select();
            if ($employee) {
               $this->dexit(array('error'=>1,'msg'=>'真实姓名也存在'));
            }

            $employee1 = model('employee')->where(array('username'=>$data['username'],'status'=>array('in','0,1'),'id'=>array('neq',$data['employee_id'])))->select();
            if ($employee1) {
               $this->dexit(array('error'=>1,'msg'=>'登录账号也存在'));
            }

            $employee2 = model('employee')->where(array('phone'=>$data['phone'],'status'=>array('in','0,1'),'id'=>array('neq',$data['employee_id'])))->select();
            if ($employee2) {
               $this->dexit(array('error'=>1,'msg'=>'手机号码也存在'));
            }

            $employee3 = model('employee')->where(array('email'=>$data['email'],'status'=>array('in','0,1'),'id'=>array('neq',$data['employee_id'])))->select();
            if ($employee3) {
               $this->dexit(array('error'=>1,'msg'=>'邮箱号码也存在'));
            }

            $id = $data['employee_id'];
            unset($data['employee_id']);
            if ($data['password'] == '') {
              unset($data['password']);
            }else{
              $data['password'] = md5($data['password']);
            }

            if (model('employee')->data($data)->where(array('shop_id'=>$this->mid,'status'=>array(' in','0,1'),'id'=>$id))->save()) {
               $this->dexit(array('error'=>0,'msg'=>'修改成功'));
            }else{
                $this->dexit(array('error'=>1,'msg'=>'修改失败'));
            }


        }
        $id = $this->clear_html($_GET['employee_id']);
        $employee = model('employee')->where(array('shop_id'=>$this->mid,'status'=>array(' in','0,1'),'id'=>$id))->find();
        $roles = model('store_role')->where(array('store_id'=>$this->mid))->order('id desc')->select();
        $this->displays('employee_edit',array('employee'=>$employee,'roles'=>$roles));
    }
   //添加员工
    public function do_employee_add()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $data['shop_id'] = $this->mid;
            $data['remark'] = '员工';
            // $this->dexit(array('error'=>1,'msg'=>$data));
            $employee = model('employee')->where(array('truename'=>$data['truename'],'status'=>array('in','0,1')))->select();
            if ($employee) {
               $this->dexit(array('error'=>1,'msg'=>'真实姓名也存在'));
            }
            $employee1 = model('employee')->where(array('username'=>$data['username'],'status'=>array('in','0,1')))->select();
            if ($employee1) {
               $this->dexit(array('error'=>1,'msg'=>'登录账号也存在'));
            }
            $employee2 = model('employee')->where(array('phone'=>$data['phone'],'status'=>array('in','0,1')))->select();
            if ($employee2) {
               $this->dexit(array('error'=>1,'msg'=>'手机号码也存在'));
            }
            $employee3 = model('employee')->where(array('email'=>$data['email'],'status'=>array('in','0,1')))->select();
            if ($employee3) {
               $this->dexit(array('error'=>1,'msg'=>'邮箱号码也存在'));
            }
            $password = $data['password'];
            $data['password'] = md5($data['password']);

            $time = time();
            $data['create_time'] = $time;
            $shop = model('shop')->where(array('id'=>$this->mid))->find();
            $data['company_id'] = $shop['company_id'];
            $uid = uc_user_register1($data['username'], $password, $data['email']);
            if($uid > 1){
                $data['uid'] = $uid;
                if (model('employee')->data($data)->add()) {
                    $this->dexit(array('error'=>0,'msg'=>'添加成功'));
                }else{
                    $this->dexit(array('error'=>1,'msg'=>'添加失败'));
                }
            }else{
                $this->dexit(array('error'=>1,'msg'=>'添加失败'));

            }


        }
        $roles = model('store_role')->where(array('store_id'=>$this->mid))->order('id desc')->select();
        $this->displays('employee_add',array('roles'=>$roles));

    }
     //角色列表
    public function do_employee_role()
    {
      $_count=model('store_role')->where(array('store_id'=>$this->mid))->count();
      require_once(UPLOAD_PATH.'common_page.class.php');
      $p = new Page($_count, 10);
      $pagebar = $p->show(10);
        $role = model('store_role')->where(array('store_id'=>$this->mid))->limit($p->firstRow,$p->listRows)->select();
        $this->displays('employee_role',array('role'=>$role,'pagebar'=>$pagebar));
    }
    //删除角色
    public function do_empolyee_role_del()
    {
        $id = $this->clear_html($_GET['del_id']);
        if (model('store_role')->where(array('id'=>$id))->delete()) {
            $this->dexit(array('error'=>0,'msg'=>'删除成功'));
        }else{
            $this->dexit(array('error'=>1,'msg'=>'删除成功'));
        }
    }
     //添加角色
     public function do_employee_role_add()
     {

        if ($_POST) {
            $datas= $this->clear_html($_POST);
            $ids = rtrim($datas['all_id'],',');

            $auths = model('store_auth')->field('auth_a,auth_c')->where(array('id'=>array('in',$ids)))->select();
            $ac = '';
            foreach ($auths as  $v) {
               $ac.=$v['auth_a'].'-'.$v['auth_c'].',';
            }
            $data['store_id'] = $this->mid;
            $data['role_name'] = $datas['role_name'];
            $data['role_auth_ids'] = $ids;
            $data['role_auth_ac'] =  $ac;

            if (model('store_role')->data($data)->add()) {

                $this->dexit(array('error'=>0,'msg'=>'添加成功'));
            }else{
                $this->dexit(array('error'=>1,'msg'=>'添加失败'));
            }
        }

        // die;
        $auth1 = model('store_auth')->where(array('auth_level'=>0))->select();
        $auth2 = model('store_auth')->where(array('auth_level'=>1))->select();
        // var_dump($auth2);die;
        $this->displays('employee_role_add',array('auth1'=>$auth1,'auth2'=>$auth2));
     }
     #编辑角色
     public function do_employee_role_up()
     {
        if (IS_POST) {
            $datas= $this->clear_html($_POST);
            $ids = rtrim($datas['all_id'],',');

            $auths = model('store_auth')->field('auth_a,auth_c')->where(array('id'=>array('in',$ids)))->select();
            $ac = '';
            foreach ($auths as  $v) {
               $ac.=$v['auth_a'].'-'.$v['auth_c'].',';
            }
            $data['store_id'] = $this->mid;
            $data['role_name'] = $datas['role_name'];
            $data['role_auth_ids'] = $ids;
            $data['role_auth_ac'] =  $ac;

            if (model('store_role')->data($data)->where(array('id'=>$datas['role_id']))->save()) {

                $this->dexit(array('error'=>0,'msg'=>'修改成功'));
            }else{
                $this->dexit(array('error'=>1,'msg'=>'修改失败'));
            }
        }

        $role_id = $this->clear_html($_GET['role_id']);
        $roles = model('store_role')->where(array('id'=>$role_id))->find();
        $auth1 = model('store_auth')->where(array('auth_level'=>0))->select();
        $auth2 = model('store_auth')->where(array('auth_level'=>1))->select();
        $this->displays('employee_role_up',array('auth1'=>$auth1,'auth2'=>$auth2,'roles'=>$roles));
     }

    //餐桌管理
    public function do_shop_table()
    {
        dump($_SESSION['employee']['id']);
        $sql = 'select a.*,b.title as b_title,c.title as c_title  from hd_food_shop_tables as a Left Join hd_food_shop_tablezones as b on a.tablezonesid=b.id Left Join hd_food_shop_print_label as c on a.table_label_id=c.id where a.store_id='.$this->mid.' order by displayorder asc';
        $datas = model('food_shop_tables')->query($sql);
        $this->displays('shop/shop_table',['datas'=>$datas]);

    }

    //餐桌详情
    public function do_shop_table_info()
    {
        $id = $_GET['table_id'];
        $sql = 'select a.*,b.title as b_title,c.title as c_title  from hd_food_shop_tables as a Left Join hd_food_shop_tablezones as b on a.tablezonesid=b.id Left Join hd_food_shop_print_label as c on a.table_label_id=c.id where a.id='.$id.' and a.store_id='.$this->mid;
        $datas = model('food_shop_tables')->query($sql);
        $this->displays('shop/shop_table_info',['datas'=>$datas]);

    }

    //餐桌二维码管理
    public function do_shop_table_qrcode()
    {
        // unset($_SESSION['employee']['id']);
        //   dump($_SESSION);
        $sql = 'select a.*,b.title as b_title,c.title as c_title  from hd_food_shop_tables as a Left Join hd_food_shop_tablezones as b on a.tablezonesid=b.id Left Join hd_food_shop_print_label as c on a.table_label_id=c.id where a.store_id='.$this->mid.' order by displayorder asc';

        $datas = model('food_shop_tables')->query($sql);
        // dump($datas);
        // die;
        $this->displays('shop/shop_table_qrcode',['datas'=>$datas]);
    }
    //餐桌二维码下载
    public function do_shop_table_qrcode_dow()
    {

    }
    //删除餐桌
    public function do_shop_table_del()
    {
        $id = $this->clear_html($_GET['del_id']);
        if (model('food_shop_tables')->where(['store_id'=>$this->mid,'id'=>$id])->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }

    }

    //修改餐桌状态
    public function do_shop_table_status()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            if (model('food_shop_tables')->data(['status'=>$data['status']])->where(array('id'=>$data['status_id'],'store_id'=>$this->mid))->save()) {

                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{

                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }
    }
    //一键清台
    public function do_shop_table_allstatus()
    {
       $store_id = $_GET['ids'];
        if ($store_id == 'all') {
            if (model('food_shop_tables')->data(['status'=>0])->where(array('store_id'=>$this->mid))->save()) {

                $this->dexit(['error'=>0,'msg'=>'操作成功']);
            }else{

                $this->dexit(['error'=>1,'msg'=>'操作失败']);
            }
        }
    }

    //修改餐桌

    public function do_shop_table_edit()
    {
        if (IS_POST) {
            if (IS_POST) {
                $edata = $this->clear_html($_POST);
                $id = $edata['table_id'];
                unset($edata['table_id']);
                if (model('food_shop_tables')->data($edata)->where(['store_id'=>$this->mid,'id'=>$id])->save()) {
                    $this->dexit(['error'=>0,'msg'=>'修改成功']);
                }else{

                    $this->dexit(['error'=>1,'msg'=>'修改失败']);
                }
            }
        }

        $id = $_GET['table_id'];
        $data = model('food_shop_tables')->where(array('store_id'=>$this->mid,'id'=>$id))->find();
        $datas = model('food_shop_tablezones')->field('id,title')->where(array('status'=>1,'store_id'=>$this->mid))->order('displayorder asc')->select();
        $printlabel = model('food_shop_print_label')->field('id,title')->where(array('status'=>1,'store_id'=>$this->mid))->order('displayorder asc')->select();
        $this->displays('shop/shop_table_edit',['data'=>$data,'datas'=>$datas,'printlabel'=>$printlabel]);

    }
    public function test11()
    {
      $table_id=$this->clear_html($_GET);

      require_once(UPLOAD_PATH.'phpqrcode.php');
      $url='http://dc.51ao.com/?m=plugin&p=wap&cn=index&id=food:sit:test&table_id='.$table_id['table_id'].'&shop_id='.$this->mid.'&eid='.$_SESSION['employee']['id'];
      QRcode::png($url);
    }
    public function test22()
    {
      //大厅上的二维码
      require_once(UPLOAD_PATH.'phpqrcode.php');
       $url='http://dc.com/?m=plugin&p=wap&cn=index&id=food:sit:choose_table&shop_id='.$this->mid;
      QRcode::png($url);
    }
    //添加餐桌
    public function do_shop_table_add()
    {
        // dump($_SESSION);
        // die;
        if (IS_POST) {
            $data = $this->clear_html($_POST);

            $data['store_id'] = $this->mid;
            $data['dateline'] = time();
            $return=model('food_shop_tables')->data($data)->add();
            if ($return) {
                $url='http://dc.com/index.php?m=plugin&p=shop&cn=index&id=food:sit:test11&table_id='.$return;
                $table_url=model('food_shop_tables')->data(array('url'=>$url))->where(array('id'=>$return))->save();
                if($table_url)
                {
                  $this->dexit(['error'=>0,'msg'=>'添加成功']);
                }else
                {
                  $this->dexit(['error'=>1,'msg'=>'fail']);
                }


            $data['store_id'] = $this->mid;
             //$this->dexit(['error'=>0,'msg'=>$data]);


            $data['store_id'] = $this->mid;
            $data['dateline'] = time();

            $data['store_id'] = $this->mid;
            $data['dateline'] = time();

            if (model('food_shop_tables')->data($data)->add()) {

                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }
            else{

                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }

        }

    }
        $datas = model('food_shop_tablezones')->field('id,title')->where(array('status'=>1,'store_id'=>$this->mid))->order('displayorder asc')->select();
        $printlabel = model('food_shop_print_label')->field('id,title')->where(array('status'=>1,'store_id'=>$this->mid))->order('displayorder asc')->select();
        $this->displays('shop/shop_table_add',array('datas'=>$datas,'printlabel'=>$printlabel));
  }
    //添加餐桌标签
    public function do_shop_table_printlabel_add()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $data['store_id'] = $this->mid;
            if (model('food_shop_print_label')->data($data)->add()) {
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }

        $this->displays('shop/shop_table_printlabel_add');

    }

    //餐桌类型管理
    public function do_shop_table_type()
    {
        $datas = model('food_shop_tablezones')->where(array('status'=>1,'store_id'=>$this->mid))->order('displayorder asc')->select();
        //dump($datas);die;
        $this->displays('shop/shop_table_type',array('datas'=>$datas));

    }
    //餐桌类型排序
    public function do_shop_table_type_order()
    {
        $data = $this->clear_html($_POST);
        $ids = explode(',',rtrim($data['table_id'],','));
        $vs = explode(',',rtrim($data['orders'],','));
        $status = [];
        foreach ($ids as $k => $v) {
           foreach ($vs as $key => $value) {
              if ($k == $key) {
                $status[] = model('food_shop_tablezones')->data(array('displayorder'=>$value,'store_id'=>$this->mid))->where(array('id'=>$v))->save();
              }
           }
        }
        if ($status) {
            $this->dexit(array('error'=>0,'msg'=>'修改成功'));

        }else{

            $this->dexit(array('error'=>0,'msg'=>'修改失败'));

        }
    }

    //餐桌类型删除
    public function do_shop_table_type_del()
    {
        $id = $this->clear_html($_GET['del_id']);
        if (model(food_shop_tablezones)->where(array('id'=>$id,'store_id'=>$this->mid))->delete()) {
            $this->dexit(array('error'=>0,'msg'=>'删除成功'));
        }else{

            $this->dexit(array('error'=>1,'msg'=>'删除失败'));
        }

    }

    //编辑餐桌类型
    public function do_shop_table_type_edit()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $id = $data['order_id'];
            unset($data['order_id']);
            if (model('food_shop_tablezones')->data($data)->where(array('id'=>$id,'store_id'=>$this->mid))->save()) {
                $this->dexit(array('error'=>0,'msg'=>'修改成功'));

            }else{

                $this->dexit(array('error'=>1,'msg'=>'修改失败'));
            }

        }

        $id = $_GET['type_id'];
        $datas = model('food_shop_tablezones')->where(array('id'=>$id,'store_id'=>$this->mid))->find();
        $this->displays('shop/shop_table_type_edit',array('datas' =>$datas));
    }
    //添加餐桌类型
    public function do_shop_table_type_add()
    {
        if (IS_POST) {
           $data = $this->clear_html($_POST);
           $data['store_id'] = $this->mid;

           if (model('food_shop_tablezones')->data($data)->add()) {
                $this->dexit(array('error'=>0,'msg'=>'添加成功'));
           }else{
                $this->dexit(array('error'=>1,'msg'=>'添加失败'));
           }
        }
        $this->displays('shop/shop_table_type_add');

    }

    //排队管理
    public function do_shop_queue()
    {
        $this->displays('shop/shop_queue');


    }

    //预定管理
    public function do_shop_reserve()
    {
        $this->displays('shop/shop_reserve');
    }





     public function displays($c,$data=array())
     {
         foreach($data as $key =>$value){

            $$key=$value;
        }

        $this->left_menu();

        include PLUGIN_PATH.PLUGIN_ID.'/template/shop/'.$c.'.php';
    }

     public function file_upload($phone)
    {
        require_once(UPLOAD_PATH.'upload/UploadTp.class.php');

        $up = new FileUpload();
        $up -> set("path", "./uploadfile/images/");
        $up -> set("maxsize", 5120000);
        $up -> set("allowtype", array("png", "jpg","jpeg"));
        $up -> set("israndname", true);
        $up->path .= $phone.'/';

            if(!file_exists($up->path))//文件夹不存在，先生成文件夹
            {
                mkdir($up->path);
            }


        $urlarr=array();
        if($_FILES)
        {
          $url = $this->clear_html($_FILES);
          foreach ($url as $k =>  $v) {
             if($v['size'] > 5120000)
               {

                   echo "<script>alert('上传图片不能超过5120kb！');window.history.go(-1);</script>";
                   die;
               }

             if($v['error']===0)
             {
                //使用Upload.class.php功能类，实现附件上传

                   if($up -> upload($v))
                         {
                            $bigPathName = $up ->path.$up->getFileName();
                              //echo $bigPathName;
                            $urlarr[$k] =  $bigPathName;
                              //var_dump($urlarr[$k]);die;

                          }

               }


           }

           return   $urlarr;

          }
    }

    public function GetTree($arr,$pid,$step){
        global $tree;
        foreach($arr as $key=>$val) {
              if($val['pid'] == $pid) {
                  $flg = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----',$step);
                  $val['name'] = $flg.$val['name'];
                  $tree[] = $val;
                  $this->GetTree($arr , $val['id'] ,$step+1);
              }
          }
          return $tree;
    }



}