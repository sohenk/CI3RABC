<?php $this->load->view("admin/header")?>
<style>
table th,table td{
	text-align: center;
}
.input-group[class*=col-] {
    float: left;
}
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">角色列表  <a class="btn btn-info btn-xs" href="<?php echo site_url("admin/roleprofile/new")?>">添加角色</a>
      </h1>
      
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading" >
       <!-- 
         <form action="<?php echo site_url("admin/contentlist")?>" >
        
        <div class="input-group col-md-2">
        <select  name="type" id="type" class="form-control col-md-3">
                                     <option value="" <?php if(isset($_GET["type"])){if($_GET["type"]!="0"|$_GET["type"]!="1"){echo 'selected';}}?>>所有</option>
                                     <option value="0" <?php if(isset($_GET["type"])){if($_GET["type"]=="0"){echo 'selected';}}?>>未使用</option>
                                     <option value="1" <?php if(isset($_GET["type"])){if($_GET["type"]=="1"){echo 'selected';}}?>>已使用</option>
                                </select>
           </div> 
             <div class="input-group custom-search-form col-md-5">
            
                                <input type="text" name="search" value="<?php if(isset($_GET["search"])){echo $_GET["search"];}?>" class="form-control" placeholder="搜索文章">
                                
                                <span class="input-group-btn">
                                
                                <button class="btn btn-default" type="submit" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>                                  
               </form>               -->        
        <div class="clearfix"></div>

         </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="table-responsive">
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                  <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                    <tr>
                      <th>序号</th>
                      <th>标题</th>
                      <th>操作</th>
                    </tr>
                    <?php if($term):?>
                    <?php foreach($term as $val):?>
                      <tr >
                        <td class="sorting_1"><?php echo $val->role_id?></td>
                        <td class="sorting_1"><?php echo $val->role_name?></td>
                        <td class="center   ">
                        <a  href="<?php echo site_url("admin/roleprivilege/$val->role_id")?>" type="button" class="btn btn-success btn-xs">权限分配</a>
                        <a   href="<?php echo site_url("admin/roleprofile/edit/$val->role_id")?>" type="button" class="btn btn-warning btn-xs">编辑</a>
                        <a  href="javascript:void(0)" onclick="isdel('roleprofile','<?php echo $val->role_id ?>')" type="button" class="btn btn-danger btn-xs">删除</a>
                       
                        </td>
                      </tr>
                      <?php endforeach;?>
                       <tr >
                        <td colspan="7" class="center" align="center"><?php echo $page?></td>
                      </tr>
                    <?php else:?>
                     <tr >
                        <td colspan="7" class="center" align="center">尚未添加任何栏目,点击<a class="btn btn-info btn-xs" href="<?php echo site_url("admin/channelprofile")?>?action=new">添加栏目</a></td>
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
