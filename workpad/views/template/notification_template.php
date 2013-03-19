<script type="template/javascript" id="notification-template">  

    <a href="<?php echo site_url();?><%= url %>">

    	<div style="float:left;line-height:50px;padding-right:10px;">
      		<img src="<%= thumbnail_url %>" height="30" style="vertical-align:top;" > 
      	</div>

      	<div>
      		<p style="margin:0 50px 0px 0px;">
      			<small>
      				<%= full_name %><br />
      				<%= $('<div>' + notification + '</div>').text() %><br />
              <abbr class="timeago" title="<%= created %>"><%= created %></abbr>
      			</small>
      		</p>
      	</div>

    </a>
</script>