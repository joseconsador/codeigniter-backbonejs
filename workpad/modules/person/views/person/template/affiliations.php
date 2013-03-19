<script type="template/javascript" id="affiliation-item-template">
	<%
	if (date_resigned == '') {
		status = 'Active';
	} else {
		status = 'Resigned';
	}
	%>
	<td><%= name %>&nbsp;</td>
	<td><%= position %>&nbsp;</td>
	<td><%= date_joined %>&nbsp;</td>
	<td><%= status %>&nbsp;</td>
	<td><%= date_resigned %>&nbsp;</td>
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>	
</script>

<script type="template/javascript" id="edit-affiliation-template">
	<form class="form-horizontal">
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label">Name</label>
					<div class="controls">
						<input type="text" class="input-medium" name="name" value="<%= name %>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Position</label>
					<div class="controls">
						<input type="text" class="input-medium" name="position" value="<%= position %>" />
					</div>
				</div>
			</div>
			<div class="span5">
				<div class="control-group">
					<label class="control-label">Date joined</label>
					<div class="controls">
						<input type="hidden" name="date_joined" value="<%= date_joined %>" />
						<input type="text" class="datepicker input-medium" rel="date_joined" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Date Resigned</label>
					<div class="controls">
						<input type="hidden" name="date_resigned" value="<%= date_resigned %>" />
						<input type="text" class="datepicker input-medium" rel="date_resigned" />
					</div>
				</div>
			</div>
		</div>
	</form>
</script>

<div id="affiliation-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Affiliation</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this affiliation.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>