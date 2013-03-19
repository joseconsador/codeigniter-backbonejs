<script type="template/javascript" id="inbox-list-item">
	<td>
		<% if (log_read == null) { %><strong><% } %>
		<%= full_name %>
		<% if (log_read == null) { %></strong><% } %>
	</td>
	<td><%= message %></td>
	<td><%= fdate %></td>
</script>

<script type="template/javascript" id="sent-list-item">
	<td>
		<% if (log_read == null) { %><strong><% } %>
		<%= recipient_name %>
		<% if (log_read == null) { %></strong><% } %>
	</td>
	<td><%= message %></td>
	<td><%= fdate %></td>
</script>