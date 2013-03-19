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
	    <h4><%= name %></h4>	    
	    <p><%= description %></p>	      
	    <a class="btn btn-success redeem" href="javascript:void(0);">Redeem</a>                
	    <a class="btn" href="javascript:void(0);">Add to Wishlist</a>
	    <b><%= points %> points</b>
	  </div>
	</div>
</script>