<div class="container-fluid" id="view-201-container">

	<div class="row-fluid">

		<div class="span8">
			<?php $this->load->view('201/template/profile_header');?>
			<!-- START OF TAB MENU -->
			<ul id="myTab" class="nav nav-tabs">
				<li class="active"><a href="#tab-general" rel="general" data-toggle="tab">General</a></li>
				<li><a href="#tab-references" rel="references" data-toggle="tab">References</a></li>
				<li><a href="#tab-skills" rel="skills" data-toggle="tab">Skills/Trainings</a></li>				
				<li><a href="#tab-personal" rel="personal" data-toggle="tab">Personal</a></li>
				<li><a href="#tab-contact" rel="contact" data-toggle="tab">Contact</a></li>
				<li><a href="#tab-accountabilities" rel="accountabilities" data-toggle="tab">Accountabilities</a></li>
			</ul>


			<div id="employee-tab-content" class="tab-content">
				<input type="hidden" id="ref_id" value="<?php echo $ref_id;?>" />
				<!-- [GENERAL TAB] -->
				<div class="tab-pane fade in active" id="tab-general">

					<!-- [1] -->
					<div id="company-information">
						<h3>Company Information</h3>
						<div class="message-container"></div>
						<table class="responsive-table" id="table-company">
							<tbody>
							<tr>
								<td style="width:200px;">Company</td>
								<td><span class="static" id="company"><?php echo $company?>&nbsp;</span></td>
							</tr>
							<tr>
								<td>Division</td>
								<td><span class="static" id="division"><?php echo $division;?>&nbsp;</span></td>
							</tr>
							<tr>
								<td>Department</td>
								<td><span class="static" id="department"><?php echo $department;?>&nbsp;</span></td>
							</tr>
							<tr>
								<td>Position Title</td>
								<td><span class="static" id="position"><?php echo $position?>&nbsp;</span></td>
							</tr>

							<!-- tr>
								<td>Reports To</td><td>*** Reporting To</td>
							</tr -->

							<!-- tr>
								<td>Job Title</td><td>Lorem ipsum dolor set amet</td>
							</tr -->
							<tr>
								<td>Location</td>
								<td><span class="static" id="location"><?php echo $location;?>&nbsp;</span></td>
							</tr>
							</tbody>
						</table>
					</div>

					<!-- [2] -->
					<br />
					<div id="employment-information">
						<h3>Employment</h3>
						<div class="message-container"></div>		
						<table class="responsive-table" id="table-employment">
							<tbody>
							<tr>
								<td style="width:200px;">Employment Type</td>
								<td><?php echo isset($type) ? $type : '';?>&nbsp;</td>
							</tr>
							<tr>
								<td>Employment Status</td>
								<td>
									<span class="static" id="employment_status">
										<?php echo ucwords(strtolower($employment_status));?>&nbsp;
									</span>
								</td>
							</tr>
							<tr>
								<td>Date Hired </td>
								<td>
									<span class="static" id="span_hire_date">
									<?php echo _d($hire_date, 'F Y');?> 
									</span>
									<span class="static label pull-right">
										<abbr class="timeago" title="<?php echo _d($hire_date)?>"><?php echo _d($hire_date)?></abbr>
									</span>
								&nbsp;</td>
							</tr>
							<tr>
								<td>Date of Regularization</td>
								<td>
									<span class="static" id="span_regular_date">
									<?php echo _d($regular_date, 'F Y');?>&nbsp;
									</span>
								</td>
							</tr>
							</tbody>
						</table>
					</div>

					<!-- [3] -->
					<br />
					<h3>Schedule</h3>

					<table class="responsive-table">
						<tbody>
						<tr>
							<td style="width:200px;">Work Schedule</td><td>*** 9:00am to 6:00pm</td>
						</tr>
						<tr>
							<td>Identification No.</td><td><?php echo $id_number;?>&nbsp;</td>
						</tr>
						<tr>
							<td>Biometric ID</td><td><?php echo $biometric_id;?>&nbsp;</td>
						</tr>
						</tbody>
					</table>
					<div class="row page-border"> </div>
					<br />

				</div> <!-- end of GENERAL TAB -->

				<!-- [WORK TAB] -->
				<div class="tab-pane fade in" id="tab-references">
					<div id="workhistory">
					<?php $this->load->view('person/template/workhistory');?>
					<!-- [1] -->
					<h3>Work Experience</h3>
					<div class="form-container"></div>
					<table class="responsive-table" id="workhistory-table">
						<thead>
							<tr>
								<th>Company</th>
								<th>Address</th>
								<th>Nature</th>
								<th>Position</th>
								<th>Tenure</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					</div>					
					<!-- [2] -->
					<br />
					<div id="references">
					<h3>References</h3>
						<div class="form-container"></div>
						
						<?php $this->load->view('person/template/references');?>
						<table class="responsive-table" id="references-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Telephone</th>
									<th>Years Known</th>
									<th>Address</th>
									<th>Occupation</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>

					<!-- [3] -->
					<br />
					<div id="affiliations">
						<h3>Affiliation</h3>
						<div class="form-container"></div>
						<?php $this->load->view('person/template/affiliations');?>
						<table class="responsive-table" id="affiliations-table">
							<thead>
							<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Date Joined</th>
									<th>Status</th>
									<th>Date Resigned</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<br />
					<div class="row page-border"> </div>

				</div> <!-- end of WORK TAB -->

				<!-- [SKILLS/TRAININGS TAB] -->
				<div class="tab-pane fade in" id="tab-skills">
					
					<!-- [1] -->
					<br />
					<div id="skills">
						<?php $this->load->view('person/template/skills');?>
						<h3>Skills</h3>
						<div class="form-container"></div>
						<table class="responsive-table" id="skill-table">
							<thead>
								<tr>
									<th>Skill Type</th>
									<th>Skill</th>
									<th>Proficiency</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>					
					
					<!-- [2] -->
					<br />
					<div id="trainings">
						<?php $this->load->view('person/template/trainings');?>
						<h3>Trainings</h3>
						<div class="form-container"></div>
						<table class="responsive-table" id="trainings-table">
							<thead>
								<tr>
									<th>Address</th>
									<th>Date Attended</th>
									<th>Institution</th>
									<th>Remarks</th>
								</tr>
							</thead>

							<tbody></tbody>
						</table>
					</div>
					
					<!-- [3] -->
					<br />
					<div id="test">
						<?php $this->load->view('person/template/test');?>
						<h3>Test Profile</h3>
						<div class="form-container"></div>
						<table class="responsive-table" id="test-table">
							<thead>
							<tr>
									<th>Date Taken</th>
									<th>Given By</th>
									<th>Location</th>
									<th>Rating</th>
									<th>Result</th>
									<th>File</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="row page-border"> </div>
					<br />

				</div> <!-- end of SKILLS/TRAINING TAB -->

				<!-- [PERSONAL TAB] -->
				<div class="tab-pane fade in" id="tab-personal">

					<!-- [1] -->					
					<div id="person-details">
						<h3>Basic Info</h3>
						<table class="responsive-table">
							<tbody>
								<tr>
									<td style="width:200px;">Nickname</td>
									<td>										
										<?php echo $nick_name;?>&nbsp;
									</td>
								</tr>
								<?php if (_p($details, 'gender') == 'Female'):?>
								<tr>
									<!-- print if gender is female -->
									<td>Maiden Name</td>									
									<td>
										<span class="static" id="span-maiden-name">
											<?php echo $maiden_name;?>&nbsp;
										</span>
									</td>
								</tr>
								<?php endif;?>
								<tr>
									<td>Date of Birth</td>
									<td>
										<span class="static" id="span-birth-date">
											<?php echo _d(_p($details, 'birth_date'), 'M d, Y');?> 
											<span class="label label-info"><?php echo get_age(_p($details, 'birth_date'))?> yrs old</span>
										</span>											
									</td>
								</tr>
								<tr>
									<td>Place of Birth</td>
									<td>
										<span class="static" id="span-birth-place">
											<?php echo _p($details, 'birth_place');?>&nbsp;
										</span>
									</td>
								</tr>
								<tr>
									<td>Gender</td>
									<td>
										<span id="span-gender" class="static">
											<?php echo _p($details, 'gender');?>&nbsp;
										</span>
									</td>
								</tr>
								<tr>
									<td>Nationality</td>
									<td>
										<span class="static" id="span-nationality">
											<?php echo _p($details, 'nationality');?>&nbsp;
										</span>
									</td>
								</tr>
								<tr>
									<td>Civil Status</td>
									<td>
										<span id="span-civil-status" class="static">
											<?php echo _p($details, 'civil_status');?>&nbsp;
										</span>
									</td>
								</tr>
								<tr>
									<td>Height</td>
									<td>
										<span id="span-height" class="static">
											<?php echo _p($details, 'height');?>&nbsp;
										</span>	
									</td>
								</tr>
								<tr>
									<td>Weight</td>
									<td>
										<span id="span-weight" class="static">
											<?php echo _p($details, 'weight');?>&nbsp;
										</span>
									</td>
								</tr>
								<tr>
									<td>Blood Type</td>
									<td>
										<span id="span-blood-type" class="static">
											<?php echo _p($details, 'blood_type');?>&nbsp;
										</span>
									</td>
								</tr>
							</tbody>

						</table>
					</div>
					<!-- [2] -->
					<br />
					<div id="family">
						<h3>Family</h3>
						<?php $this->load->view('person/template/family');?>
						<div class="form-container"></div>
						<table class="responsive-table" id="family-table">
							<thead>
								<tr>
									<th>Date of Birth</th>
									<th>Occupation</th>
									<th>Employer</th>
									<th>Educational Attainment</th>
									<th>Degree</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>

					<?php if (count($idnos) > 0): ?>
					<!-- [3] -->
					<br />
					<h3>Government</h3>
					
					<table class="responsive-table">
						<tbody>
							<?php foreach ($idnos as $idno):?>
							<tr>
								<td style="width:200px;"><?php echo _p($idno, 'id_type');?>&nbsp;</td>
								<td><?php echo _p($idno, 'idnos');?>&nbsp;</td>
							</tr>
							<?php endforeach;?>	
						</tbody>
					</table>
					<?php endif;?>

					<!-- [3] -->
					<br />

					<div id="education">
						<h3>Educational Background</h3>
						<?php $this->load->view('person/template/education');?>
						<div class="form-container"></div>
						<table class="responsive-table" id="education-table">
							<thead>
							<tr>
									<th>From - To</th>
									<th>Date Graduated</th>
									<th>Degree</th>
									<th>Honors</th>
								</tr>
							</thead>

							<tbody></tbody>

						</table>
					</div>
					<div class="row page-border"> </div>
					<br />
				</div> <!-- end of PERSONAL TAB -->

				<!-- [CONTACT TAB] -->
				<div class="tab-pane fade in" id="tab-contact">

					<!-- [1] -->
					<h3>Basic Info</h3>

					<table class="responsive-table">

						<tbody>
							<tr>
								<td style="width:200px">Email</td><td><?php echo $email;?></td>
							</tr>
							<tr>
								<td>Mobile Phones</td>
								<td id="tab-contact-mobile"></td>
							</tr>
							<tr>
								<td>Other Phone</td><td id="tab-contact-other"></td>
							</tr>
							<tr>
								<td>Instant Messenger</td><td id="tab-contact-ims"></td>
							</tr>
						</tbody>

					</table>

					<!-- [2] -->
					<?php if (count($addresses) > 0):?>
						<h3>Address</h3>
						<?php foreach ($addresses as $_address):?>
						<h5 style="margin-top:10px"><?php echo _p($_address, 'address_type');?></h5>
						<table class="responsive-table" style="margin-top:10px;">
							<tbody>
								<tr>
									<td style="width:200px;">Unit/Bldg/House/Street</td>
									<td><?php echo _p($_address, 'street_building');?>&nbsp;</td>
								</tr>
								<tr>
									<td>Subdivision/Village/Barangay</td>
									<td><?php echo _p($_address, 'barangay');?>&nbsp;</td>
								</tr>
								<tr>
									<td>City/Municipality</td>
									<td><?php echo _p($_address, 'city');?>&nbsp;</td>
								</tr>
								<tr>
									<td>Province</td><td>*** </td>
								</tr>
								<tr>
									<td>Zip Code</td><td><?php echo _p($_address, 'zipcode');?>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						<?php endforeach;?>
					<div class="row page-border"> </div>
					<?php endif;?>
				</div> <!-- end of CONTACT TAB -->

				<!-- [ACCOUNTABILITIES TAB] -->
				<div class="tab-pane fade in" id="tab-accountabilities">					
					<div id="unit">
					<!-- [1] -->
					<h3>Accountabilities</h3>
					<?php $this->load->view('201/template/units');?>
					<div class="form-container"></div>
					<table class="responsive-table" id="unit-table">

						<thead>
						<tr>
								<th>Status</th>
								<th>Cost</th>
								<th>Qty</th>
								<th>Tag No.</th>
								<th>Date Issued</th>
								<th>Date Returned</th>
								<th>File</th>
							</tr>
						</thead>

						<tbody></tbody>

					</table>
					</div>
					<div class="row page-border"> </div>

				</div> <!-- end of ACCOUNTABILITIES TAB -->

			</div>

	</div> <!-- <div class="row-fluid"> -->


	<!-- RIGHT COLUMN -->
    <div class="span4">
		<?php $this->load->view('profile/right_col', array(
			'dep_name' => $department, 
			'department_id' => $department_id,
			'exclude_id' => $user_id
			)
		);?>
    </div>              

