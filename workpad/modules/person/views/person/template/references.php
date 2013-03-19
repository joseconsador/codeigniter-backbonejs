<script type="template/javascript" id="reference-item-template">
	<td><%= name %>&nbsp;</td>
	<td><%= telephone %>&nbsp;</td>
	<td><%= years_known %>&nbsp;</td>
	<td><%= address %>&nbsp;</td>
	<td><%= occupation %>&nbsp;</td>
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>	
</script>

<script type="template/javascript" id="edit-reference-template">
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
					<label class="control-label">Address</label>
					<div class="controls">
						<input type="text" class="input-medium" name="address" value="<%= address %>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Telephone</label>
					<div class="controls">
						<input type="text" class="input-medium" name="telephone" value="<%= telephone %>" />
					</div>
				</div>
			</div>
			<div class="span5">
				<div class="control-group">
					<label class="control-label">Occupation</label>
					<div class="controls">
						<input type="text" class="input-medium" name="occupation" value="<%= occupation %>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Years Known</label>
					<div class="controls">
						<input type="text" class="input-medium" name="years_known" value="<%= years_known %>" />
					</div>
				</div>
			</div>
		</div>
	</form>
</script>

<div id="reference-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Reference</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this reference.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>