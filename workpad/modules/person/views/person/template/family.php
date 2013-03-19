<script type="template/javascript" id="family-item-template">
	<% birth_date = new Date(birth_date); %>

	<td><%= monthNames[birth_date.getMonth()] %> <%= birth_date.getDate() %>, <%= birth_date.getUTCFullYear() %>&nbsp;</td>
	<td><%= occupation %>&nbsp;</td>
	<td><%= employer %>&nbsp;</td>
	<td><%= education_type %>&nbsp;</td>
	<td><%= degree %>&nbsp;</td>
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="family-item-sub-template">
	<% 	if (actions != undefined && actions) {
		span = 6;
	} else {
		span = 5;
	} %>
	<td colspan="<%= span %>">

		<h5><%= relationship_type %> : <%= name %></h5>
		<% if (emergency_tag == 1) { %>
		<br />		
		<span class="pull-right">
			In case of emergency: 
			<i class="icon-signal" title="Contact No"></i> <%= emergency_contact %>
			<i class="icon-home" title="Address"></i> <%= emergency_address %>
		</span>
		<% } %>	
	</td>
</script>

<script type="template/javascript" id="edit-family-template">
	<form class="form-horizontal">	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="name">Name</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= name %>" name="name"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="relationship_id">Relationship</label>
					<div class="controls">
						<select class="input-medium" name="relationship_id">
							<option value="">Select&hellip;</option>
							<% _.each(relationshipTypes, function(relationshipType) { %>
								<option value="<%= relationshipType.option_id %>"
									<% if (relationshipType.option_id == relationship_id) { %> selected <% } %>
									>
									<%= relationshipType.option %>
								</option>
							<% }); %>
						</select>
					</div>				
				</div>
				<div class="control-group">
					<label class="control-label" for="birth_date">Birth Date</label>
					<div class="controls">
						<input type="hidden" name="birth_date" value="<%= birth_date %>"/>
						<input type="text" class="datepicker input-medium" rel="birth_date"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="occupation">Occupation</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= occupation %>" occupation="occupation"/>
					</div>
				</div>				
			</div>

			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="employer">Employer</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= employer %>" employer="employer"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="educational_attainment_id">Educational Attainment</label>
					<div class="controls">
						<select class="input-medium" name="educational_attainment_id">
							<option value="">Select&hellip;</option>
							<% _.each(educationTypes, function(educationType) { %>
								<option value="<%= educationType.option_id %>"
									<% if (educationType.option_id == educational_attainment_id) { %> selected <% } %>
									>
									<%= educationType.option %>
								</option>
							<% }); %>
						</select>
					</div>				
				</div>				
				<div class="control-group">
					<label class="control-label" for="degree">Degree</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= degree %>" name="degree"/>
					</div>
				</div>
			</div>
		</div>
	</form>
</script>

<div id="family-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Family Member</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this family member.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>