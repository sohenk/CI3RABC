<?php $this->load->view("admin/header")?>
  
  
    <style type="text/css">
@import "<?php echo base_url()?>js/date/jquery.datepick.css";
</style>
    <style>
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
      <?php echo isset($cms_channelitem->name)?$cms_channelitem->name:"未归类"?>
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
                                    <form role="form" method="post" action="#" id="contentForm" onsubmit="return checkSubmit();">
                                       
                                       <div class="form-group">
                                            <label>栏目</label>
                                      <select name="cid" id="cid" class="form-control col-md-3">
                                         <option value="">无</option>
                                    	<?php foreach($this->channelDepthList as $k=>$v):?>
        								<?php $htmlStr="";for($i=0;$i<$v->depth;$i++){$htmlStr.="&#160;&#160;";} ?>
        								    <option value="<?php echo $v->id?>"
        								    <?php if(isset($cms_coupon)){
        								            if ($v->id==$cms_coupon->id){ echo 'disabled="disabled" ';}
        								            if($coupon->cid==$v->id){echo ' selected="selected" ';}        								       
        								        }
        								        if(isset($cms_channelitem)&&$cms_channelitem->id==$v->id){echo ' selected="selected" ';}
        								    ?>"><?php echo $htmlStr.($v->depth>0?'├':"").$v->name;?></option>                                                                
                                        <?php endforeach;?>                          
                                      </select>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>标题</label>
                                           	  <input class="form-control" name="title" value="<?php if(isset($coupon->title)){echo $coupon->title;} ?>" placeholder="标题">
                                        </div>
                                      <div class="form-group">
                                            <label>简介</label>
                                            <input class="form-control" name="description" value="<?php if(isset($coupon->description)){echo $coupon->description;} ?>" placeholder="简介">
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
                                        </div>
                                         <!-- <div class="form-group">
                                            <label>推荐位</label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="pos1" value="1" onchange="recommendationdo()" <?php if(isset($coupon->pos)&&strpos($coupon->pos, "1")){echo 'checked="checked"';} ?>>首页大图
                                            </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="pos2" value="2" onchange="recommendationdo()" <?php if(isset($coupon->pos)&&strpos($coupon->pos, "2")){echo 'checked="checked"';} ?>>首页推荐
                                            </label>
                                           <input type="hidden" id="pos" name="pos" value="<?php if(isset($coupon->pos)){echo $coupon->pos;} ?>"/>
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>排序</label>
                                            <input class="form-control" name="order" value="<?php if(isset($coupon->order)){echo $coupon->order;}else{ echo "0";} ?>" placeholder="简介">
                                        </div>
                                         -->
                                      <div class="form-group">
                                         <!-- 缩略图begin -->
                                      <div class="form-item cf">
                    <label class="item-label">标题图<span class="check-tips">
                                            </span></label>
                    <div class="controls">
                     
<div class="controls">
                            <input type="file" id="upload_picture_pic" >
                            
                            <a id="delthumb" onclick="javascript:void(0)" class="btn btn-xs btn-danger">删除题图</a>
                            <input type="hidden" id="cover_id_pic" value=""/>
                            <div class="upload-img-box">
                             <?php if(isset($coupon->thumb)):?>
                                <div class="upload-pre-item"><img src="<?php echo $coupon->thumb?>"/></div>
                             <?php endif?>
                            </div>
                          </div>
                     <script type="text/javascript" src="<?php echo base_url()?>static/uploadifive/jquery.uploadifive.min.js"></script>
         
<script type="text/javascript">
		
		$(function() {
			$('#upload_picture_pic').uploadifive({
				'auto'             : true,
				"width"           : 120, 
				 'buttonText':"选择文件",
				"fileObjName"     : "download",
		        'removeTimeout'	  : 1,
		        'fileType'	  :  'image/jpg,image/jpeg,image/png',
				'uploadScript'     : '<?php echo site_url("action/actionUploadify")?>',
				'onUploadComplete' :uploadPicturepic
			});
			$("#delthumb").click(function(){clearthumb();});
		});

		
		function clearthumb(){
			$("#cover_id_pic").parent().find('.upload-img-box').html(
	        		''
	        	);
	        	$("#thumb").val("");
		}
		
		
		function uploadPicturepic(file, data){
	    	var data = $.parseJSON(data);
	    	var src = '';
	        if(data.status){
	        	$("#cover_id_pic").val(data.id);
	        	src = data.path;
	        	$("#cover_id_pic").parent().find('.upload-img-box').html(
	        		'<div class="upload-pre-item"><img src="' + src + '"/></div>'
	        	);
	        	$("#thumb").val(data.path);
	        } else {
	        	updateAlert(data.info);
	        	setTimeout(function(){
	                $('#top-alert').find('button').click();
	                $(that).removeClass('disabled').prop('disabled',false);
	            },1500);
	        }
	    }
		
		
	</script>


                          </div>
                  </div>       
                                      <!-- 缩略图end -->
                                      </div> 
                                       
                                        
                                         <!-- <div class="form-group">
                                            <label>跳转链接（如果没有就不填）</label>
                                            <input class="form-control" name="outlink" value="<?php if(isset($coupon->outlink)){echo $coupon->outlink;} ?>" placeholder="跳转链接">
                                        </div> -->
                                        
                                     <!--    <div class="form-group">
                                            <label>标签</label>
                                            <input class="form-control" name="tags" value="<?php if(isset($coupon->tags)){echo $coupon->tags;} ?>" placeholder="标签">
                    	<p class="help-block">用英文的逗号分隔“,”例如：美食,旅游</p> 
                                        </div>-->  
                                      <div class="form-group">
                                            <label>内容</label>
                                              <script id="container" name="content" type="text/plain">
        <?php if(isset($coupon->content)){echo $coupon->content;} ?>
    </script>
<!--                                         	<p class="help-block">格式：2013-2014</p> -->
   <script type="text/javascript" src="<?php echo base_url("static/ueditor/")?>/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo base_url("static/ueditor/")?>/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
        	initialFrameWidth :'100%',//设置编辑器宽度
        	initialFrameHeight:380//设置编辑器高度
        	});
    </script>
                                        </div>
                                   
                                       <?php if(isset($coupon->id)):?>
                                        <input type="hidden" name="id" value="<?php {echo $coupon->id;} ?>">
                                        
                                        <?php endif;?>
                                        
                                        <input type="hidden" id="thumb" name="thumb" value="<?php if(isset($coupon->thumb)){echo $coupon->thumb;} ?>">
                                        
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
<script type="text/javascript">
function recommendationdo()					//选择推荐位
{
	document.getElementById("pos").value="";
	for (i=1;i<=2;i++)
	{
		if (document.getElementById("pos"+i).checked!="")
		{
			//if (document.getElementById("pos").value!="")
			//	document.getElementById("pos").value=document.getElementById("pos").value+",";
			document.getElementById("pos").value=","+document.getElementById("pos").value+document.getElementById("pos"+i).value+",";
		}
	}
}

	function checkSubmit(){
		var form=document.getElementById("contentForm");

		if(form.cid.value==""){
			alert("请选择栏目！");
			return false;
		}
		
		if(form.title.value==""){
			alert("请填写文章标题！");
			return false;
		}
	}
</script>

<?php $this->load->view("admin/footer")?>
