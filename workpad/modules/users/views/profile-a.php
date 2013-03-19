    <div class="container-fluid">
      
      <div class="row-fluid">      
        
        <div class="span8">

          <div id="profile-header">
            <?php if (!$own_profile):?>
              <div class="btn btn-large btn-success pull-right"> Thank You! </div>
            <?php else: ?>
                <div class="btn-group pull-right">
                  <a class="btn btn-primary" href="#" id="edit-profile-btn"> Edit Profile </a>
                  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#myUpload" data-toggle="modal"><i class="icon-user"></i> Upload Profile Photo</a></li>
                      <li><a href="#myContacts" data-toggle="modal"><i class="icon-pencil"></i> Edit Contacts</a></li>
                    </ul>            
                </div>
                          
                <!-- Modal Contacts -->          
                <div class="modal hide" id="myContacts">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Contact Information</h3>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal">
                      <div id="container-mobile"></div>
                      <div id="container-other"></div>
                      <div id="container-im"></div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                    <a href="#" class="btn btn-primary" id="contacts-submit">Submit Changes</a>
                  </div>
                </div>
            <?php endif;?>

            <!-- End contact -->


            <img src="<?php echo $thumbnail_url;?>" id="user-photo">
            <h2><?php echo $first_name . ' ' . $last_name;?></h2>
            <p class="grey" style="padding-bottom:8px;"><?php echo $position;?> of <?php echo $company?></p>
            <address>
              <abbr title="Email"> <i class="icon-envelope"></i></abbr>
              <a href="mailto:<?php echo $email;?>"> <?php echo $email;?> </a>
              <abbr title="Messenger"> <i class="icon-comment"></i></abbr> <span id="im-primary"></span>
              <abbr title="Mobile"> <i class="icon-signal"></i></abbr> <span id="mobile-primary"></span>
            </address>

            <div class="progress progress-striped" style="width:150px;"> 
              <div class="bar" style="width: 20%;">Level 47</div>
            </div>

            <div class="clearfix"></div>
          </div>

          <ul id="myTab" class="nav nav-tabs">

            <li class="active"><a href="#tab-a" data-toggle="tab">Status</a></li>
            <li><a href="#tab-b" data-toggle="tab">Goals</a></li>
            <li><a href="#tab-c" id="tab-about" data-toggle="tab">About</a></li>
            
          </ul>

          <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="tab-a">
              <?php echo $this->load->view('profile/status')?>
            </div>
            
            <div class="tab-pane fade" id="tab-b">

              <div class="well goals-box goal-in-progress">        
                
                <div class="pull-right">
                  <h3>85% in progress</h3>
                </div>

                <h3>Goal title here <span class="label label-success">160 pts</span></h3>
                <p>with <a href="#" class="label label-info">John Smith</a> <a href="#" class="label label-info">Henry Rodriguez</a> <a href="#" class="label label-info">Michelle Castro</a> on <i>June 5, 2012</i></p>
                <p>Some description goes here, lorem ipsum dolor set amet soconsetor et henor.</p>

                <ol>
                  <li>Objective goes here, lorem ipsum <span class="label label-success">50 pts</span></li>
                  <li>Objective goes here, lorem ipsum <span class="label">80 pts</span></li>
                  <li style="border:0">Goal details goes here, lorem ipsum <span class="label">30 pts</span></li>
                </ol>
              </div>

              <div class="well goals-box goal-complete">

                <div class="pull-right">
                  <h3>Achieved!</h3>
                </div>

                <h3>Goal title here  <span class="label label-success">230 pts</span></h3>
                <p>Some description goes here, lorem ipsum dolor set amet</p>
              </div>
            </div>
            <div class="tab-pane fade " id="tab-c">
              <?php $this->load->view('profile/about');?>
            </div>
          </div>
        </div>

        <div class="span4">
          <?php $this->load->view('profile/right_col');?>
        </div>             
    </div>


    <!-- dialog box -->

    <div class="modal hide" id="myModal">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Send message to <?php echo $first_name;?></h3>
    </div>
    <div class="modal-body">
      <form>
        <fieldset>
          <label>Subject</label>
          <input type="text" class="input-small span3">

          <label>Message</label>
          <textarea class="span4" rows="6" placeholder="Type something…"></textarea>

        </fieldset>
      </form>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal">Cancel</a>
      <a href="#" class="btn btn-primary">Send Message</a>
    </div>
  </div>
        
  <!-- Contact templates -->
  <script type="text/javascript">              
    $(function () {                    
        var contacts = <?php echo ($contact) ? json_encode($contact) : 'new ContactModel()';?>;
        var contactCollection = new ContactCollection(contacts);
        <?php if ($contact):?>
          im_primary = contactCollection.where({is_primary: "1", contact_type: 'IM'});

          if ($(im_primary).size() == 0) {
            // Just get first contact to prevent js error
            im_primary = contactCollection.where({contact_type: 'IM'});            
          }
          
          if ($(im_primary).size() > 0) {
            $('#im-primary').text(im_primary[0].get('contact'));
          }

          mobile_primary = contactCollection.where({is_primary: "1", contact_type: 'Mobile'});        

          if ($(mobile_primary).size() == 0) {
            mobile_primary = contactCollection.where({contact_type: 'Mobile'});
          }

          if ($(mobile_primary).size() == 0) {          
            $('#mobile-primary').text(mobile_primary[0].get('contact'));
          }
        <?php endif;?>
        <?php if ($own_profile):?>
        var contactEditView = new EditContactView({collection: contactCollection});        
        <?php endif;?>
    });
  </script>

