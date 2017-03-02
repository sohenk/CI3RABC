<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>教育信息工作管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url("static")?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url("static")?>/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url("static")?>/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url("static")?>/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url("static")?>/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("static")?>/css/plugins/social-buttons.css" rel="stylesheet">
     <script src="<?php echo base_url()?>static/js/jquery-1.11.0.js"></script> 
 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
    /**
     * @name 根据数据id删除数据
     * @author Mr.jie 976759154@qq.com
 	 * @module 公共方法
     * @param table
 	 * @param id
	 * @param cotroller
 	 * @param functionname
     * @return
	 * @ctime 2016-07-05      
     * @version v1.0
    */
	function commDel(table,id,cotroller,functionname){
		if(confirm("您即将要删除数据编号为 "+id+" 的此记录!")){
			window.location.href="<?php echo site_url("")?>"+cotroller+"/"+functionname+"?table="+table+"&id="+id;
		}else{return false;}
	}

    /**
     * @name 删除选中数据
     * @author Mr.jie 976759154@qq.com
 	 * @module 公共方法
     * @param table
 	 * @param targetSelctedName 选择项元素名称
	 * @param cotroller
 	 * @param functionname
     * @return      
	 * @ctime 2016-07-05
     * @version v1.0
    */
	function commDelSelected(table,targetName,cotroller,functionname){
		var selectedList=document.getElementsByName(targetName);
		var selectedIds=[];
		var idsStr="";
		for(var i=0;i<selectedList.length;i++){
			var selected=selectedList[i];
			if(selected.checked){
				if(selectedIds.length>0){
					idsStr+=",";
				}				
				selectedIds[selectedIds.length]=selected.value;	
				idsStr+=selectedIds[selectedIds.length-1];		
			}
		}

		if(selectedIds.length<1){
			alert("请选中要删除的记录");
			return false;
		}

		if(confirm("确定，删除选中数据编号为:  "+idsStr+"  的记录？")){
			window.location.href="<?php echo site_url()?>"+cotroller+"/"+functionname+"?table="+table+"&idStr="+idsStr;
		}
		else{return false;}
	}
    /**
     * @name 选中数据
     * @author Mr.jie 976759154@qq.com
 	 * @module 公共方法
     * @param thisObj 
 	 * @param targetSelctedName 选择项元素名称
     * @return      
     * @ctime 2016-07-05
     * @version v1.0
    */
	function commSelectedAll(thisObj,targetSelctedName){
		var selectedContentList=document.getElementsByName(targetSelctedName);	
		var isAllChecked=true;
		for(var i=0;i<selectedContentList.length;i++){
			if(!selectedContentList[i].checked){
				isAllChecked=false;
			}
			thisObj.value=="all"?selectedContentList[i].checked=thisObj.checked:false;
		}		
		thisObj.value!="all"?document.getElementById("selectedAll").checked=isAllChecked:false;		
	}

	/*********************************************************/

	function isdel(table,id){
			if(confirm("你即将要删除此记录!")){
				window.location.href="<?php echo site_url("admin/")?>/"+table+"/del/"+id;
				}
			else{return false;}
	}

	function cmsisdel(table,id,functionname){
		if(confirm("你即将要删除此记录!")){
			window.location.href="<?php echo site_url("cms")?>/"+functionname+"?table="+table+"&id="+id;
			}
		else{return false;}
	}

	function cmsDelSelected(table){
		var selectedContentList=document.getElementsByName("contentCheck");
		var selectedContentIds=[];
		for(var i=0;i<selectedContentList.length;i++){
			var selectedContent=selectedContentList[i];
			if(selectedContent.checked){
				selectedContentIds[selectedContentIds.length]=selectedContent.value;
			}
		}

		if(selectedContentIds.length<1){
			alert("请选中要删除的记录");
			return false;
		}

		if(confirm("确定，删除选中记录？")){
			var idsStr="";
			for(var i=0;i<selectedContentIds.length;i++){
				if(i>0){
					idsStr+=",";
				}
				idsStr+=selectedContentIds[i];
			}
			window.location.href="<?php echo site_url("cms/delAll")?>?table="+table+"&idStr="+idsStr;
		}
		else{return false;}
	}
	
	function delSelected(table){
		var selectedContentList=document.getElementsByName("contentCheck");
		var selectedContentIds=[];
		for(var i=0;i<selectedContentList.length;i++){
			var selectedContent=selectedContentList[i];
			if(selectedContent.checked){
				selectedContentIds[selectedContentIds.length]=selectedContent.value;
			}
		}

		if(selectedContentIds.length<1){
			alert("请选中要删除的记录");
			return false;
		}

		if(confirm("确定，删除选中记录？")){
			var idsStr="";
			for(var i=0;i<selectedContentIds.length;i++){
				if(i>0){
					idsStr+=",";
				}
				idsStr+=selectedContentIds[i];
			}
			window.location.href="<?php echo site_url("admin/delAll")?>?table="+table+"&idStr="+idsStr;
		}
		else{return false;}
	}

	function isSelectedAll(thisObj){
		var selectedContentList=document.getElementsByName("contentCheck");	
		var isAllChecked=true;
		for(var i=0;i<selectedContentList.length;i++){
			if(!selectedContentList[i].checked){
				isAllChecked=false;
			}
			thisObj.value=="all"?selectedContentList[i].checked=thisObj.checked:false;
		}		
		thisObj.value!="all"?document.getElementById("selectedAll").checked=isAllChecked:false;		
	}
