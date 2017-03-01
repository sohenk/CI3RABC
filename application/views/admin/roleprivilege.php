<?php $this->load->view("admin/header")?>
<link rel="stylesheet" href="<?php echo base_url("static/zTree/")?>/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="<?php echo base_url("static/zTree/")?>/js/jquery.ztree.core.js"></script>
	<script type="text/javascript" src="<?php echo base_url("static/zTree/")?>/js/jquery.ztree.excheck.js"></script>
	<!--
	<script type="text/javascript" src="<?php echo base_url("static/zTree/")?>/js/jquery.ztree.exedit.js"></script>
	-->
	<SCRIPT type="text/javascript">
		<!--
		var setting = {
			check: {
				enable: true,
				chkboxType:{ "Y" : "ps", "N" : "ps" }
			},
			data: {
				simpleData: {
					enable: true
				}
			}
		};

		var zNodes =[

		             <?php $menus = ($this->user->getAllMenus());?>
		             <?php foreach($menus as $menu):?>
		             { id:<?php echo $menu["item"]['menu_id']; ?>, pId:<?php echo $menu["item"]['parent_id']; ?>, name:"<?php echo $menu["item"]['menu_title']; ?>", open:true<?php if(in_array($menu["item"]['menu_id'], $menuarray)):?>,checked:true<?php endif?>},
						 <?php  if (isset($menu["children"])):?>
		               		 <?php foreach($menu["children"] as $sub_menu):?>
		                	 { id:<?php echo $sub_menu["item"]['menu_id']; ?>, pId:<?php echo $sub_menu["item"]['parent_id']; ?>, name:"<?php echo $sub_menu["item"]['menu_title']; ?>", open:true<?php if(in_array($sub_menu["item"]['menu_id'], $menuarray)):?>,checked:true<?php endif?>},
		                	 	<?php if(isset($sub_menu["children"])):?>
                          		<?php foreach($sub_menu["children"] as $third_menu):?>
                         		 { id:<?php echo $third_menu["item"]['menu_id']; ?>, pId:<?php echo $third_menu["item"]['parent_id']; ?>, name:"<?php echo $third_menu["item"]['menu_title']; ?>", open:true<?php if(in_array($third_menu["item"]['menu_id'], $menuarray)):?>,checked:true<?php endif?>},
      		                	
                          		<?php endforeach;?>
                                <?php endif;?>
		               		 <?php endforeach;?>   
	    	  			 <?php endif;?> 
		             <?php endforeach;?>
		
		];
		
		
		
	
		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			
		});
		//-->
	</SCRIPT>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
      角色权限管理</h1>
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
                                    <form role="form" onsubmit = "return checkSubmit();" method="post" action="<?php echo site_url("admin/roleprivilege")?>">
    
                                       <div class="zTreeDemoBackground left">
		<ul id="treeDemo" class="ztree"></ul>
	</div>
                                       
                                       
                                       	<input id="menuid" type="hidden" name="menuid" value="">
                                       	<input type="hidden" name="role_id" value="<?php if(isset($term["id"])){echo $term["id"];} ?>">
                                        <button type="submit" class="btn btn-success" id="submit">授权</button>
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
<script>
function checkSubmit(){

	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
	var nodes = treeObj.getCheckedNodes(true);

	var str = "";
	$.each(nodes,function(i,value){
		if (str != "") {
			str += ","; 
		}
		str += value.id;
	});

	$("#menuid").val(str);

// 	console.log(str);
	return true;
}
</script>
<!-- /#page-wrapper -->
<?php $this->load->view("admin/footer")?>
