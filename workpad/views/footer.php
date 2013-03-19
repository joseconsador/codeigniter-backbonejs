		<footer></footer>

    </div><!--/.fluid-container-->    

    <?php load_js();?>   

    <?php if (is_logged_in() && $this->uri->segment(1) != 'oauth'):?>

    <script type="text/javascript">
      <?php 
      $messages = $this->rest->get('messages/recieved', array(), 'json', FALSE);
      if ($messages->_count > 0):
      ?>
      var dmessages = <?php echo json_encode($messages->data);?>;
      <?php ;else:?>
      var dmessages = [];
      <?php endif;?>

      <?php 
      $notifications = $this->rest->get('user/id/' . $this->user->user_id . '/notifications', array(
        'limit' => 10, 'offset' => 0
        ), 'json', FALSE);
      
      if ($notifications->_count > 0):
      ?>
      var dnotifications = <?php echo json_encode($notifications->data);?>;
      <?php ;else:?>
      var dnotifications = [];
      <?php endif;?>      
    </script>
        
    <script type="text/javascript">
      $(document).ajaxSend(function(e, xhr, options) 
      {          
          if (!options.nonhdiapi)
            xhr.setRequestHeader("<?php echo $this->config->item('rest_key_name');?>", "<?php echo $this->session->userdata('api_key')?>");
      });

      // Reload the page if unauthorized ajax request is made.
      $(document).ready(
        function() {
            $(document).ajaxError(              
                function(e,request) {                  
                    response = $.parseJSON(request.responseText);

                    if (request.status == 403 && response.error == 'Invalid API Key.') {
                      window.location.reload();
                    }
                }
            );
        });
    </script>
    <?php endif;?>    
  </body>
</html>