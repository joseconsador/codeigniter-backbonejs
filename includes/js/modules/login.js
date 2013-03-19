$(document).ready(function() {
	$('#login-form input').keydown(function (e) {		
		if (e.keyCode == 13) {
			$('#login-btn').trigger('click');
		}
	});

	$('#login-btn').click(function (e) {
		e.preventDefault();
		var that = this;

		$.ajax({
			url: BASE_URL + 'auth/client_login',
			type: 'post',
			dataType: 'json',
			data: $('#login-form').serialize(),
			beforeSend: function () {
				$(that).text('Logging you in...');
				$(that).attr('disabled', true);
			},
			success: function (response) {
				if (response.status == 200) {
					$('#msg-container').html('<span class="label label-success">Login successful...</span>');

					$.ajax({
						url: BASE_URL + 'auth/get_redirect_url',
						dataType: 'html',
						success: function(url) {
							window.location = BASE_URL + url;
						}
					});					
				} else {
					$('#msg-container').html('<span class="label label-important">Please check your username or password.</span>');
					$(that).text('Login');
					$(that).attr('disabled', false);
				}
			}			
		});		
	});
});;