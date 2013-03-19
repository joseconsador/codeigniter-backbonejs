<div class="container-fluid messages-ui">
  <div class="row-fluid">
    <div class="span8">
    <div class="modal hide" id="modalMessage">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Reply to <span class="modal-full_name"></span> </h3>
      </div>
      <div class="modal-body">
        <blockquote><span class="modal-original-message"></span></blockquote>
        <form>
          <fieldset>                
            <label>Message</label>
            <textarea name="message" class="span5" rows="6" placeholder="Type something…"></textarea>
            <span class="label hidden" id="messaging-message"></span>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="message-send">Send Message</a>
      </div>  
    </div>      
      <ul class="nav nav-tabs">
        <li><a href="#inbox" data-toggle="tab">Inbox</a></li>
        <li><a href="#sent" data-toggle="tab">Sent</a></li>        
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="inbox">
            <table class="responsive-table table-bordered" id="inbox-table">                
                <tbody></tbody>
            </table>
        </div>
        <div class="tab-pane" id="sent">
            <table class="responsive-table table-bordered" id="sent-table">                
                <tbody></tbody>
            </table>
        </div>
      </div>
    </div>
    <div class="span4">
      <?php $this->load->view('profile/right_col', array(
        'dep_name' => $department, 
        'department_id' => $department_id,
        'exclude_id' => $user_id
        )
      );?>
    </div>
  </div>
</div>
<?php echo $this->load->view('template/message_list_item');?>