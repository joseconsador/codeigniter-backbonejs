<div class="modal hide" id="modalThankyou">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Thank <?php echo $first_name;?></h3>
	</div>
	<div class="modal-body">
		<form>
			<fieldset>								
				<label>Message</label>
				<textarea name="message" class="span5" rows="6" placeholder="Type something…"></textarea>
				<span class="label hidden" id="thankyou-message"></span>
			</fieldset>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
		<a href="#" class="btn btn-primary" id="btn-send">Send Message</a>
	</div>
</div>
