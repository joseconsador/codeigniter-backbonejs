$(document).ready(function () {
	var PhotoModel = Backbone.Model.extend({
		defaults: {
			'url': '',
			'thumbnail_url' : '',
			'user_id': window.aboutModel.get('user_id')
		},
		url: function () {
			return BASE_URL + 'api/user/id/' + this.get('user_id') + '/photo?thumbnail=true';
		}
	});

	var photo = new PhotoModel();
	// ---------------------------------------------------------------------------
	// 
	
	$('#submit-photo').attr('disabled', true);

	$('#fileupload').fileupload({		
		add: function(e, data) {				
			$('#submit-photo').removeAttr('disabled');
			$('#preview-img').remove();
			$('#profile-img-default').hide();
			$('#submit-photo').unbind('click');
			$('#submit-photo').bind('click', function () {
				data.submit();
			});

			window.loadImage(data.files[0],
				function (img) {										
					$(img).attr('id', 'preview-img');
					$(img).addClass('thumbnail');
					$(img).attr('height', 106);
					$(img).attr('width', 106);

					$('#profile-img-container').append(img);
				}
			);
		},
		start: function (e) {
			$('#upload-progress-container').removeClass('hidden');
		},
		progress: function (e, data) {          
            progress = parseInt(data.loaded / data.total * 100, 10);
           	$('#upload-progress').css('width',  progress + '%').find('span').html(progress + '%');
		},
		done: function (e, data) {						
			if (data.result[0].error != undefined) {
				$('#photo-message').show().html('<span class="label label-important">' +  data.result[0].error +'.</span>');
			} else {
				setTimeout(function() { 
					$('#upload-progress-container').hide('fade'); 
					$('#myUpload').modal('hide');
					}					
				, 2000);
				$('#photo-message').show().html('<span class="label label-success">Photo successfully uploaded.</span>');

				// From views/profile/about.php
				window.aboutModel.set('photo', data.result[0].name).save();	
				photo.fetch({success: function (model, response, options) {
					$('#user-photo').attr('src', model.get('url'));
				}});				
			}
		}		
	});
});