<?php $this->load->view("admin/header")?>
    <style type="text/css">
@import "<?php echo base_url()?>js/date/jquery.datepick.css";
<!--
#uploadifive-upload_picture_pic{
	height: 30px;
    line-height: 30px;
    overflow: hidden;
    position: relative;
    text-align: center;
    width: 120px;
    color: rgb(255, 255, 255);
    background-color: rgb(42, 67, 74);
}
.upload-pre-item img{
	max-width:320px;
}
-->
</style>
  
    
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
      栏目编辑
      </h1>
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          内容
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="post" action="<?php echo site_url("admin/menuprofile/$action")?>">
                                        <div class="form-group">
                                            <label>栏目标题</label>
                                           	  <input class="form-control" name="menu_title" value="<?php if(isset($coupon->menu_title)){echo $coupon->menu_title;} ?>" placeholder="栏目标题">
                                        </div>
                                     <div class="form-group">
                                            <label>上级栏目</label>
                                           	 <select name="parent_id" id="parentid" class="form-control col-md-3">
                                     <option value="0">一级栏目</option>
                                     <?php $menus = ($this->user->getAllMenus()); ?>
                                            <?php if (isset($menus)):?>
          									<?php foreach($menus as $menu):?>
                                     	<option value="<?php echo $menu["item"]['menu_id'];?>"  <?php if(isset($coupon->parent_id)){if($coupon->parent_id==$menu["item"]['menu_id']){echo 'selected';}}?>  > <?php echo $menu["item"]['menu_title']; ?></option>
                                     	<?php  if (isset($menu["children"])):?>
               <?php foreach($menu["children"] as $sub_menu):?>
              	  			<?php if(is_array($sub_menu)):?>
			              	  			<option value="<?php echo  $sub_menu["item"]['menu_id']?>"  <?php if(isset($coupon->parent_id)){if($coupon->parent_id== $sub_menu["item"]['menu_id']){echo 'selected';}}?>  >&nbsp;&nbsp;├ <?php echo $sub_menu["item"]['menu_title']; ?></option>
			              	  			<?php endif;?>
              	  			<?php endforeach;?>   
              	  			 <?php endif;?>  
                                       <?php endforeach;?>
          			  					<?php endif;?>  
                                </select>
                                        </div>
                                        
                                        </br>
                                         <div class="form-group">
                                            <label>栏目控制器</label>
                                            <input class="form-control" name="menu_controller" value="<?php if(isset($coupon->menu_controller)){echo $coupon->menu_controller;} ?>" placeholder="控制器">
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>栏目方法</label>
                                            <input class="form-control" name="menu_method" value="<?php if(isset($coupon->menu_method)){echo $coupon->menu_method;} ?>" placeholder="方法">
                                        </div>
                                         <div class="form-group">
                                            <label>栏目参数</label>
                                            <input class="form-control" name="menu_param" value="<?php if(isset($coupon->menu_param)){echo $coupon->menu_param;} ?>" placeholder="菜单参数">
                                        </div>
                                        <div class="form-group">
                                            <label>action</label>
                                            <input class="form-control" name="menu_action" value="<?php if(isset($coupon->menu_action)){echo $coupon->menu_action;} ?>" placeholder="action">
                                        </div>
                                         <div class="form-group">
                                            <label>菜单样式</label>
                                            <input class="form-control" name="menuclass" value="<?php if(isset($coupon->menuclass)){echo $coupon->menuclass;} ?>" placeholder="菜单样式">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>显示菜单</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_show" id="optionsRadiosInline1" value="1" <?php if(isset($coupon->is_show)&&$coupon->is_show):?> checked=""<?php endif?>>是
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_show" id="optionsRadiosInline2" value="0" <?php if(isset($coupon->is_show)&&!$coupon->is_show):?> checked=""<?php endif?>>否
                                            </label>
                                            
                                        </div>
                                        
                                        <?php if(isset($coupon->menu_id)):?>
                                        <input type="hidden" name="menu_id" value="<?php {echo $coupon->menu_id;} ?>">
                                        
                                        <?php endif;?>
                                     
                                   
                                        <button type="submit" class="btn btn-default">保存</button>
                                        <button type="reset" class="btn btn-default">清空</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
  
  
  
</div>
<!-- /#page-wrapper -->

<?php $this->load->view("admin/footer")?>
<script src="<?php echo base_url()?>js/date/jquery-migrate-1.2.1.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>js/date/jquery.datepick.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/date/jquery.datepick-zh-CN.js"></script>
 <script>
	 $(function(){
            $("#overtime").datepick({dateFormat: 'yy-mm-dd'});
        });
	</script>