<script type="template/javascript" id="reward-edit-modal-template">
	<div class="modal-header"><h3><%= header %></h3></div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">		
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<% if (reward_id !== undefined && reward_id > 0) { %>
			<a class="btn btn-danger delete" rel="tooltip" title="Delete" href="#">
                <i class="icon-trash icon-white"></i>&nbsp;Delete
            </a>
		<% } %>		
		<a href="#" class="btn btn-primary" id="reward-send">Save Reward</a>
	</div>
</script>

<script type="template/javascript" id="reward-edit-template">    
    <form class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="reward_id" value="<%= reward_id %>" />   
        <div class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
                <input type="text" id="name" name="name" placeholder="Name" value="<%= name %>">
                <span id="name"></span>
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="description">Description</label>
            <div class="controls">
                <textarea id="description" name="description" placeholder="Description"><%= description %></textarea>
                <span id="description"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="points">Points</label>
            <div class="controls">
            	<input type="text" id="points" name="points" placeholder="Points needed to claim" value="<%= points %>">
                <span id="points"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="file_attachment">Image</label>
            <div class="controls">
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Select image...</span>
                    <input type="file" class="input-medium" name="file_attachment"/>
                </span>
                <span class="label"><%= filename %></span>
                <span id="file_attachment"></span>
            </div>
        </div>        
    </form>
</script>