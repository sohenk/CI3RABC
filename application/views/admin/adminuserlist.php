<?php $this->load->view("admin/header")?>
<style>
table th,table td{
	text-align: center;
}
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">管理员用户列表</h1>
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
       
                                        <a href="<?php echo site_url("admin/adminuserprofile")?>?action=new" type="button" class="btn btn-info">添加管理员用户</a> </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="table-responsive">
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                  <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                    <tr>
                      <th>序号</th>
                      <th>用户名</th>
                      <th>角色</th>
                      <th>操作</th>
                    </tr>
                    <?php if($term):?>
                    <?php foreach($term as $val):?>
                      <tr >
                        <td class="sorting_1"><?php echo $val->id?></td>
                        <td class="sorting_1"><?php echo $val->name?></td>
                        <td class="sorting_1"><?php echo $val->rolename?></td>
                        <td class="center   "><a href="<?php echo site_url("admin/adminuserprofile?id=$val->id")?>&action=edit"><i class="glyphicon glyphicon-pencil"></i></a>
                         <?php if($this->session->userdata("authority")<3):?>
                        <a  href="javascript:void(0)" onclick="isdel('adminuserprofile','<?php echo $val->id?>')" ><i class="glyphicon glyphicon-trash"></i></a>
                        <?php endif;?>
                        </td>
                      </tr>
                      <?php endforeach;?>
                    <?php else:?>
                     <tr >
                        <td colspan="3" class="center" align="center">尚未添加任何管理员用户,点击<a class="btn btn-info btn-xs" href="<?php echo site_url("admin/adminuserprofile")?>?action=new">添加管理员用户</a></td>
                      </tr>
                    <?php endif?>
                  </table>
                </div>
              </div>
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
