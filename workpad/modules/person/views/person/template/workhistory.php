<script type="template/javascript" id="workhistory-item-template">
	<% 
	fdate = new Date(from_date);
	tdate = new Date(to_date);
	%>
	
	<td><%= company%>&nbsp;</td>
	<td><%= address%>&nbsp;</td>
	<td><%= nature%>&nbsp;</td>
	<td><%= position%>&nbsp;</td>
	<td><%= monthNames[fdate.getMonth()] %> <%= fdate.getUTCFullYear() %> - <%= monthNames[tdate.getMonth()] %> <%= tdate.getUTCFullYear() %>&nbsp;</td>
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="workhistory-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 6;
	} else {
		span = 5;
	}
	%>

	<td colspan="<%= span %>">
		Immediate: <%= supervisor_name%>
		<br />
		Duties: <%= duties%>
		<br />
		Reason for leaving: <%= reason_for_leaving%>
	</td>	
</script>

<script type="template/javascript" id="edit-workhistory-template">
	<form class="form-horizontal">	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="company">Company</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= company %>" name="company"/>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="position">Position</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= position %>" name="position"/>
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

				<div class="control-group">
					<label class="control-label" for="supervisor_name">Supervisor</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= supervisor_name %>" name="supervisor_name"/>
					</div>
				</div>							
			</div>
			
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="address">Address</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= address %>" name="address"/>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="nature">Nature</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= nature %>" name="nature"/>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="last_salary">Last Salary</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= last_salary %>" name="last_salary" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="duties">Duties</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= duties %>" name="duties" />
					</div>
				</div>								

				<div class="control-group">
					<label class="control-label" for="reason_for_leaving">Reason for Leaving</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= reason_for_leaving %>" name="reason_for_leaving"/>
					</div>
				</div>	
			</div>
		</div>
	</form>
</script>

<div id="work-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Work Experience</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this work experience.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>