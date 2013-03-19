<script type="template/javascript" id="form-edit-modal-template">	
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3>
		<% 
		if (form_application_id !== undefined && form_application_id > 0) { 
			print(form_type);
			if (locked) {
				print(' (' + status.capitalize() + ')');
			}
		} else {
			print('Apply for a Form');
		}
		%>
		</h3>
	</div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">
		<a data-dismiss="modal" class="btn" href="#">Close</a>
		<% if (!locked) { %>
			<% if (form_application_id !== undefined && form_application_id > 0) { %>
				<a class="btn btn-danger delete" rel="tooltip" title="Delete" href="#">
	                <i class="icon-trash icon-white"></i>&nbsp;Delete
	            </a>
			<% } %>
			<button class="btn btn-primary">
				<% if (form_application_id !== undefined && form_application_id > 0) { %>
				Update Application
				<% } else { %>
				Create Application
				<% } %>
			</button>
		<% } %>
	</div>	
</script>

<!----- Edit form -------->
<script type="template/javascript" id="form-edit-form-template">
	<form class="form-horizontal">
	    <div class="control-group">
		    <label class="control-label" for="employee_id">Employee</label>
		    <div class="controls">
		    	<a target="_blank" href="<?php echo site_url('profile');?>/<%= employee.hash %>"><%= employee.full_name %></a>
		    	<span id="employee_id"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="form_id">Form Type</label>
		    <div class="controls">
				<select class="input-medium" name="form_type_id">
					<option value="">Select&hellip;</option>
					<% _.each(form_types, function(form_type) { %>
						<option value="<%= form_type.form_id %>"
							<% if (form_type.form_id == form_type_id) { %> selected <% } %>
							>
							<%= form_type.form %>
						</option>
					<% }); %>
				</select>
				<span id="form_type_id"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="date_from">Start Date</label>
		    <div class="controls">
				<input type="hidden" name="date_from" value="<%= date_from %>"/>	    	
				<input type="text" class="datepicker input-medium" rel="date_from" readonly/>
		    	<span id="date_from"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="date_to">End Date</label>
		    <div class="controls">
				<input type="hidden" name="date_to" value="<%= date_to %>"/>
				<input type="text" class="datepicker input-medium" rel="date_to" readonly/>	    	
		    	<span id="date_to"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="reason">Message to your Manager</label>
		    <div class="controls">
		    	<textarea type="text" name="reason" placeholder="Enter a reason"><%= reason %></textarea>
		    	<span id="reason"></span>		    
		    </div>
	    </div>
	    <% if (can_approve) { %>
	    <div class="control-group">
		    <label class="control-label" for="status_id">Status</label>
		    <div class="controls">
				<select class="input-medium" name="status_id">
					<option value="">Select&hellip;</option>
					<% _.each(status_types, function(status_type) { %>
						<option value="<%= status_type.option_id %>"
							<% if (status_type.option_id == status_id) { %> selected <% } %>
							>
							<%= status_type.form %>
						</option>
					<% }); %>
				</select>
				<span id="status_id"></span>
		    </div>
	    </div>    
	    <% } %>
	    <div class="control-group action-buttons">
		    <div class="controls">
			    <button class="btn">Cancel</button>
			    <button type="submit" class="btn btn-primary">Submit Application</button>
		    </div>
	    </div>
	</form>
</script>

<!---- Viewing ///////////////////////////////////////-->

<script type="template/javascript" id="form-view-template">
	<dl class="dl-horizontal">
	    <dt>Employee</dt>		    
		<dd>
			<a target="_blank" href="<?php echo site_url('profile');?>/<%= employee.hash %>">
				<%= employee.full_name %>
			</a>
		</dd>

	    <dt>Form Type</dt>
		<dd><%= form_type %></dd>
	    
	    <dt>Start Date</dt>
		<dd><%= $.datepicker.formatDate('D, M dd', date_from) %></dd>
	    
	    <dt>End Date</dt>
		<dd><%= $.datepicker.formatDate('D, M dd', date_to) %></dd>
	    
	    <dt>Message</dd>
		<dd><%= reason %></dd>
	</dl>
</script>

<div id="form-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete form application</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this form application.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>