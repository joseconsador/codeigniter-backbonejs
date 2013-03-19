<?php if ($own_profile):?>
	<form id="add-status-form" action="#">    
	    <textarea rows="2" class="input-xlarge span" id="feeds" name="feeds" style="width:100%;" placeholder="Post a status to your colleagues"></textarea>
	    <label class="checkbox">
	    <input type="checkbox" name="restrict" value="1"> <?php echo $department;?> Only
	    </label>
	    <button class="btn" id="add">Share</button>
	    <div class="clearfix"> </div>
	</form>
<?php endif;?>
<div id="stream-container">
	<div id="feed-container"></div>
	<div id="load-more-container"></div>
</div>
<?php if ($own_profile):?>
<div id="modal-delete" class="modal hide fade">
    <div class="modal-header">
      <a href="#" class="close">&times;</a>
      <h3>Delete Post</h3>
    </div>
    <div class="modal-body">
      <p>You are about to delete this post.</p>
      <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
      <a href="#" data-dismiss="modal" class="btn secondary">No</a>
    </div>
</div>
<?php endif;?>
<script id="feedTemplate" type="text/template">
  	<p> <%= feeds %> </p>
	<p><abbr class="timeago" style="font-size:smaller;" title="<%= created %>"><%= created %></abbr>
		<?php if ($own_profile):?>
		<span class="action pull-right">			
			<a href="javascript:void(0);" class="feed-delete">Delete</a>
		</span>	
		<?php endif;?>
	</p>
</script>
<script id="load-more-template" type="text/template">
	<p>
		<div class="progress progress-striped active">
			<div class="bar" style="width:100%;background-color:#eee"></div>
		</div>
		<div style="text-align:center">
		    <a href="javascript:void(0);" id="loadmore-feed">Load more</a>
		</div>	
	</p>
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var collection = new Stream();
		collection.user = <?php echo $user_id;?>;
	    var streamView = new StreamView({collection: collection});
	    <?php if ($own_profile):?>
	    var form = new StatusForm({stream: streamView});
	    <?php endif;?>
	    $(window).scroll(function() {
	        if (streamView.$el.is(':visible') && 
	            !streamView.isLoading && 
	            $(window).scrollTop() + $(window).height() > getDocHeight() - 100 
	            ) {
	            streamView.loadMore();	         
	        }
	    });
	});
</script>

<style type="text/css">
	.action {
		display: none;
	}
	.posted-status:hover .action {
		display: block;
	}
</style>