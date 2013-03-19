<script type="template/javascript" id="unit-item-template">
	<% 
	date_issued = new Date(date_issued);	
	date_returned = new Date(date_returned);	
	%>
	
	<td><%= status %>&nbsp;</td>
	<td><%= cost %>&nbsp;</td>
	<td><%= quantity %>&nbsp;</td>
	<td><%= tag_number %>&nbsp;</td>
	<td><%= monthNames[date_issued.getMonth()] %> <%= date_issued.getUTCFullYear() %>&nbsp;</td>
	<td><%= monthNames[date_returned.getMonth()] %> <%= date_returned.getUTCFullYear() %>&nbsp;</td>
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

<script type="template/javascript" id="unit-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 4;
	} else {
		span = 3;
	}
	%>
	
	<td colspan="4">
		<h5><%= equipment %></h5>
	</td>
	<td colspan="<%= span %>">
		Remarks: <%= remarks %>
	</td>
</script>

<script type="template/javascript" id="edit-unit-template">
	<form class="form-horizontal" enctype="multipart/form-data">
		<input type="hidden" name="employee_id" value="<%= employee_id %>" />
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="equipment">Equipment</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= equipment %>" name="equipment"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="quantity">Quantity</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= quantity %>" name="quantity"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cost">Cost</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= cost %>" name="cost"/>
					</div>
				</div>				
				<div class="control-group">
					<label class="control-label" for="date_issued">Date Issued</label>
					<div class="controls">
						<input type="hidden" name="date_issued" value="<%= date_issued %>"/>
						<input type="text" class="datepicker input-medium" rel="date_issued"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="date_returned">Date Returned</label>
					<div class="controls">
						<input type="hidden" name="date_returned" value="<%= date_returned %>"/>
						<input type="text" class="datepicker input-medium" rel="date_returned"/>
					</div>
				</div>
			</div>

			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="tag_number">Tag Number</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= tag_number %>" name="tag_number"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="status">Status</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= status %>" name="status"/>
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
				<div class="control-group">
					<label class="control-label" for="remarks">Remarks</label>
					<div class="controls">
						<textarea class="input-medium" name="remarks"><%= remarks %></textarea>
					</div>
				</div>				
			</div>
		</div>
	</form>
</script>

<div id="unit-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Unit</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this unit.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>