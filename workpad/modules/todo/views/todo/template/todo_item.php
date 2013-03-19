<script type="template/javascript" id="todo-item-template">
	<% 	    
		tdate = new Date(target_date);		
		labelclass = '';
	    if (isValidDate(tdate)) {
	    	tdate = Date.createFromMysql(target_date);

	    	cdate = Date.createFromMysql(date_completed);
	    	diff = tdate - cdate;

	    	d = new Date();

	    	currdate = new Date(d.getUTCFullYear(), d.getMonth(), d.getDate());
	    	currdiff = tdate - currdate;

	    	if (diff < 0 || (cdate == null && completed == 0 && currdiff < 0)) {
	    		labelclass = 'label-important';
	    	} else if (currdiff == 0 && completed == 0) {
	    		labelclass = 'label-warning';
	    	} else if (diff >= 0 && completed == 1) {
	    		labelclass = 'label-success';
	    	}

	    	tdate = $.datepicker.formatDate('M d', tdate);
	    } else {
	    	tdate = '';
	    }
	%>
	<div class="span6">
	<% if (completed == 1) { %><s><i><% } %>	
		<input type="checkbox" class="completed-toggler" <% if (completed == 1) { %>checked<% } %>/>
		<%= $('<div>' + description + '</div>').text() %>
	<% if (completed == 1) { %></s></i><% } %>	
	</div>
	<div class="span4">
		<span class="label <%= labelclass %>"><%= tdate  %></span>
	</div>
	<div class="span2">
		<% if (completed == 0) { %>
			<a href="#" class="todo-edit"><i class="icon-edit"></i></a>
		<% } %>
		<a href="javascript:void(0);" class="todo-delete"><i class="icon-remove"></i></a>
	</div>
</script>