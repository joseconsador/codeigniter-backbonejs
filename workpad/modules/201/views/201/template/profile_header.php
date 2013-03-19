<?php
add_js('modules/thankyou/view.js');
add_js('modules/employee/model.js');
add_js('modules/thankyou/model.js');
?>

<div id="profile-header" class="well">

	<div class="btn-group pull-right">
		<a class="btn btn-large btn-success" href="#modalMessage" data-toggle="modal"> 
			Contact <?php echo $first_name;?>
		</a>
		<a class="btn btn-large btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="#modalThankyou" data-toggle="modal"><i class="icon-thumbs-up"></i> Send Thank You </a></li>
			<li><a href="#myPrintProfile" data-toggle="modal"><i class="icon-print"></i> Print Profile </a></li>
		</ul>            
	</div>

	<!-- SEND A MESSAGE BOX -->	
	<div class="modal fade hide" id="modalMessage">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Send message to <?php echo $first_name; ?></h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>								
					<label>Message</label>
					<textarea name="message" class="span5" rows="6" placeholder="Type something…"></textarea>
					<span class="label hidden" id="messaging-message"></span>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancel</a>
			<a href="#" class="btn btn-primary" id="message-send">Send Message</a>
		</div>	
	</div>
	<!-- PROFILE -->
	<img src="<?php echo $thumbnail_url;?>" id="user-photo">
	<h2><?php echo $full_name;?></h2>

	<p class="grey" style="padding-bottom:8px;"><?php echo $position;?> of <?php echo $company;?></p>

    <address>
      <abbr title="Email"> <i class="icon-envelope"></i></abbr>
      <a href="mailto:<?php echo $email;?>"> <?php echo $email;?> </a>
      <abbr title="Messenger"> <i class="icon-comment"></i></abbr> <span id="im-primary"></span>
  	  <abbr title="Mobile"> <i class="icon-signal"></i></abbr> <span id="mobile-primary"></span>
    </address>

	<div class="clearfix"></div>

</div>	

<?php $this->load->view('thankyou/modal_thankyou');?>

<script type="text/javascript">
	$(function() {
	    var messageModel = new MessageModel({recipient_id: <?php echo $user_id;?> });	    
	    var modalMessageForm  = new ModalMessageForm({model: messageModel});	    
		var thankyouModel  = new ThankyouModel({user_id: <?php echo $this->user->user_id?>, recipient_id:<?php echo $user_id;?>});
		var thankyouModalForm = new ThankyouModalForm({model:thankyouModel});
	});
</script>