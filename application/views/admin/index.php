<?php $this->load->view("admin/header")?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">你好 <?php echo $this->session->userdata('username')?>!</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           
            <!-- /.row -->
               <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div>栏目管理</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url("cms/channellist")?>">
                            <div class="panel-footer">
                                <span class="pull-left">查看详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
            </div>
                           
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div>文章管理</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url("cms/contentlist")?>">
                            <div class="panel-footer">
                                <span class="pull-left">查看详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

               <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div>用户管理</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url("admin/adminuserlist")?>">
                            <div class="panel-footer">
                                <span class="pull-left">查看详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

 <?php $this->load->view("admin/footer")?>