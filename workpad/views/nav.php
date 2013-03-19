	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo base_url();?>employee/dashboard" style="padding-top:10px;padding-right:15px;">
            <!-- span><font style="color:white">in</font>Sinc</span -->
            <img src="<?php echo base_url().'includes/img/logo.png';?>" alt="Emplopad" style="margin-top:-5px;">
          </a>
          <?php if (is_logged_in()):?>
          <ul class="nav">

              <li class="dropdown" id="notifications-container">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-white icon-bell"></i> 
                  <span class="label label-important counter"></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- here we instert the dropdown -->
                </ul>
              </li>

             <li class="dropdown" id="messages-container">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-white icon-comment"></i> 
                  <span class="label label-important counter"></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- here we instert the dropdown -->
                </ul>
              </li>
              <li class="divider-vertical"></li>
          </ul>
          
          <div class="nav-collapse">                            
            <?php $ci =& get_instance(); echo $ci->render_nav();?>
            
            <ul class="nav pull-right">

              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo $this->user->thumbnail_url;?>" height="22" width="22"> 
                  <strong><?php echo $this->user->first_name;?> <?php echo $this->user->last_name[0];?>.</strong> <b class="caret"></b>
                </a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url('profile');?>#/edit">Edit Profile</a></li>
                    <li><a href="<?php echo site_url('profile');?>#/contacts">Account Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo site_url('logout');?>">Logout</a></li>
                  </ul>
              </li>
            </ul>

             <form class="navbar-search pull-right">
              <input type="text"  class="tags search-query span2" placeholder="Search...">
            </form>

            <!-- End is logged in -->
            <?php endif;?>            
          </div><!-- /.nav-collapse -->

        </div>
      </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
<?php $this->load->view('template/message_notification_template'); ?>
<?php $this->load->view('template/notification_template'); ?>