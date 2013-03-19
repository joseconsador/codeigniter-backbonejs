<script type="template/javascript" id="goal-edit-modal-template">
	<div class="modal-header"><h3><%= header %></h3></div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">		
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<% if (goal_id !== undefined && goal_id > 0) { %>
			<a class="btn btn-danger delete" rel="tooltip" title="Delete" href="#">
                <i class="icon-trash icon-white"></i>&nbsp;Delete
            </a>
		<% } %>		
		<a href="#" class="btn btn-primary" id="goal-send">Save Goal</a>
	</div>
</script>