</script>
<style>
.navbar-static-top {
    background: #c26e2a;
}
.navbar-top-links >li>a:hover, .navbar-top-links >li>a:focus {
    text-decoration: none;
    background-color: #734727;
}
.navbar-top-links .open>a, .navbar-top-links .open>a:hover, .navbar-top-links .open>a:focus {
    background-color: #8c591a;
    border-color: #c7760e;
}
</style>
</head>

<body style="overflow-x: hidden;">

    <div id="wrapper">
 
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url("admin")?>">教育信息工作管理系统</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
               <a target="_blank" class="dropdown-toggle" href="<?php echo site_url();?>">
                        <i class="glyphicon glyphicon-home"></i>  浏览首页
                    </a>
               </li>
                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                      <!--  <li><a href="#"><i class="fa fa-user fa-fw"></i>用户资料</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
                        </li> 
                        <li class="divider"></li>-->
                        <li><a href="<?php echo site_url("action/logout")?>"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li >
                            <a href="<?php echo site_url("admin")?>"><i class="fa fa-dashboard fa-fw"></i> 管理台</a>
                        </li>
                      
                      
                     <?php   $menus = ($this->user->getUserMenus());?>
                      <?php if (isset($menus)):?>
          			<?php foreach($menus as $menu):?>
                        <li <?php if(isset($this->router)&&in_array($menu["item"]['menu_controller'],$this->router)):?>class="active"<?php endif?>>
                            <a href="#"><i class="glyphicon glyphicon-asterisk <?php echo $menu["item"]["menuclass"]?>"></i> <?php echo $menu["item"]['menu_title']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                             <?php  if (isset($menu["children"])):?>
               <?php foreach($menu["children"] as $sub_menu):?>
              	  			<?php if(is_array($sub_menu)):?>
                                <li>
                                    <a <?php if(isset($this->router)&&in_array($sub_menu["item"]['menu_method'],$this->router)):?>class="active"<?php endif?> href="<?php echo site_url( $sub_menu["item"]['menu_controller'].'/'.$sub_menu["item"]['menu_method'].$sub_menu["item"]['menu_param'])?>"><?php echo $sub_menu["item"]['menu_title'];?>    <?php if(isset($sub_menu["children"])):?>
                                <span class="fa arrow"></span><?php endif;?></a>
                                <?php if(isset($sub_menu["children"])):?>
                                <ul class="nav nav-third-level collapse">
                               
                             		<?php foreach($sub_menu["children"] as $third_menu):?>
                             		<li>
                                            <a href="<?php echo site_url( $third_menu["item"]['menu_controller'].'/'.$third_menu["item"]['menu_method'].$third_menu["item"]['menu_param'])?>"><?php echo $third_menu["item"]['menu_title'];?>
                                             <?php if(isset($third_menu["children"])):?>
                                					<span class="fa arrow"></span>
                                					<?php endif;?>	
                                            </a>
                                        	 <!-- 4级开始，揭哥你来 -->
                                			<?php if(isset($third_menu["children"])):?>                                			
                                				<ul class="nav nav-third-level collapse">
                                                	<?php foreach($third_menu["children"] as $fourth_menu):?>
                                                 		<li>
                                                    		<a href="<?php echo site_url( $fourth_menu["item"]['menu_controller'].'/'.$fourth_menu["item"]['menu_method'].$fourth_menu["item"]['menu_param'])?>">&nbsp;&nbsp;&nbsp;&nbsp;├<?php echo $fourth_menu["item"]['menu_title'];?>
            		                                             <?php if(isset($fourth_menu["children"])):?>
                                                					<span class="fa arrow"></span>
                                                					<?php endif;?>
                                                    		</a>
                                                    	
                                                			<?php if(isset($fourth_menu["children"])):?>                                			
                                                				<ul class="nav nav-third-level collapse">
                                                                	<?php foreach($third_menu["children"] as $fifth_menu):?>
                                                                 		<li>
                                                                    		<a href="<?php echo site_url( $fifth_menu["item"]['menu_controller'].'/'.$fifth_menu["item"]['menu_method'].$fifth_menu["item"]['menu_param'])?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▶<?php echo $fifth_menu["item"]['menu_title'];?></a>
                                                                    	</li>
                                                                 	<?php endforeach;?>
                                                                </ul>
                                                             <?php endif;?>	                                                    	
                                                    	</li>
                                                 	<?php endforeach;?>
                                                </ul>
                                             <?php endif;?>		
                                
                                        	 <!-- 4级结束，揭哥你来 -->
                                        </li>
                             		<?php endforeach;?>
                             		</ul>
                                <?php endif;?>
                                </li>                                
                            <?php endif;?>
              	  			<?php endforeach;?>   
              	  			 <?php endif;?>                      
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                      <?php endforeach;?>
          			  <?php endif;?>  
                      
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>