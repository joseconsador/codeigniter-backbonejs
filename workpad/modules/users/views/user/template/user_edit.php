<script type="template/javascript" id="user-edit-modal-template">	
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3><%= title %></h3>
	</div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">
		<a data-dismiss="modal" class="btn" href="#">Close</a>
		<button class="btn btn-primary">Save</button>
	</div>	
</script>

<script type="template/javascript" id="user-edit-form-template">
	<form class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input type="text" id="email" name="email" placeholder="Email" value="<%= email %>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="login">Login</label>
			<div class="controls">
				<input type="text" id="login" name="login" placeholder="Login" value="<%= login %>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
				<input type="password" id="password" name="password" placeholder="Password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
				<input type="text" id="first_name" name="first_name" placeholder="First name" value="<%= first_name %>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="last_name">Last Name</label>
			<div class="controls">
				<input type="text" id="last_name" name="last_name" placeholder="Last name" value="<%= last_name %>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="middle_name">Middle Name</label>
			<div class="controls">
				<input type="text" id="middle_name" name="middle_name" placeholder="Middle name" value="<%= middle_name %>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nick_name">Nickname</label>
			<div class="controls">
				<input type="text" id="nick_name" name="nick_name" placeholder="Nick name" value="<%= nick_name %>">
			</div>
		</div>
	</form>	
</script>