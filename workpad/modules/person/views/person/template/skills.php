<script type="template/javascript" id="skill-item-template">	
	<td><%= skill_type %>&nbsp;</td>
	<td><%= skill %>&nbsp;</td>
	<td><%= proficiency %>&nbsp;</td>		
	<% if (actions != undefined && actions) { %>
	<td>
		<a href="javascript:void(0);" class="btnedit"><i class="icon-pencil"></i> Edit</a>
		<a href="javascript:void(0);" class="btndelete"><i class="icon-trash"></i> Delete</a>
	</td>
	<% } %>
</script>

<script type="template/javascript" id="skill-item-sub-template">
	<% 
	if (actions != undefined && actions) {
		span = 4;
	} else {
		span = 3;
	}
	%>
	<td colspan="<%= span %>">Remarks: <%= remarks %></td>
</script>

<script type="template/javascript" id="edit-skill-template">
	<form class="form-horizontal">	
		<div class="row">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="skill">Skill Type</label>
					<div class="controls">
						<select class="input-medium" name="skill_type_id">
							<option value="">Select&hellip;</option>
							<% _.each(skillTypes, function(skillType) { %>
								<option value="<%= skillType.option_id %>"
									<% if (skillType.option_id == skill_type_id) { %> selected <% } %>
									>
									<%= skillType.option %>
								</option>
							<% }); %>
						</select>
					</div>
				</div>			
				<div class="control-group">
					<label class="control-label" for="skill">Skill</label>
					<div class="controls">
						<input type="text" class="input-medium" value="<%= skill %>" name="skill"/>
					</div>
				</div>				
			</div>

			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="skill">Proficiency</label>
					<div class="controls">
						<select class="input-medium" name="proficiency_id">
							<option value="">Select&hellip;</option>
							<% _.each(proficiencyTypes, function(proficiencyType) { %>
								<option value="<%= proficiencyType.option_id %>" 
								<% if (proficiencyType.option_id == proficiency_id) { %> selected <% } %> 
								>
									<%= proficiencyType.option %>
								</option>								
							<% }); %>
						</select>
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

<div id="skill-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete skill</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this skill.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>								