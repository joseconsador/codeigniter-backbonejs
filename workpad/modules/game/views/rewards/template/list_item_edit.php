<div id="rewards-list"></div>

<script type="template/javascript" id="reward-list-item-template">
	<%
	if (image_path == null) {
		image_path = 'http://placehold.it/260x180';
	} else {
		image_path = BASE_URL + image_path;
	}
	%>
	<div class="thumbnail">
	  <img src="<%= image_path %>" alt="">
	  <div class="caption">
	    <h5><%= name %></h5>
	    <p><%= description %></p>
	        <a class="btn edit" href="#"><i class="icon-edit"></i> Edit</a>                
	        <a class="btn btn-danger" href="#"><i class="icon-trash icon-white"></i> Delete</a>
	  </div>
	</div>
</script>