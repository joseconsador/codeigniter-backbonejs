<script type="template/javascript" id="training-item-template">
	<% 
	fdate = new Date(from_date);
	tdate = new Date(to_date);
	%>

	<td><%= address %>&nbsp;</td>
	<td>
	<%= monthNames[fdate.getMonth()] %> <%= fdate.getDate() %>, <%= fdate.getUTCFullYear() %>  - 
	<%= monthNames[tdate.getMonth()] %> <%= tdate.getDate() %>, <%= tdate.getUTCFullYear() %>&nbsp;</td>
	<td><%= institution %>&nbsp;</td>
	<td><%= remarks %>&nbsp;</td>	
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="training-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 5;
	} else {
		span = 4;
	}
	%>

	<td colspan="<%= span %>">Course: <%= course %>&nbsp;</td>	
</script>

<script type="template/javascript" id="edit-training-template">
	<form class="form-horizontal">	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="course">Course</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= course %>" name="course"/>
					</div>
				</div>			

				<div class="control-group">
					<label class="control-label" for="from_date">Date From</label>
					<div class="controls">
						<input type="hidden" name="from_date" value="<%= from_date %>" />
						<input type="text" class="datepicker input-medium" rel="from_date"/>
					</div>
				</div>				

				<div class="control-group">
					<label class="control-label" for="to_date">Date To</label>
					<div class="controls">
						<input type="hidden" name="to_date" value="<%= to_date %>"/>
						<input type="text" class="datepicker input-medium" rel="to_date"/>
					</div>
				</div>							
			</div>
			
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="institution">Institution</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= institution %>" name="institution"/>
					</div>
				</div>			
				<div class="control-group">
					<label class="control-label" for="address">Address</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= address %>" name="address"/>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="remarks">Remarks</label>
					<div class="controls">
						<textarea name="remarks"><%= remarks %></textarea>
					</div>
				</div>
			</div>
		</div>
	</form>
</script>

<div id="training-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Training</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this training.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>								