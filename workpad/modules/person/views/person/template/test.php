<script type="template/javascript" id="test-item-template">
	<% 
	date_taken = new Date(date_taken);	
	%>
	
	<td><%= monthNames[date_taken.getMonth()] %> <%= date_taken.getUTCFullYear() %>&nbsp;</td>
	<td><%= given_by %>&nbsp;</td>
	<td><%= location %>&nbsp;</td>
	<td><%= score_rating %>%&nbsp;</td>
	<td><%= result %>&nbsp;</td>
	<td>
		<% if (log_uploads_id > 0) { %>
		<a href="<?php echo site_url();?><%= upload %>" title="<%= filename %>">
			<i class="icon-folder-open"></i>
		</a>
		<% } %>
		&nbsp;
	</td>	
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="test-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 7;
	} else {
		span = 6;
	}
	%>

	<td colspan="<%= span %>">
		<%= exam_type %> : <%= exam_title %>&nbsp;</td>
	</td>
</script>

<script type="template/javascript" id="edit-test-template">
	<form class="form-horizontal" enctype="multipart/form-data">
		<input type="hidden" name="person_id" value="<%= person_id %>" />	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="exam_title">Exam</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= exam_title %>" name="exam_title"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="exam">Exam Type</label>
					<div class="controls">
						<select class="input-medium" name="exam_type_id">
							<option value="">Select&hellip;</option>
							<% _.each(examTypes, function(examType) { %>
								<option value="<%= examType.option_id %>"
									<% if (examType.option_id == exam_type_id) { %> selected <% } %>
									>
									<%= examType.option %>
								</option>
							<% }); %>
						</select>
					</div>
				</div>			
				<div class="control-group">
					<label class="control-label" for="date_taken">Date Taken</label>
					<div class="controls">
						<input type="hidden" name="date_taken" value="<%= date_taken %>"/>
						<input type="text" class="datepicker input-medium" rel="date_taken"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="given_by">Given By</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= given_by %>" name="given_by"/>
					</div>
				</div>
			</div>

			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="location">Location</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= location %>" name="location"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="score_rating">Score</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= score_rating %>" name="score_rating"/>
					</div>
				</div>		
				<div class="control-group">
					<label class="control-label" for="result">Result Type</label>
					<div class="controls">
						<select class="input-medium" name="result_type_id">
							<option value="">Select&hellip;</option>
							<% _.each(resultTypes, function(resultType) { %>
								<option value="<%= resultType.option_id %>"
									<% if (resultType.option_id == result_type_id) { %> selected <% } %>
									>
									<%= resultType.option %>
								</option>
							<% }); %>
						</select>
					</div>
				</div>						
				<div class="control-group">
					<label class="control-label" for="result_attach">Attachment</label>
					<div class="controls">
						<span class="btn btn-success fileinput-button">
	                    	<i class="icon-plus icon-white"></i>
	                    	<span>Add Attachment...</span>
	                    	<input type="file" class="input-medium" name="file_attachment"/>
	                	</span>
	                	<span class="label"><%= filename %></span>
					</div>
				</div>
			</div>
		</div>
	</form>
</script>

<div id="test-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Test</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this test.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>