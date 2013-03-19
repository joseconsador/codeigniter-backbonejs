<script type="template/javascript" id="message-notification-template">  

    <a href="<?php echo site_url('messages');?>#/inbox/<%= id %>" style="line-height:15px;">

    	<div style="float:left;line-height:50px;padding-right:10px;">
      		<img src="<%= thumbnail_url %>" height="30" style="vertical-align:top;" > 
      	</div>

      	<div>
      		<p style="margin:0 50px 0px 0px;">
      			<small>
      				<%= full_name %><br />
      				<%= message.substring(20, 0) %>&hellip;<br />      				
              <abbr class="timeago" title="<%= created %>"><%= created %></abbr>
      			</small>
      		</p>
      	</div>

    </a>
    
</script>