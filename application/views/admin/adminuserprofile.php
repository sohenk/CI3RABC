<?php $this->load->view("admin/header")?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
      <?php 
      switch ($action) {
		case "new":echo "添加管理员用户";break;
		case "edit":echo "编辑管理员用户";break;
		default:redirect("admin");break;
	}
      ?></h1>
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          管理员用户信息
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="post" action="<?php echo site_url("admin/adminuserprofile?action=$action")?>">
                                        <div class="form-group">
                                            <label>管理员用户名</label>
                                            <input class="form-control" name="name" value="<?php if(isset($term["name"])){echo $term["name"];} ?>" placeholder="用户名">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>管理员登录名</label>
                                            <input class="form-control" name="loginname" value="<?php if(isset($term["loginname"])){echo $term["loginname"];} ?>" placeholder="登录名">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                             <div class="form-group">
                                            <label>用户角色</label>
                                           	 <select name="role_id" id=""role_id"" class="form-control col-md-3">
                                           	 <?php foreach($role as $v):?>
                                   			 <option value="<?php echo  $v->role_id;?>" <?php if(isset($term["role_id"])&&$term["role_id"]==$v->role_id){echo "selected=''";} ?>><?php echo $v->role_name?></option> 				
                                   			 <?php endforeach?>	  
                               			 </select>
                               			 
                                        </div>
                                         
                                         <div class="form-group">
                                            <label>密码</label>
                                            <input class="form-control" type="password" name="pwd"  placeholder="密码">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                          <div class="form-group">
                                            <label>能否管理别人数据</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="isctrother" id="optionsRadiosInline1" value="1" <?php if(isset($term["isctrother"])&&$term["isctrother"]):?> checked=""<?php endif?>>是
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="isctrother" id="optionsRadiosInline2" value="0" <?php if(isset($term["isctrother"])&&!$term["isctrother"]):?> checked=""<?php endif?>>否
                                            </label>
                                            
                                        </div>
                                    
                                       	<input type="hidden" name="id" value="<?php if(isset($term["id"])){echo $term["id"];} ?>">
                                        <button type="submit" class="btn btn-default">提交</button>
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
