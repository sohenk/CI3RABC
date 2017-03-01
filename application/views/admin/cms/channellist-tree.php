<?php $this->load->view("admin/header")?>

<script src="<?php echo base_url("static")?>/js/jquery-ui-1.10.3.custom.min.js"></script>

<style>
<!--
/* 无限树 样式 */
.tto_sortable { list-style: none; margin: 0; padding: 0; }
.tto_sortable ul { list-style: none; margin: 0 0 0 2em; padding: 0; display: none; }
.tto_sortable .item { width: 100%; text-align: left; margin: 2px 0; }
.tto_sortable > li { margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px dotted #aaa; }
.emptyContainer { min-height: 30px; background: #eee; border: 1px dashed #ccc; }

.placeholder { background: #EEE; border: 1px dashed #ccc; border-radius: 3px; }
        
.form-group { display:block !important; margin-bottom:12px !important; }
.form-control { display: inline !important; width:200px !important;}
-->
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">栏目列表  <a class="btn btn-info btn-xs" href="<?php echo site_url("cms/addchannel")?>">添加栏目</a>
      </h1>
      
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="row">
   	<div class="col-lg-12">

		<div class="panel panel-default">
			<div class="panel-heading">
<!-- 				 <button type="button" class="btn btn-xs btn-info saveCategorySort" >保存栏目排序修改</button> -->
				
			</div>
			<div class="panel-body">
				<div class="category">
					<?php echo $category->render(); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="col-lg-7">
	  <div class="affix">
		<form class="navbar-form navbar-left" role="search" method="post" action="<?php echo site_url("cms/category_modify/") ?>">

		  <div class="form-group">
			<label for="name">名称：</label>
			<input name="name" id="name" type="text" class="form-control" placeholder="名称"> (国名经济行业分类名称)
		  </div>
		  <div class="form-group">
			<label for="parentid">父级ID：</label>
			<input type="text" name="parentid" id="parentid" class="form-control" placeholder="parentid"> (这个栏目的父级ID)
		  </div>
		 
		  <input type="hidden" name="cid" id="id" class="form-control" value="">
		  <button type="submit" class="btn btn-default">修改</button>
		</form>
	  </div>
	</div> -->
   </div>
        <script>
$(function(){

	/**
	* 注：每次排序后，需点击保存按钮后，排序才会真正写入数据库
	* 栏目点击后右侧的数据显示，是每次通过ajax读取数据库完成，
	* 如果对栏目排序后没有保存，则点击栏目，右侧的数据是无法正
	* 确现实的，请注意。
	*/

	// 点击栏目现显示目信息
	
	$(".tto_sortable").on('click', '.item', function(){
		var $el = $(this),
			id = $el.data('id');

		$el.parent().find('ul').toggle();

		/*$.ajax({
			type: "post",
			dataType: "jsonp",
			jsonp:"callback",
			url: '<?php echo base_url("cms/apiGetCategories/'+id+'") ?>',
			data:{"opp":"send", "id":id},
			async: false,
			success: function(data){
				$.each(data, function(key, value){
					$("#"+key).val(data[key]);
				});
			}
		});*/
	});
	// 为最下级目录添加空ul标签
	$('.tto_sortable').find('.item').each(function(key, el){
		var $el = $(el);
		if(!$el.parent().find('.children').length){
			$el.parent().append('<ul class="children sortable emptyContainer"></ul>')
		}
	});

	// 拖拽排序
	$('.category').find('.sortable').sortable({
		'tolerance':'pointer',
		'cursor':'pointer',
		'items':'li',
		'axi': 'y',
		'placeholder':'placeholder',
		'forcePlaceholderSize': true,
		'connectWith': '.tto_sortable ul',
		'update': function(evt, ui){
			ui.item.parent().removeClass('emptyContainer')
		}
	});

	var treeData = Object()
	treeData['default'] = <?php echo $category->getData(); ?>;

	$('.saveCategorySort').on('click', function(){
		
		var sortData = resort($(this).parent().parent().find('.tto_sortable').find('.item'));

		$.each(sortData, function(k, v){
			treeData['default'][k]['parentid'] = v.slice(-2, v.length)[0];
		});

		$.post('<?php echo site_url("api/category"); ?>', {category: JSON.stringify(treeData['default'])}, function(result){
			if($(result).find('status').text()){
				alert($(result).find('msg').text());
			}
		});

	});

	var resort = function($element){
		var tmp = Array(),
			result = Object(),
			data = Object();

		var _sort = function($ele){
			$('.category').find($ele).each(function(key, el){
				var $el = $(el);
				tmp.push($el.data('id'));
				if(!$el.parent().parent().parent().hasClass('category')){
					_sort($el.parent().parent().parent().find('> .item'));
				}
				result['data'] = tmp.reverse();
				tmp = [];
			});

			$.each(result, function(key, val){
				if(val != ''){
					data[val.slice(-1, val.length)] = val;
				}
			});

			return data;
		}

		return _sort($element);
	}

});
</script>
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
