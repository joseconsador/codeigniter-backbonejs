<script type="template/javascript" id="form-list-item">	
	<td>
	<a target="_blank" href="<?php echo site_url('profile');?>/<%= employee.hash %>"><%= employee.full_name %></a>
	</td>
	<td><%= form_type %>&nbsp;</td>
	<td><%= date_from %>&nbsp;</td>
	<td><%= date_to %></td>
	<td><%= status %></td>
	<td>
		<button class="btn edit"><i class="icon-edit"></i> </button>
		<button class="btn delete"><i class="icon-trash"></i> </button>
		<% if (!locked) { %>
		<button class="btn approve"><i class="icon-thumbs-up"></i> </button>
		<button class="btn disapprove"><i class="icon-thumbs-down"></i> </button>
		<% } %>
	</td>
</script>