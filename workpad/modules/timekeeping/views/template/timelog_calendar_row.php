<script type="template/javascript" id="timelog-row-template">
	<% 
		weekdays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
		date = new Date(date);
        date = date.getDate() + ' ' + weekdays[date.getDay()];        
    %>
	<td><%= date %>&nbsp;</td>
	<td><%= shift %>&nbsp;</td>
	<td>
		<%
			if (time_in != '') {
			time_in = new Date.createFromMysql(time_in);

			hours = time_in.getHours();
			ampm = 'am';
			if (hours > 12) {
				hours = hours - 12;
				ampm = 'pm';
			}			
		%>
			<%= hours %>:<%= time_in.getMinutes() + ' ' + ampm %>
		<% } %>&nbsp;
	</td>
	<td>
		<%
			if (time_out != '') {
			time_out = new Date.createFromMysql(time_out);
			hours = time_out.getHours();
			
			ampm = 'am';
			if (hours > 12) {
				hours = hours - 12;
				ampm = 'pm';
			}
		%>
			<%= hours %>:<%= time_out.getMinutes() + ' ' + ampm%>
		<% } %>&nbsp;
	</td>
	<td><%= lates %>&nbsp;</td>
	<td><%= undertime %>&nbsp;</td>
	<td><%= overtime %>&nbsp;</td>
	<td>&nbsp;</td>
</script>