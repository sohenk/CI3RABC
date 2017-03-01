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
                                    <form role="form" method="post" action="#">
                                        <div class="form-group">
                                            <label>标题</label>
                                           	  <input class="form-control" name="name" value="<?php if(isset($cms_curchannel->name)){echo $cms_curchannel->name;} ?>" placeholder="标题">
                                        </div>
                                     <div class="form-group">
                                            <label>上级目录</label>
                                     <select name="parentid" id="parentid" class="form-control col-md-3">
                                        <option value="0">无</option>
                                        <?php foreach($this->channelDepthList as $k=>$v):?>                                       
                                        <option value="<?php echo $v->id?>" 
                                        <?php
                                            if(isset($cms_curchannel)){
                                                if ($v->id==$cms_curchannel->id){ echo 'disabled="disabled" ';}
                                                if($cms_curchannel->parentid==$v->id){echo 'selected';}
                                            }?>><?php $htmlStr="";for($i=0;$i<$v->depth;$i++){$htmlStr.="&#160;&#160;&#160;&#160;";} echo $htmlStr.($v->depth>0?'├':"").$v->name?></option>
                                       
                                        <?php endforeach;?>
                                     </select>
                                        </div>
                                        
                                        
<div class="form-group">
                                            <label>跳转链接</label>
                                           	  <input class="form-control" name="outlink" value="<?php if(isset($cms_curchannel->outlink)){echo $cms_curchannel->outlink;} ?>" placeholder="跳转链接">
                                        </div>
                                        <div class="form-group">
                                            <label>显示菜单</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="visible"  value="1" <?php echo !isset($cms_curchannel->visible)||$cms_curchannel->visible>0?'checked="checked"':"";?>>是
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="visible"  value="0" <?php echo isset($cms_curchannel->visible)&&$cms_curchannel->visible<1?'checked="checked"':"";?>>否
                                            </label>
                                            
                                        </div>                                                              
                                      <div class="form-group">
                                            <label>内容页模板</label>
                                           	 <select name="contenttemplate" class="form-control col-md-3">
                                     			<option <?php if(isset($cms_curchannel->contenttemplate)){if($cms_curchannel->contenttemplate=='details'){echo 'selected';}}?> value="details">默认模板</option>
                                     			<option <?php if(isset($cms_curchannel->contenttemplate)){if($cms_curchannel->contenttemplate=='details-all'){echo 'selected';}}?> value="details-all">全屏模板</option>
		                                     </select>
                                     </div>
                                                           
                                      <div class="form-group">
                                            <label>列表页模板</label>
                                           	 <select name="channeltemplate" class="form-control col-md-3">
                                     			<option <?php if(isset($cms_curchannel->channeltemplate)){if($cms_curchannel->channeltemplate=='wordlist'){echo 'selected';}}?> value="wordlist">文字列表</option>
                                     			<option <?php if(isset($cms_curchannel->channeltemplate)){if($cms_curchannel->channeltemplate=='helplist'){echo 'selected';}}?> value="helplist">帮助列表</option>
                                     			<option <?php if(isset($cms_curchannel->channeltemplate)){if($cms_curchannel->channeltemplate=='videolist'){echo 'selected';}}?> value="videolist">视频列表</option>        		
        		                             </select>
                                     </div>                                                                            
                                        
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
                             <?php if(isset($cms_curchannel->thumb)):?>
                                <div class="upload-pre-item"><img src="<?php echo $cms_curchannel->thumb?>"/></div>
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
		        'fileType'	  :  'image/*',
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
                                     
                                       <input type="hidden" id="thumb" name="thumb" value="<?php if(isset($cms_curchannel->thumb)){echo $cms_curchannel->thumb;} ?>">
                                     
                                       <?php if(isset($cms_curchannel->id)):?>
                                        <input type="hidden" name="id" value="<?php {echo $cms_curchannel->id;} ?>">
                                        
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