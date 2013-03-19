<script type="template/javascript" id="formtype-edit-modal-template">	
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

<script type="template/javascript" id="formtype-edit-form-template">
    <form class="form-horizontal">
	    <div class="control-group">
		    <label class="control-label" for="form_code">Form Code</label>
		    <div class="controls">
		    	<input type="text" name="form_code" placeholder="Code" value="<%= form_code %>" />
		    	<span id="form_code"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="form">Form</label>
		    <div class="controls">
		    	<input type="text" name="form" placeholder="Form Type" value="<%= form %>"/>
		    	<span id="form"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="description">Description</label>
		    <div class="controls">
		    	<textarea name="description" placeholder="Description"></textarea>
		    	<span id="description"></span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="annual_allocation">Default Annual Allocation</label>
		    <div class="controls">
		    	<input type="text" name="annual_allocation" value="5" />
		    	<span id="annual_allocation"></span>
			    <span class="help-block">
			    	<p><small>The number of days to allocate to each employee by default.</small></p>
			    </span>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="accumulation">Accumulation</label>
		    <div class="controls">
		    	<input type="text" name="accumulation" value="<%= accumulation %>"/>
		    	<span id="accumulation"></span>
		    </div>
	    </div>
		<div class="control-group">
		    <label class="control-label" for="gender">Employment Status</label>
		    <div class="controls">
				<select class="input-medium" name="employment_status_id">
					<option value="0">All</option>
					<% _.each(employment_statuses, function(employment_status) { %>
						<option value="<%= employment_status.option_id %>"
							<% if (employment_status.option_id == employment_status_id) { %> selected <% } %>
							>
							<%= employment_status.option %>
						</option>
					<% }); %>
				</select>
				<span id="employment_status_id"></span>
		    </div>
	    </div>		    
	    <div class="control-group">
		    <label class="control-label" for="gender">Gender</label>
		    <div class="controls">
	    		<% 
	    		genderyes = '';
	    		genderno = '';
	    		genderall = '';
	    		if (gender == 'male') {
	    			genderyes = 'checked';
	    		} else if (gender == 'female') {
	    			genderno = 'checked';
	    		} else {
	    			genderall = 'checked';
	    		}
	    		%>
		    	<label class="radio inline">
		    		<input type="radio" name="gender" value="all" <%= genderall %>>All
		    	</label>	    		
		    	<label class="radio inline">
		    		<input type="radio" name="gender" value="male" <%= genderyes %>>Male
		    	</label>
		    	<label class="radio inline">
		    		<input type="radio" name="gender" value="female"  <%= genderno %>>Female
		    	</label>
		    	<span id="gender"></span>
		    </div>		    
	    </div>
		<div class="control-group">
		    <label class="control-label" for="gender">Civil Status</label>
		    <div class="controls">
				<select class="input-medium" name="civil_status_id">
					<option value="0">All</option>
					<% _.each(civil_status_types, function(civil_status_type) { %>
						<option value="<%= civil_status_type.option_id %>"
							<% if (civil_status_type.option_id == civil_status_id) { %> selected <% } %>
							>
							<%= civil_status_type.option %>
						</option>
					<% }); %>
				</select>
				<span id="civil_status_id"></span>				
		    </div>
	    </div>	    
	    <div class="control-group">
		    <label class="control-label" for="track">Track</label>
		    <div class="controls">
		    	<label class="radio inline">
		    		<% 
		    		trackyes = '';
		    		trackno = '';
		    		if (track == 1) {
		    			trackyes = 'checked';
		    		} else {
		    			trackno = 'checked';
		    		}
		    		%>
		    		<input type="radio" name="track" value="1" <%= trackyes %>>Yes
		    	</label>
		    	<label class="radio inline">
		    		<input type="radio" name="track" value="0"  <%= trackno %>>No
		    	</label>		    	
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="prorate">Pro-rated</label>
		    <div class="controls">
		    	<label class="radio inline">
		    		<% 
		    		prorateyes = '';
		    		prorateno = '';
		    		if (prorate == 1) {
		    			prorateyes = 'checked';
		    		} else {
		    			prorateno = 'checked';
		    		}
		    		%>
		    		<input type="radio" name="prorate" value="1" <%= prorateyes %>>Yes
		    	</label>
		    	<label class="radio inline">
		    		<input type="radio" name="prorate" value="0"  <%= prorateno %>>No
		    	</label>	    	
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="convertible">Convertible</label>
		    <div class="controls">
		    	<label class="radio inline">
		    		<% 
		    		convertibleyes = '';
		    		convertibleno = '';
		    		if (convertible == 1) {
		    			convertibleyes = 'checked';
		    		} else {
		    			convertibleno = 'checked';
		    		}
		    		%>
		    		<input type="radio" name="convertible" value="1" <%= convertibleyes %>>Yes
		    	</label>
		    	<label class="radio inline">
		    		<input type="radio" name="convertible" value="0"  <%= convertibleno %>>No
		    	</label>
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="tenure">Tenure (months)</label>
		    <div class="controls">
		    	<input type="text" name="tenure" value="<%= tenure %>"/>
			    <span class="help-block">
			    	<p><small>The number of months required to be able to avail of this time off.</small></p>
			    </span>
			    <span id="tenure"></span>
		    </div>		    
	    </div>	    
	    <div class="control-group action-buttons">
		    <div class="controls">
			    <button class="btn">Cancel</button>
			    <button type="submit" class="btn btn-primary">Save</button>
		    </div>
	    </div>
    </form>
</script>