<?php $this->load->view("admin/header")?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
      <?php 
      switch ($action) {
		case "new":echo "添加角色";break;
		case "edit":echo "编辑角色";break;
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
                                    <form role="form" method="post" action="<?php echo site_url("admin/roleprofile/$action")?>">
                                        <div class="form-group">
                                            <label>角色名称</label>
                                            <input class="form-control" name="role_name" value="<?php if(isset($term["role_name"])){echo $term["role_name"];} ?>" placeholder="角色名称">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                         <div class="form-group">
                                            <label>角色英文标识</label>
                                            <input class="form-control" name="role_shortname" value="<?php if(isset($term["role_shortname"])){echo $term["role_shortname"];} ?>" placeholder="角色英文标识">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                        
                                       	<input type="hidden" name="role_id" value="<?php if(isset($term["role_id"])){echo $term["role_id"];} ?>">
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
