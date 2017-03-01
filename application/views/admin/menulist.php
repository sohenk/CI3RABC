<?php $this->load->view("admin/header")?>
<style>
table th,table td{
	text-align: center;
}
.menu-border{border-bottom: 1px dashed #CCC; padding:5px 0px;}
.menu-border:hover{background: #afdbbc;}
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">菜单列表</h1>
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
       
                                        <a href="<?php echo site_url("admin/menuprofile/new/")?>?action=new" type="button" class="btn btn-info">添加菜单</a> </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="table-responsive">
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
              <?php $menus = ($this->user->getAllMenus());?>
                      <?php if (isset($menus)):?>
          			<?php foreach($menus as $menu):?>
              <h4 class="menu-border"><span style="float:right;"><?php if($menu["item"]["is_show"]):?><a href="#" type="button" class="btn btn-success btn-xs">显示</a><?php else:?><a href="#" type="button" class="btn btn-warning btn-xs">隐藏</a><?php endif?><a href="<?php echo base_url("admin/menuprofile/edit/". $menu["item"]['menu_id']);?>" type="button" class="btn btn-info btn-xs">编辑</a><a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="isdel('menuprofile','<?php echo $menu["item"]['menu_id']; ?>')">删除</a></span>  <?php echo $menu["item"]['menu_title']; ?> </h4>
              <ul>
              <?php  if (isset($menu["children"])):?>
               <?php foreach($menu["children"] as $sub_menu):?>
              	  			<?php if(is_array($sub_menu)):?>
                             <li>
                               <p class="menu-border"><span style="float:right;"><?php if($sub_menu["item"]["is_show"]):?><a href="#" type="button" class="btn btn-success btn-xs">显示</a><?php else:?><a href="#" type="button" class="btn btn-warning btn-xs">隐藏</a><?php endif?><a href="<?php echo base_url("admin/menuprofile/edit/". $sub_menu["item"]['menu_id']);?>" type="button" class="btn btn-info btn-xs">编辑</a><a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="isdel('menuprofile','<?php echo $sub_menu["item"]['menu_id']; ?>')">删除</a></span>  <?php echo $sub_menu["item"]['menu_title'];?></p>
                             	<?php if(isset($sub_menu["children"])):?>
                             		<?php foreach($sub_menu["children"] as $third_menu):?>
                             		 <p class="menu-border"><span style="float:right;" ><?php if($third_menu["item"]["is_show"]):?><a href="#" type="button" class="btn btn-success btn-xs">显示</a><?php else:?><a href="#" type="button" class="btn btn-warning btn-xs">隐藏</a><?php endif?><a href="<?php echo base_url("admin/menuprofile/edit/". $third_menu["item"]['menu_id']);?>" type="button" class="btn btn-info btn-xs">编辑</a><a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="isdel('menuprofile','<?php echo $third_menu["item"]['menu_id']; ?>')">删除</a></span> &nbsp;&nbsp;├  <?php echo $third_menu["item"]['menu_title'];?></p>
                             		<?php endforeach;?>
                                <?php endif;?>
                                </li>                                
                            <?php endif;?>
              	  			<?php endforeach;?>   
              	  			 <?php endif;?>  
                            </ul>
                             <?php endforeach;?>
          			  <?php endif;?>  
            </div>
          </div>
          <!-- /.table-responsive --> 
        </div>
        <!-- /.panel-body --> 
      </div>
      <!-- /.panel --> 
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  <!-- /.row --> 
</div>
<!-- /#page-wrapper -->

<?php $this->load->view("admin/footer")?>
