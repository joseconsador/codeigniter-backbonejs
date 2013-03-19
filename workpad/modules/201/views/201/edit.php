<div class="modal hide" id="employee-edit-modal">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">×</button>
  <h3 class="edit-modal-title"></h3>
  </div>
  <div class="modal-body">
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#tab-aa" data-toggle="tab">Personal</a></li>
      <li><a href="#tab-general" data-toggle="tab">General</a></li>
      <li><a href="#tab-references" data-toggle="tab">References</a></li>
      <li><a href="#tab-work" data-toggle="tab">Work History</a></li>
      <li><a href="#tab-ad" data-toggle="tab">Skill</a></li>
      <li><a href="#tab-ae" data-toggle="tab">Training</a></li>
    </ul>
    <div id="tab-loading">
      <img src="<?php echo site_url('includes/img/ajax-loader.gif')?>" />
    </div>
    <form class="form-horizontal">
    <div id="myTabContent" class="tab-content">      
      <div class="tab-pane fade in active" id="tab-aa">
        <div class="control-group">							
          <label class="control-label" for="first_name">First Name</label>
          <div class="controls">
            <input type="text" id="first_name" class="input-medium" />
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="_XXX_">Last Name</label>
          <div class="controls">
            <input type="text" id="last_name" class="input-medium" />
          </div>
        </div>

        <div class="control-group">
					<label class="control-label" for="_XXX_">Login</label>
          <div class="controls">
            <input type="text" id="login" class="input-medium" />
          </div>
        </div>
      </div>

      <div class="tab-pane fade in" id="tab-general">
          <fieldset>
            <legend>Company Information</legend>
            
            <div class="control-group">
							<label class="control-label" for="_XXX_">Company</label>
              <div class="controls">
                <select id="company_id" class="input-medium">
                <?php foreach ($companies->data as $company):?>
                  <option value="<?php echo $company->company_id;?>">
                  <?php echo _p($company, 'company');?>
                  </option>
                <?php endforeach;?>
                </select>
              </div>
            </div>

            <div class="control-group">
							<label class="control-label" for="_XXX_">Division</label>
              <div class="controls">
                <input type="text" class="input-medium" id="division" />                  
              </div>
            </div>

            <div class="control-group">
							<label class="control-label" for="_XXX_">Department</label>
              <div class="controls">
                <select id="department_id" class="input-medium">                  
                <?php foreach ($departments->data as $department):?>
                  <option value="<?php echo $department->department_id;?>">
                    <?php echo _p($department, 'department');?>
                  </option>
                <?php endforeach;?>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Employment</legend>
            <div class="control-group">
              <label class="control-label" for="_XXX_">Employment Type</label>
              <div class="controls">
                <input type="text" class="input-medium" id="type" disabled/>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="_XXX_">Employment Status</label>
              <div class="controls">
                <select id="status_id" class="input-medium">
                <?php foreach ($employment_statuses->data as $employment_status):?>
                  <option value="<?php echo $employment_status->option_id;?>">
                    <?php echo $employment_status->option;?>
                  </option>
                <?php endforeach;?>    
                </select>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="_XXX_">Date Hired</label>
              <div class="controls">
                <input type="hidden" id="hire_date" />
                <input type="text" class="input-medium datepicker" rel="hire_date" />
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="_XXX_">Date of Regularization</label>
              <div class="controls">
                <input type="hidden" id="regular_date" />
                <input type="text" class="input-medium datepicker" rel="regular_date" />
              </div>
            </div>
          </fieldset>
      </div>
      <div class="tab-pane fade in" id="tab-work"></div>
      <div class="tab-pane fade in" id="tab-ad">
        
          <fieldset>
            <div class="control-group">
							<label class="control-label" for="_XXX_">Title</label>
              <div class="controls">
                <input type="text" class="input-medium">
              </div>
            </div>            

            <div class="control-group">
							<label class="control-label" for="_XXX_">Description</label>
              <div class="controls">
                <textarea class="input-xlarge" placeholder="Brief description of the skill..."></textarea>
              </div>
            </div>
            
            <div class="control-group">
							<label class="control-label" for="_XXX_">Proficiency</label>
              <div class="controls">
                <select class="input-medium">
                  <option>Excellent</option>
                  <option>Very Good</option> 
                </select>
              </div>
            </div>
            <div class="control-group">
							<label class="control-label" for="_XXX_">Document</label>
              <div class="controls">
                <input type="file">
              </div>
            </div>
          </fieldset>
        
        <p><a class="btn btn-success" href="#" >Add more skill</a></p>
      </div>
      <div class="tab-pane fade in" id="tab-ae">
        
          <fieldset>
            <div class="control-group">
							<label class="control-label" for="_XXX_">Title</label>
              <div class="controls">
                <input type="text" class="input-medium">
              </div>
            </div>

            <div class="control-group">
							<label class="control-label" for="_XXX_">Description</label>
              <div class="controls">
                <textarea class="input-xlarge" placeholder="Brief description of the training..."></textarea>
              </div>
            </div>
            
            <div class="control-group">
							<label class="control-label" for="_XXX_">Document</label>
              <div class="controls">
                <input type="file">
              </div>
            </div>
          </fieldset>
        
        <p><a class="btn btn-success" href="#" >Add more training</a></p>
      </div>
      <div class="tab-pane fade in" id="tab-references"></div>
    </div>  
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary">Save changes</button>
  </div>  
  <?php echo form_close();?>
</div>
<?php $this->load->view('person/template/references');?>
<?php $this->load->view('person/template/workhistory');?>

<script type="template/javascript" id="add-more-template">
  <a class="btn btn-small" href="#"><i class="icon-plus"></i> Add More</a>
</script>