<?php if ($own_profile):?>
  <!-- Modal Upload -->
  <div class="modal hide" id="myUpload">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h3>Upload Photo</h3>
    </div>
    <div class="modal-body" id="fileupload">
      <form enctype="multipart/form-data" method="post" action="<?php echo site_url('upload/upload_img');?>">
        <p style="padding-bottom:20px">
          <small>The image needs to be at least 105 pixels wide or 105 pixels tall.</small>
        </p>
        <div class="row">                        
          <div class="span2">
            <div id="profile-img-container">
              <img src="<?php echo $thumbnail_url;?>" class="thumbnail" id="profile-img-default">
            </div>
            <div class="progress progress-striped hidden" id="upload-progress-container"> 
              <div class="bar" id="upload-progress"></div>
            </div>
            <div id="photo-message"></div>
          </div>
          <div class="span2" style="vertical-align:top">
            <span class="btn fileinput-button">
                <i class="icon-plus icon-black"></i>
                <span>Select file...</span>
                <input type="file" name="userfile">
            </span>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal">Cancel</a>
      <a href="#" id="submit-photo" class="btn btn-primary">Upload</a>
    </div>
  </div>

  <!-- Mobile contact input -->
  <script type="template/javascript" id="mobile-input-template">
    <div class="control-group" <% if(last) { %>style="border-bottom:1px solid #eee;padding-bottom:5px;"<% } %>>
      <% if(first) { %><label class="control-label" for="inputMobile">Mobile Phones :</label><% } %>
      <div class="controls">
        <input type="text" id="inputMobile" placeholder="+63917" value="<%= contact %>" name="contact"/>
        <label class="checkbox inline" style="vertical-align:top">
          <input type="radio" name="is_primary[mobile]" value="1" <% if (is_primary == true) {%>checked<%}%>/> Primary
        </label>
        <% if (last) { %>
        <div class="clearfix"></div>
        <p class="help-inline"><a class="add-new" href="#" rel="Mobile"><small>Add another mobile</small></a></p>
        <% } %>                                       
      </div> 
    </div>
  </script>

  <!-- Other contact input -->
  <script type="template/javascript" id="other-input-template">
    <div class="control-group" <% if(last) { %>style="border-bottom:1px solid #eee;padding-bottom:5px;"<% } %>>
      <% if(first) { %><label class="control-label" for="inputOthers">Other Phones :</label><% } %>
      <div class="controls">
        <input type="text" id="inputOthers" placeholder="+632" style="width:57%;" value="<%= contact %>" name="contact"/>
        <select name="contact_type" style="width:30%;">
          <option value="Work">Work</option>
          <option value="Home">Home</option>
        </select>
        <% if (last) { %>
        <div class="clearfix"></div>
        <p class="help-inline"><a class="add-new" href="#" rel="Work"><small>Add another phone</small></a></p>
        <% } %>                    
      </div>
    </div>
  </script>

  <!-- IM contact input -->
  <script type="template/javascript" id="im-input-template">              
    <div class="control-group" <% if(last) { %>style="border-bottom:1px solid #eee;padding-bottom:5px;"<% } %>>
      <% if(first) { %><label class="control-label" for="inputEmail">Instant Messenger :</label><% } %>
      <div class="controls">                      
        <input type="text" id="inputIM" placeholder="Instant Messenger" style="width:57%;" name="contact" value="<%= contact %>" />
        <select style="width:30%;" name="im_tag">
          <option value="AIM" <% if (im_tag == 'AIM') {%>selected<%}%>>AIM</option>
          <option value="Google Talk" <% if (im_tag == 'Google Talk') {%>selected<%}%>>Google Talk</option>
          <option value="Windows Live" <% if (im_tag == 'Windows Live') {%>selected<%}%>>Windows Live</option>
          <option value="Skype" <% if (im_tag == 'Skype') {%>selected<%}%>>Skype</option>
          <option value="Yahoo" <% if (im_tag == 'Yahoo') {%>selected<%}%>>Yahoo</option>
        </select>
        <label class="checkbox inline" style="vertical-align:top">
          <input type="radio" name="is_primary[im]" value="1" <% if (is_primary == true) {%>checked<%}%>/> Primary
        </label>        
        <% if (last) { %>
        <div class="clearfix"></div>
        <p class="help-inline"><a class="add-new" href="#" rel="IM"><small>Add another IM</small></a></p>
        <% } %>
      </div>
    </div>
  </script>
  <script type="template/javascript" id="alert-template">
    <div class="control-group">
      <div class="controls">
        <label class="error"><%= message %></label>
      </div>
    </div>
  </script>
<?php endif;?>
