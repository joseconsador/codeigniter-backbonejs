<div id="about-tab">
	<?php if ($own_profile):?>
		<div class="row-fluid">
			<div class="span4">
				<p>
				<button id="edit-btn" class="btn btn-primary">Edit</button>
				<button id="save-btn" class="btn btn-primary" style="display:none;">Save</button>
				<button id="cancel-btn" class="btn">Cancel</button>				
				</p>
			</div>
		</div>
		<div id="alert-div"></div>

		<script type="text/template" id="alertTemplate">
			<div class="alert alert-<%= type %>">
				<button class="close" data-dismiss="alert" type="button">×</button>
				<%= message %>
			</div>
		</script>
		<?php 
		if (count($about) == 0) {
			$about = array('user_id' => $user_id);
		}

		?>
		<script type="text/javascript">
		    $(document).ready(function () {
		    	$('.alert').alert();
		    	var about = <?php echo json_encode($about);?>;
		    	window.aboutModel = new AboutModel(about);
		    	var aboutView = new AboutView({model: aboutModel});
		    });
		</script>		
	<?php endif;?>
	<h5> About Me </h5>
		<p id="about_me" class="ab ab-txtarea"><?php echo _p($about, 'about_me');?></p>
	<h5> Talents & Hobbies </h5>
		<p id="talent" class="ab ab-txtarea"><?php echo _p($about, 'talent');?></p>
	<h5> Favorite TV Shows & Movies </h5>
		<p id="movies" class="ab ab-txtarea"><?php echo _p($about, 'movies');?></p>
	<h5> Favorite Music Artists & Songs </h5>
		<p id="music" class="ab ab-txtarea"><?php echo _p($about, 'music');?></p>
	<h5> Life Long Dreams </h5>
		<p id="dreams" class="ab ab-txtarea"><?php echo _p($about, 'dreams');?></p>
	<h5> Website </h5>
		<p id="website" class="ab ab-input"><?php echo anchor(_p($about, 'website'), '', 'target="_blank"');?></p>
</div>