</div> <!-- <div class="container-fluid"> -->
<!-- Contact templates -->
<script type="text/javascript">              
$(function () {  
	$("abbr.timeago").timeago();
	var employeeModel = new Employee({ employee_id: <?php echo $employee_id;?> });

    var contacts = <?php echo ($contact) ? json_encode($contact) : 'new ContactModel()';?>;
    var contactCollection = new ContactCollection(contacts);
    <?php if ($contact):?>
      im_primary = contactCollection.where({is_primary: "1", contact_type: 'IM'});
      ims = contactCollection.where({contact_type: 'IM'});

      if ($(im_primary).size() == 0) {
        // Just get first contact to prevent js error
        im_primary = ims;
      }
      
      if ($(im_primary).size() > 0) {
        $('#im-primary').text(im_primary[0].get('contact'));
      }      

      $.each(ims, function (index, m) {      	
      	$('#tab-contact-ims').append(m.get('contact') 
      		+ ' ' + '<span class="label">&larr; ' + m.get('im_tag') + '</span> ');
      });

      mobile_primary = contactCollection.where({is_primary: "1", contact_type: 'Mobile'});        
      mobiles = contactCollection.where({contact_type: 'Mobile'});

      if ($(mobile_primary).size() == 0) {
        mobile_primary = mobiles;
      }

      if ($(mobile_primary).size() > 0) {
        $('#mobile-primary').text(mobile_primary[0].get('contact'));
      }

      $.each(mobiles, function (index, m) {
      	$('#tab-contact-mobile').append('<i class="icon-briefcase"></i> ' + m.get('contact') + ' ');
      });

      home_phones = contactCollection.where({contact_type: 'Home'});

      $.each(home_phones, function (index, m) {
      	$('#tab-contact-mobile').append('<i class="icon-home"></i> ' + m.get('contact') + ' ');
      });

      other_phones = contactCollection.where({contact_type: 'Fax'});

      $.each(other_phones, function (index, m) {
      	$('#tab-contact-other').append(m.get('contact') + ' ');
      });
    <?php endif;?>

	var workhistoryCollection = new WorkhistoryCollection(<?php echo json_encode($work_experience);?>);	
	var referencesCollection  = new ReferencesCollection(<?php echo json_encode($references)?>);
	var affiliationsCollection  = new AffiliationsCollection(<?php echo json_encode($affiliations)?>);
	var skillsCollection  = new SkillsCollection(<?php echo json_encode($skills)?>);
	var trainingsCollection  = new TrainingsCollection(<?php echo json_encode($trainings)?>);
	var testCollection  = new TestCollection(<?php echo json_encode($tests)?>);
	var familyCollection  = new FamilyCollection(<?php echo json_encode($family)?>);	
	var educationCollection  = new EducationCollection(<?php echo json_encode($education)?>);
	var unitCollection  = new UnitCollection(<?php echo json_encode($accountabilities)?>);
    <?php if (isset($edit) && $edit):?>
	// --------------------------------------------------------------------
	// 
	companyEdit = new EditRefView({ model: new UserRefModel({ id: $('#ref_id').val() }) });
	personDetailEdit = new EditPersonDetailView({ model: new PersonDetailModel({ id: <?php echo $details->id;?> }) });	
	employmentEdit = new EmploymentEditView({ model: employeeModel });
	workhistoryListView = new WorkhistoryListEditView(
		{
			person_id : <?php echo $person_id;?>,
			collection: workhistoryCollection
		}
	);
	referencesListView = new ReferencesListEditView({
		person_id : <?php echo $person_id;?>,
		collection: referencesCollection
	});
	affiliationListView = new AffiliationsListEditView({
		person_id : <?php echo $person_id;?>,
		collection: affiliationsCollection
	});	
	skillListView = new SkillListEditView({
		person_id : <?php echo $person_id;?>,
		collection: skillsCollection
	});	
	trainingListView = new TrainingListEditView({
		person_id : <?php echo $person_id;?>,
		collection: trainingsCollection
	});
	testListView = new TestListEditView({
		person_id : <?php echo $person_id;?>,
		collection: testCollection
	});	
	familyListView = new FamilyListEditView({
		person_id : <?php echo $person_id;?>,
		collection: familyCollection
	});	
	educationListView = new EducationListEditView({
		person_id : <?php echo $person_id;?>,
		collection: educationCollection
	});	
	unitListView = new UnitListEditView({
		employee_id : <?php echo $employee_id;?>,
		collection: unitCollection
	});	

	router = new EmployeeEditRouter();
	<?php ;else: ?>
	referencesListView  = new ReferencesListView({collection: referencesCollection});
	workhistoryListView = new WorkhistoryListView({collection: workhistoryCollection});	
	affiliationListView = new AffiliationsListView({collection: affiliationsCollection});	
	skillListView = new SkillListView({collection: skillsCollection});		
	trainingListView = new TrainingListView({collection: trainingsCollection});		
	testListView = new TestListView({collection: testCollection});	
	familyListView = new FamilyListView({collection: familyCollection});	
	educationListView = new EducationListView({collection: educationCollection});	
	unitListView = new UnitListView({collection: unitCollection});
    <?php endif;?>

    referencesListView.render();
    workhistoryListView.render();
    affiliationListView.render();
    skillListView.render();
    trainingListView.render();
    testListView.render();
    familyListView.render();
    educationListView.render();
    unitListView.render();
});
</script>