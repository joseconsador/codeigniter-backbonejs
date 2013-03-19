<div class="container-fluid">
	<div class="row-fluid"><h3>Modules</h3></div>
	<div class="row-fluid">
		<table class="table table-striped" id="modules-table">
			<thead>
				<tr>
					<th>Module</th>
					<th>Enabled</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<div id="module-edit-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"></div>

<script type="template/javascript" id="module-list-item-template">
	<td><%= name %></td>
	<td>
		<label class="checkbox inline">
			<input type="checkbox" name="enabled-<%= module_id %>" value="<%= enabled %>" 
			<% if (enabled == "1") print('checked') %> />
		</label>	
	</td>
	<td>
		<button class="btn edit"><i class="icon-edit"></i> </button>
		<button class="btn delete"><i class="icon-trash"></i> </button>
	</td>
</script>

<script type="template/javascript" id="module-edit-modal-template">
	<div class="modal-header"><h3><%= header %></h3></div>
	<div class="modal-body"><%= edit_form %></div>
	<div class="modal-footer">		
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<% if (module_id !== undefined && module_id > 0) { %>
			<a class="btn btn-danger delete" rel="tooltip" title="Delete" href="#">
                <i class="icon-trash icon-white"></i>&nbsp;Delete
            </a>
		<% } %>
		<a href="#" class="btn btn-primary" id="module-send">Save Module</a>
	</div>
</script>

<script type="template/javascript" id="module-edit-template">    
    <form class="form-horizontal">

        <div class="control-group">
            <label class="control-label" for="uuid">Unique ID</label>
            <div class="controls">
                <input type="text" id="uuid" name="uuid" placeholder="Unique Identifier" value="<%= uuid %>">
                <span id="uuid"></span>
            </div>
        </div>    

        <div class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
                <input type="text" id="name" name="name" placeholder="Enter a name" value="<%= name %>">
                <span id="name"></span>
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="dir">Directory</label>
            <div class="controls">
                <textarea id="dir" name="dir" placeholder="Directory"><%= dir %></textarea>
                <span id="dir"></span>
            </div>
        </div>

    </form>
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var modules = new ModuleCollection(<?php echo json_encode($modules);?>);
		var modulesView = new ModulesListView({collection: modules});

		modulesView.render();
	});
</script>