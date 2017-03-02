<?php $this->load->view("admin/header")?>
<script type="text/javascript" src="<?php echo base_url("static")?>/qrcode/qrcode.js"></script>
	<script type="text/javascript" src="<?php echo base_url("static")?>/qrcode/jquery.qrcode.js"></script>
<script type="text/javascript">
function cmsckSelected(status){
	var selectedContentList=document.getElementsByName("contentCheck");
	var selectedContentIds=[];
	for(var i=0;i<selectedContentList.length;i++){
		var selectedContent=selectedContentList[i];
		if(selectedContent.checked){
			selectedContentIds[selectedContentIds.length]=selectedContent.value;
		}
	}

	if(selectedContentIds.length<1){
		alert("请选中要更改状态的数据");
		return false;
	}

	if(confirm("确定，更改选中记录？")){
		var idsStr="";
		for(var i=0;i<selectedContentIds.length;i++){
			if(i>0){
				idsStr+=",";
			}
			idsStr+=selectedContentIds[i];
		}
		window.location.href="<?php echo site_url("cms/chstatus")?>?idStr="+idsStr+"&status="+status;
	}
	else{return false;}
}
</script>
	<style>
table th,table td {
	text-align: center;
}

.input-group[class*=col-] {
	float: left;
}
</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
      <h1 class="page-header">
        <?php echo isset($cms_channelitem->name)?$cms_channelitem->name:"所有内容列表"?>  <a class="btn btn-info btn-xs" href="<?php echo site_url("cms/addcontent")."/".(isset($cms_channelitem->id)?$cms_channelitem->id:0)?>">添加文章</a>
	 </h1>
    </div>
		<!-- /.col-lg-12 -->
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<form action="<?php echo site_url("cms/contentlist/")?>">

						<div class="input-group col-md-3">
							<select name="channelid" id="type" class="form-control col-md-3">
								<option value="0">所有</option>
								<?php foreach($this->channelDepthList as $k=>$v):?>
								<?php $htmlStr="";for($i=0;$i<$v->depth;$i++){$htmlStr.="&#160;&#160;&#160;&#160;";} ?>
								    <option value="<?php echo $v->id?>"><?php echo $htmlStr.($v->depth>0?'├':"").$v->name;?></option>                                                                
                                <?php endforeach;?>
							</select>
						</div>
						<div class="input-group custom-search-form col-md-5">

							<input type="text" name="search" value="<?php if(isset($_GET["search"])){echo $_GET["search"];}?>" class="form-control" placeholder="搜索文章"> <span class="input-group-btn">

								<button class="btn btn-default" type="submit" type="button">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</div>
					</form>
					<div class="clearfix"></div>

				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="table-responsive">
						<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
							<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
								<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
									<table id="contentList" class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
										<tr>
											<th><input id="selectedAll" onclick="isSelectedAll(this)" type="checkbox" value="all" />全选</th>
											
											<th>标题</th>
											<th>上传者</th>
											<th>时间</th>
											<th>状态</th>
											<th>操作</th>
										</tr>
                            <?php if($cms_contentlist):?>
                            <?php foreach($cms_contentlist as $val):?>
                              <tr>
											<td class="sorting_1"><input onclick="isSelectedAll(this)" type="checkbox" name="contentCheck" value="<?php echo $val->id;?>" /></td>
											<td class="sorting_1"><?php echo $val->title?></td>
											<td class="sorting_1"><?php echo $val->author?></td>											
											<td class="sorting_1"><?php echo date("Y-m-d",$val->time)?></td>
											<td class="sorting_1"><?php echo getStatusBtn($val->state)?></td>

											<td class="center   "><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal<?php echo $val->id?>">查看</button> <a
												href="<?php echo site_url("cms/editcontent/$val->cid?id=$val->id")?>" type="button" class="btn btn-info btn-xs" >编辑</a> <a href="javascript:void(0)"
												onclick="cmsisdel('cms_content','<?php echo $val->id?>','delcontent')" type="button" class="btn btn-danger btn-xs">删除</a></td>
												 <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $val->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $val->title?></h4>
                                        </div>
                                        <div class="modal-body text-center" >
                                        <?php echo $val->content;?>
                                      	<!--
                                      			 <div class="qrCode<?php echo $val->id;?>"></div>
                                        <script type="text/javascript">
                                        $('.qrCode<?php echo $val->id;?>').qrcode({width:300,height:300,text:'<?php echo site_url("show/content?id=$val->id")?>'});
                                        </script>
                                         -->
                                        </div>
                                        <div class="modal-footer">
                                        											<?php  if($this->user->get_user_ctr()){?><a href="<?php echo site_url("cms/chstatus?idStr=$val->id&status=2")?>"  type="button" class="btn btn-success btn-xs">审核</a>
											<a href="<?php echo site_url("cms/chstatus?idStr=$val->id&status=0")?> type="button" class="btn btn-warning btn-xs">退回</a><?php  }?>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
										</tr>
                          <?php endforeach;?>
                           <tr>
											<?php  if($this->user->get_user_ctr()){?><td><a href="javascript:void(0)" onclick="cmsckSelected(2)" type="button" class="btn btn-success btn-xs">审核</a></td>
											<td><a href="javascript:void(0)" onclick="cmsckSelected(0)" type="button" class="btn btn-warning btn-xs">退回</a></td><?php  }?>
											 <td><a href="javascript:void(0)" onclick="cmsDelSelected('cms_content')" type="button" class="btn btn-danger btn-xs">删除</a></td>
											 <td colspan="5" class="center" align="center">  
											                    
                        <?php echo $page?>
                        </td>
										</tr>
                    <?php else:?>
                     <tr>
											<td colspan="8" class="center" align="center">尚未添加任何文章,点击
											<?php if (!isset($cms_channelitem)):?>左侧内容管理栏进行相关操作！											
											<?php else:?>
											<a class="btn btn-info btn-xs" href="<?php echo site_url("cms/addcontent/$cms_channelitem->id")?>">添加文章</a>
											<?php endif?>
											</td>
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
