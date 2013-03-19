var gapi = function(options) {	
	var that = this;
	this.options = options;
	// --------------------------------------------------------------------	
	this.access_token = this.options.access_token;
	// --------------------------------------------------------------------	
	this._authurl = 'https://accounts.google.com/o/oauth2/auth?';
	this._calendarurl = 'https://www.googleapis.com/calendar/v3/';
	this._validationurl = 'https://www.googleapis.com/oauth2/v1/tokeninfo';
	// --------------------------------------------------------------------
	this.check_auth = function() {		
		if (this.access_token == null || this.access_token == '') {
			data = {
				response_type: 'token',
				client_id: this.options.client_id,
				redirect_uri: SECURE_BASE_URL + 'oauth/callback',
				scope: 'https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/userinfo.profile',
				state: this.options.redirect_url,
				approval_prompt: 'force'
			}

			window.location = this._authurl + $.param(data);
		}
	}	
	this.response = {};
	// --------------------------------------------------------------------
	this.request = function(resource, type, options, callback) {		
		$.ajax({
			nonhdiapi: true,
			type: 'get',
			data: 'access_token=' + this.access_token,
			url: this._validationurl,
			dataType: 'json',
			success: function(response) {
				if (options == null) {
					options = {};
				}

				$.ajax({
					data: options,
					nonhdiapi: true,
					type: type,
					url: resource,
					dataType: 'json',					
					// Attach the oauth token
					beforeSend: function (xhr, e) {
						xhr.setRequestHeader('Authorization', 'Bearer ' + that.access_token); 
					},
					success: function(response) {
						if (typeof(callback) == typeof(Function) ) {
							callback(response);
						}
					}
				});
			},
			error: function(e) {
				that.access_token = null;				
				that.check_auth();
			}
		});
	}	
	// --------------------------------------------------------------------
	this.get = function(api, resource, options, callback) {
		return this.request(this._get_api_url(api, resource), 'get', options, callback);
	}
	// --------------------------------------------------------------------
	this.delete = function(api, resource, options, callback) {
		return this.request(this._get_api_url(api, resource), 'delete', options, callback);
	}
	// --------------------------------------------------------------------
	this.post = function(api, resource, options, callback) {
		return this.request(this._get_api_url(api, resource), 'post', options, callback);
	}	
	// --------------------------------------------------------------------
	this.put = function(api, resource, options, callback) {
		return this.request(this._get_api_url(api, resource), 'put', options, callback);
	}	
	// --------------------------------------------------------------------
	this._get_api_url = function(api, resource) {
		if (api == 'calendar') {
			url = this._calendarurl;
		}

		return url + resource;
	}
};