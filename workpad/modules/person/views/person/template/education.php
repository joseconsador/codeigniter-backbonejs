<script type="template/javascript" id="education-item-template">
	<% 
	date_from = new Date(date_from);	
	date_to   = new Date(date_to);
	date_graduated = new Date(date_graduated);
	%>

	<td><%= date_from.getUTCFullYear() %> - <%= date_to.getUTCFullYear() %>&nbsp;</td>
	<td><%= date_graduated.getUTCFullYear() %>&nbsp;</td>
	<td><%= degree %>&nbsp;</td>
	<td><%= honors %>&nbsp;</td>	

	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="education-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 6;
	} else {
		span = 5;
	}
	%>

	<td colspan="<%= span %>">
		<h5><%= education_level %>: <%= school %></h5>
	</td>
</script>

<script type="template/javascript" id="edit-education-template">
	<form class="form-horizontal">	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="school">School</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= school %>" name="school"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="date_from">Date From</label>
					<div class="controls">
						<input type="hidden" name="date_from" value="<%= date_from %>"/>
						<input type="text" class="datepicker input-medium" rel="date_from"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="date_to">Date To</label>
					<div class="controls">
						<input type="hidden" name="date_to" value="<%= date_to %>"/>
						<input type="text" class="datepicker input-medium" rel="date_to"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="date_graduated">Date Graduated</label>
					<div class="controls">
						<input type="hidden" name="date_graduated" value="<%= date_graduated %>"/>
						<input type="text" class="datepicker input-medium" rel="date_graduated"/>
					</div>
				</div>
			</div>

			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="degree">Degree</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= degree %>" name="degree"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="honors">Honors</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= honors %>" name="honors"/>
					</div>
				</div>			
				<div class="control-group">
					<label class="control-label" for="education_level_id">Education Level</label>
					<div class="controls">
						<select class="input-medium" name="education_level_id">
							<option value="">Select&hellip;</option>
							<% _.each(educationTypes, function(educationType) { %>
								<option value="<%= educationType.option_id %>"
									<% if (educationType.option_id == education_level_id) { %> selected <% } %>
									>
									<%= educationType.option %>
								</option>
							<% }); %>
						</select>
					</div>
				</div>	
			</div>
		</div>
	</form>
</script>

<div id="education-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Education</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this education.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>