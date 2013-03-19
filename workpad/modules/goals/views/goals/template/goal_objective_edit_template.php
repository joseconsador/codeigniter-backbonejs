<script type="template/javascript" id="goal-objective-edit-modal-template">
  <div class="modal-header"><h3><%= header %></h3></div>
  <div class="modal-body"><%= edit_form %></div>
  <div class="modal-footer">    
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a href="#" class="btn btn-primary objective-send">Save Objective</a>
  </div>
</script>

<script type="template/javascript" id="goal-objective-edit-template">    
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="title">Title</label>
            <div class="controls">
                <input type="text" id="title" name="title" placeholder="Title" value="<%= title %>">
                <span id="title"></span>
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="description">Description</label>
            <div class="controls">
                <textarea id="description" name="description" placeholder="Description"><%= description %></textarea>
                <span id="description"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="target">Target Date</label>
            <div class="controls">
              <input type="hidden" name="target_date" value="<%= target_date %>"/>
              <input type="text" class="datepicker input-medium" rel="target_date" placeholder="Pick date"/>
              <span id="target_date"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Assign To</label>
            <div class="controls">
              <input type="text" id="search-employee"  placeholder="Type a name of an employee" />      
            </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="date_to">Involved</label>
          <div class="controls">
          <div class="well" id="involved-container">
          <% _.each(involved, function(i) { %>
                  <a class="label label-info" ref="<%= i.employee_id %>"><i class="icon-remove icon-white"></i>&nbsp;<%= i.full_name %></a>
          <%  }); %>
          </div>
          </div>
        </div>        
    </form>
</script>