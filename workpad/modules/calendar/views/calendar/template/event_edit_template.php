<script type="template/javascript" id="event-edit-modal-template">	
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3>
		<% if (is_participant) { %>
			<%= title %> 			
		<% } else { %>
		Set a Calendar Event
		<% } %>
		</h3>
		<% 		
		if (is_participant) {			
			if (status_id == Involved.prototype.accepted_status) {
				print('<span class="label label-info">You are attending this event.</span>');
			} else if (status_id == Involved.prototype.denied_status) {
				print('<span class="label label-important">You are not attending this event.</span>');
			} else if (status_id == Involved.prototype.tentative_status) {
				print('<span class="label label-warning">You are still tentative for this event.</span>');
			}
		}
		%>				
	</div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">
		<% if (!is_participant) { %>	
			<a data-dismiss="modal" class="btn" href="#">Close</a>
			<% if (event_id !== undefined && event_id > 0) { %>
				<a class="btn btn-danger delete" rel="tooltip" title="Delete" href="#">
	                <i class="icon-trash icon-white"></i>&nbsp;Delete
	            </a>
			<% } %>
			<button class="btn btn-primary save-event">
				<% if (event_id !== undefined && event_id > 0) { %>
				Update Event
				<% } else { %>
				Create Event
				<% } %>
			</button>
		<% } else { %>
			Attending?
			<button class="btn btn-primary attend-event" type="button">Yes</button>
			<button class="btn btn-danger reject-event" type="button">No</button>
			<button class="btn btn-warning tentative-event" type="button">Tentative</button>
		<% } %>
	</div>	
</script>

<script type="template/javascript" id="event-edit-form-template">
	<form class="form-horizontal">
	    <div class="control-group">
		    <label class="control-label" for="title">Title</label>
		    <div class="controls">
				<input type="text" class="input-xlarge" name="title" value="<%= title %>" placeholder="ex: Birthday Party" />				
		    	<span id="title"></span>
		    </div>
	    </div>	
	    <div class="control-group">
		    <label class="control-label" for="description">Details</label>
		    <div class="controls">
		    	<textarea type="text" class="input-xlarge" name="description" placeholder="Add more info"><%= description %></textarea>
		    	<span id="description"></span>		    
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="location">Where</label>
		    <div class="controls">
				<input type="text" name="location" class="input-xlarge" value="<%= location %>" id="location_search"/>
		    	<span id="location"></span>
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
		    <label class="control-label" for="date_to">Invite colleagues</label>
		    <div class="controls">				
				<input type="text" class="input-xlarge" name="" id="search-employee" placeholder="Type a name of a colleague" />
		    </div>
	    </div>

	    <div class="control-group hidden">
		    <label class="control-label" for="date_to">Invited</label>
		    <div class="controls">
				<div class="well" id="involved-container">
				<% _.each(involved, function(i) { 
					name_display = i.full_name;

					if (i.status_id == Involved.prototype.accepted_status) {
						name_display += ' (Attending)';
					} else if (i.status_id == Involved.prototype.denied_status) {
						name_display += ' (Not Attending)';
					}
					%>
		            <a class="label label-info" ref="<%= i.user_id %>"><i class="icon-remove icon-white"></i>&nbsp;<%= name_display %></a>
				<%	}); %>
				</div>
		    </div>
	    </div>

	    <div class="control-group">
		    <label class="control-label" for="whole_day">Whole day</label>
		    <div class="controls">
		    	<label class="radio inline">
		    		<% 
		    		whole_dayyes = '';
		    		whole_dayno = '';
		    		if (whole_day == 1) {
		    			whole_dayyes = 'checked';
		    		} else {
		    			whole_dayno = 'checked';
		    		}
		    		%>
		    		<input type="radio" name="whole_day" value="1" <%= whole_dayyes %>>Yes
		    	</label>
		    	<label class="radio inline">
		    		<input type="radio" name="whole_day" value="0"  <%= whole_dayno %>>No
		    	</label>		    	
		    </div>
	    </div>
	    <div class="control-group">
		    <label class="control-label" for="color">Color</label>
		    <div class="controls">
            	<div class="input-append color colorpicker" data-color="<%= color %>" data-color-format="rgb">
		    		<input type="text" value="<%= color %>" name="color" readonly />
		    		<span class="add-on"><i style="background-color: <%= color %>"></i></span>
		    	</div>
		    </div>
	    </div>
	    <div class="control-group action-buttons">
		    <div class="controls">
			    <button class="btn">Cancel</button>
			    <button type="submit" class="btn btn-primary">Create Event</button>
		    </div>
	    </div>
	</form>
</script>

<script type="template/javascript" id="event-view-template">
	<dl class="dl-horizontal">
	    <dt>Organizer</dt>		    
		<dd><%= organizer %></dd>

	    <dt>Details</dt>
		<dd><%= description %>&nbsp;</dd>
	    
	    <dt>Where</dt>
		<dd><%= location %>&nbsp;</dd>
	    
	    <dt>Dates</dt>
		<dd><%= $.datepicker.formatDate('D, M dd', new Date(start)) %> to <%= $.datepicker.formatDate('D, M dd', new Date(end)) %></dd>

	    <dt>Invited</dt>
		<dd>
			<div id="involved-container">
			<% _.each(involved, function(i) { 
					name_display = i.full_name;
					if (i.status_id == Involved.prototype.accepted_status) {
						name_display += ' (Attending)';
					} else if (i.status_id == Involved.prototype.denied_status) {
						name_display += ' (Not Attending)';
					}
				%>
	            <a class="label" ref="<%= i.user_id %>"><%= name_display %></a>
			<%	}); %>
			</div>
		</dd>
	</dl>
</script>

<div id="event-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete event</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this event.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>