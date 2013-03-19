<div class="container-fluid">

  <div class="row-fluid">
    <div class="page-header">
        <h2>My Calendar</h2>
        <?php if ($this->user->google_id == '' || $this->user->google_id <= 0):?>
        <div class="pull-right">          
          <a href="#" id="gcal-link">Link to Google Calendar</a>
        </div>
        <?php endif;?>
    </div>
<!--     <div><a href="#/new-form">Apply for a Form</a></div>     -->
    <div id="calendar"></div>
  </div>

  <div id="activity-selection-modal" class="modal hide fade" role="dialog" aria-hidden="true">
    <div class="modal-header">
      <button data-dismiss="modal" class="close" type="button">×</button>
      <h3>Select an Event type</h3>
    </div>
    <div class="modal-body">
      <center>
        <a class="btn btn-large" href="#" id="file-form"><i class="icon-plane"></i> File a Leave</a>
        <a class="btn btn-large" href="#" id="file-event"><i class="icon-calendar"></i> Schedule an Activity</a>
      </center>
    </div>
  </div>

  <div id="form-edit-modal" class="modal hide fade" role="dialog" aria-hidden="true"></div>
  <div id="event-edit-modal" class="modal hide fade" role="dialog" aria-hidden="true"></div>
  <?php $this->load->view('template/form_application_template');?>
  <?php $this->load->view('calendar/template/event_edit_template');?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
<style type="text/css">
  .pac-container {
    z-index: 10000 !important;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {    
    /*calendars = google.get('calendar', 'users/me/calendarList');

    $.each(calendars, function(index, calendar) {
      console.log(calendar);
    });*/

    window.calendarApp = [];

    calendarApp.collection = new CalendarEventCollection();

    calendarApp.view = new CalendarView({
      collection: calendarApp.collection,
      eventOptions: {
        user_id: <?php echo $this->user->user_id?>,
        employee_id: <?php echo _p($this->user, 'employee_id');?>,
        employee: {hash: '<?php echo $this->user->hash;?>', full_name: '<?php echo $this->user->full_name;?>'}
      },
    });

    <?php if ($this->user->oauth_token != ''):?>
    calendarApp.view.set_gcal(
      new gapi({
        client_id: '<?php echo $this->config->item('client_id')?>',
        client_secret: '<?php echo $this->config->item('client_secret')?>',
        redirect_url: '<?php echo $this->config->item('secure_base_url') . $this->config->item('redirect_url')?>',
        access_token: '<?php echo $this->user->oauth_token;?>',
        api_key: '<?php echo $this->config->item('api_key')?>'
      })
    );
    <?php endif;?>
    calendarApp.router = new CalendarRouter();

    /*calendarApp.view.activityModal.formView.$el.on('hidden', function() {
      calendarApp.router.navigate('/');
    });*/
  });
</script>