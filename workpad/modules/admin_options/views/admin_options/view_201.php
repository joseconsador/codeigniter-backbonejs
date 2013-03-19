<div class="container-fluid" id="view-201-container">

	<div class="row-fluid">

		<div class="span8">

			<div id="profile-header">

				<div class="btn-group pull-right">
					<a class="btn btn-large btn-success" href="#modalMessage" data-toggle="modal"> Contact <?php echo $first_name;?> </a>
					<a class="btn btn-large btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#myThankYou" data-toggle="modal"><i class="icon-thumbs-up"></i> Send Thank You </a></li>
						<li><a href="#myPrintProfile" data-toggle="modal"><i class="icon-print"></i> Print Profile </a></li>
					</ul>            

				</div>

				<!-- SEND A MESSAGE BOX -->
				<div class="modal hide" id="modalMessage">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Send message to <?php echo $first_name;?></h3>
					</div>
					<div class="modal-body">
						<form>
							<fieldset>								
								<label>Message</label>
								<textarea name="message" class="span11" rows="6" placeholder="Type something…"></textarea>
								<span class="label hidden" id="messaging-message"></span>
							</fieldset>
						</form>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Cancel</a>
						<a href="#" class="btn btn-primary" id="btn-send">Send Message</a>
					</div>
				</div>



				<!-- PROFILE -->
				<img src="<?php echo base_url() . BASE_IMG ;?>user-photo.jpg" id="user-photo">
				<h2><?php echo $first_name . ' ' . $last_name;?></h2>

				<p class="grey" style="padding-bottom:8px;"><?php echo $position;?> of <?php echo $company?></p>

	            <address>
	              <abbr title="Email"> <i class="icon-envelope"></i></abbr>
	              <a href="mailto:<?php echo $email;?>"> <?php echo $email;?> </a>
	              <abbr title="Messenger"> <i class="icon-comment"></i></abbr> <span id="im-primary"></span>
              	  <abbr title="Mobile"> <i class="icon-signal"></i></abbr> <span id="mobile-primary"></span>
	            </address>

				<div class="clearfix"></div>
			
			</div>


			<!-- START OF TAB MENU -->
			<ul id="myTab" class="nav nav-tabs">
				<li class="active"><a href="#tab-general" rel="general" data-toggle="tab">General</a></li>
				<li><a href="#tab-references" rel="references" data-toggle="tab">References</a></li>
				<li><a href="#tab-skills" rel="skills" data-toggle="tab">Skills/Trainings</a></li>				
				<li><a href="#tab-personal" rel="personal" data-toggle="tab">Personal</a></li>
				<li><a href="#tab-contact" rel="contact" data-toggle="tab">Contact</a></li>
				<li><a href="#tab-accountabilities" rel="accountabilities" data-toggle="tab">Accountabilities</a></li>
			</ul>


			<div id="myTabContent" class="tab-content">
			
				<!-- [GENERAL TAB] -->
				<div class="tab-pane fade in active" id="tab-general">

					<!-- [1] -->
					<h3>Company Information</h3>

					<table class="responsive-table">
						<tbody>
						<tr>
							<td style="width:200px;">Company</td><td><?php echo $company?></td>
						</tr>
						<tr>
							<td>Division</td><td>*** Division Title</td>
						</tr>
						<tr>
							<td>Department</td><td><?php echo $department;?></td>
						</tr>
						<tr>
							<td>Position Title</td><td><?php echo $position?></td>
						</tr>

						<!-- tr>
							<td>Reports To</td><td>*** Reporting To</td>
						</tr -->

						<!-- tr>
							<td>Job Title</td><td>Lorem ipsum dolor set amet</td>
						</tr -->
						<tr>
							<td>Location</td><td>*** Quezon City PH</td>
						</tbody>
					</table>


					<!-- [2] -->
					<h3>Employment</h3>

					<table class="responsive-table">
						<tbody>
						<tr>
							<td style="width:200px;">Employment Type</td><td><?php echo $type;?></td>
						</tr>
						<tr>
							<td>Employment Status</td><td><?php echo ucwords(strtolower($employment_status));?></td>
						</tr>
						<tr>
							<td>Date Hired </td><td><?php echo _d($hire_date, 'F Y');?> <span class="pull-right" style="font-size:smaller">( <abbr class="timeago" title="<?php echo _d($hire_date)?>"><?php echo _d($hire_date)?></abbr> )</span></td>
						</tr>
						<tr>
							<td>Date of Regularization</td><td><?php echo _d($regular_date, 'F Y');?></td>
						</tr>
						</tbody>
					</table>


					<!-- [3] -->
					<h3>Schedule</h3>

					<table class="responsive-table">
						<tbody>
						<tr>
							<td style="width:200px;">Work Schedule</td><td>*** 9:00am to 6:00pm</td>
						</tr>
						<tr>
							<td>Identification No.</td><td><?php echo $id_number;?></td>
						</tr>
						<tr>
							<td>Biometric ID</td><td><?php echo $biometric_id;?></td>
						</tr>
						</tbody>
					</table>
					<div class="row page-border"> </div>

				</div> <!-- end of GENERAL TAB -->

				<!-- [WORK TAB] -->
				<div class="tab-pane fade in" id="tab-references">
					<?php if ($work_experience->_count > 0):?>
					<!-- [1] -->
					<h3>Work Experience</h3>
					<table class="responsive-table">

						<thead>
						<tr>
								<th>Company</th>
								<th>Address</th>
								<th>Nature</th>
								<th>Position</th>
								<th>Tenure</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($work_experience->data as $work):?>
							<tr>
								<td><?php echo _p($work, 'company');?></td>
								<td><?php echo _p($work, 'address');?></td>
								<td><?php echo _p($work, 'nature');?></td>
								<td><?php echo _p($work, 'position');?></td>
								<td><?php echo _d($work->from_date, 'M Y');?> - <?php echo _d($work->to_date, 'M Y');?></td>
							</tr>
							<tr>
								<td colspan="5">
									Immediate: <?php echo _p($work, 'supervisor_name');?>
									<br />
									Duties: <?php echo _p($work, 'duties');?>
									<br />
									Reason for leaving: <?php echo _p($work, 'reason_for_leaving');?>
									<!-- Last Salary is for HR Admin only
									<br />
									Last Salary: *** 0.00
									-->
								</td>
							</tr>
							<?php endforeach;?>	
						</tbody>

					</table>
					<?php endif;?>

					<?php if ($references->_count > 0):?>
					<!-- [2] -->
					<h3>References</h3>

					<table class="responsive-table">

						<thead>
						<tr>
								<th>Name</th>
								<th>Telephone</th>
								<th>Years Known</th>
								<th>Address</th>
								<th>Occupation</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($references->data as $reference):?>
							<tr>	
								<td><?php echo _p($reference, 'name');?></td>
								<td><?php echo _p($reference, 'telephone');?></td>
								<td><?php echo _p($reference, 'years_known');?></td>
								<td><?php echo _p($reference, 'address');?></td>
								<td><?php echo _p($reference, 'occupation');?></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<?php endif;?>

					<?php if ($affiliations->_count > 0):?>
					<!-- [2] -->
					<h3>Affiliation</h3>

					<table class="responsive-table">

						<thead>
						<tr>
								<th>Name</th>
								<th>Position</th>
								<th>Date Joined</th>
								<th>Status</th>
								<th>Date Resigned</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($affiliations->data as $affiliation):?>
							<tr>
								<td><?php echo _p($affiliation, 'name');?></td>
								<td><?php echo _p($affiliation, 'position');?></td>
								<td><?php echo _d($affiliation->date_joined);?></td>
								<td><?php echo $affiliation->date_resigned == '0000-00-00' ? 'Active' : 'Resigned';?></td>
								<td><?php echo _d($affiliation->date_resigned);?></td>
							</tr>		
							<?php endforeach;?>		
						</tbody>

					</table>
					<?php endif;?>
					<div class="row page-border"> </div>

				</div> <!-- end of WORK TAB -->

				<!-- [SKILLS/TRAININGS TAB] -->
				<div class="tab-pane fade in" id="tab-skills">
					<?php if ($skills->_count > 0):?>
					<!-- [1] -->
					<h3>Skills</h3>
					<table class="responsive-table">

						<thead>
						<tr>
								<th>Skill Type</th>
								<th>Skill</th>
								<th>Proficiency</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($skills->data as $skill):?>							
							<tr>
								<td><?php echo _p($skill, 'skill_type');?></td>
								<td><?php echo _p($skill, 'skill');?></td>
								<td><?php echo _p($skill, 'proficiency');?></td>
							</tr>
							<tr>
								<td colspan="3">Remarks: <?php echo _p($skill, 'remarks');?></td>
							</tr>
							<?php endforeach;?>
						</tbody>

					</table>
					<?php endif;?>
					<!-- [2] -->
					<?php if ($trainings->_count > 0):?>
					<h3>Trainings</h3>
					<table class="responsive-table">

						<thead>
						<tr>
								<th>Address</th>
								<th>Date Attended</th>
								<th>Institution</th>
								<th>Remarks</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($trainings->data as $training):?>
							<tr>
								<td colspan="4">Course: <?php echo _p($training, 'course');?></td>
							</tr>
							<tr>
								<td><?php echo _p($training, 'address');?></td>
								<td><?php echo _d($training->from_date, 'M d, Y');?> - <?php echo _d($training->to_date, 'M d, Y');?></td>
								<td><?php echo _p($training, 'institution');?></td>
								<td><?php echo _p($training, 'remarks');?></td>
							</tr>
							<?php endforeach;?>
						</tbody>

					</table>
					<?php endif;?>
					<!-- [3] -->
					<?php if ($tests->_count > 0):?>
					<h3>Test Profile</h3>
					<table class="responsive-table">

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

						<tbody>
							<?php foreach ($tests->data as $test):?>
							<tr>
								<td colspan="6"><?php echo _p($test, 'exam_type');?> : <?php echo _p($test, 'exam_title');?></td>
							</tr>
							<tr>
								<td><?php echo _d($test->date_taken, 'M Y');?></td>
								<td><?php echo _p($test, 'given_by');?></td>
								<td><?php echo _p($test, 'location');?></td>
								<td><?php echo _p($test, 'result_type');?></td>
								<td><?php echo _p($test, 'score_rating');?>%</td>
								<td><a href="#" title="*** up-english-2011.PDF"><i class="icon-folder-open"></i></a></td>
							</tr>
							<?php endforeach;?>
						</tbody>

					</table>
					<?php endif;?>	
					<div class="row page-border"> </div>

				</div> <!-- end of SKILLS/TRAINING TAB -->

				<!-- [PERSONAL TAB] -->
				<div class="tab-pane fade in" id="tab-personal">

					<!-- [1] -->
					<h3>Basic Info</h3>
					<table class="responsive-table">

						<tbody>
							<tr>
								<td style="width:200px;">Nickname</td><td><?php echo $nick_name;?></td>
							</tr>
							<tr>
								<!-- print if gender is female -->
								<td>Maiden Name</td><td>*** Maiden Name</td>
							</tr>
							<tr>
								<td>Date of Birth</td><td><?php echo _d($details->birth_date, 'M d, Y');?> 
									<span class="label label-info"><?php echo get_age($details->birth_date)?> yrs old</span>
								</td>
							</tr>
							<tr>
								<td>Place of Birth</td><td><?php echo _p($details, 'birth_place');?></td>
							</tr>
							<tr>
								<td>Gender</td><td><?php echo _p($details, 'gender');?></td>
							</tr>
							<tr>
								<td>Nationality</td><td><?php echo _p($details, 'nationality');?></td>
							</tr>
							<tr>
								<td>Civil Status</td><td><?php echo _p($details, 'civil_status');?></td>
							</tr>
							<tr>
								<td>Height</td><td><?php echo _p($details, 'height');?></td>
							</tr>
							<tr>
								<td>Weight</td><td><?php echo _p($details, 'weight');?></td>
							</tr>
							<tr>
								<td>Blood Type</td><td><?php echo _p($details, 'blood_type');?></td>
							</tr>
						</tbody>

					</table>

					<!-- [2] -->
					<h3>In Case of Emergency</h3>
					<table class="responsive-table">

						<tbody>
							<tr>
								<td style="width:200px;">Name</td><td>*** Wife Mahistrado</td>
							</tr>
							<tr>
								<td>Relationship</td><td>*** Wife</td>
							</tr>
							<tr>
								<td>Address</td><td>*** Batasan Hills, Quezon City</td>
							</tr>
							<tr>
								<td>Contact No.</td><td>*** 0917-123456789</td>
							</tr>
						</tbody>

					</table>

					<!-- [3] -->
					<h3>Government</h3>
					<table class="responsive-table">

						<tbody>
							<tr>
								<td style="width:200px;">Social Security Number</td><td>*** 33-9999999-9</td>
							</tr>
							<tr>
								<td>Tax Identification Number</td><td>*** 999-999-999</td>
							</tr>
							<tr>
								<td>Philhealth</td><td>*** 20121101</td>
							</tr>
							<tr>
								<td>Tax Status</td><td>*** ME2 <span class="label">Married with 2 dependent</span></td>
							</tr>
						</tbody>

					</table>

					<?php if ($education->_count > 0):?>
					<!-- [3] -->
					<h3>Educational Background</h3>
					<table class="responsive-table">

						<thead>
						<tr>
								<th>From - To</th>
								<th>Date Graduated</th>
								<th>Degree</th>
								<th>Honors</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($education->data as $educ):?>
							<!-- NOTE: display using the sort_order DESC (recent first) from the admin_options TABLE -->
							<tr>
								<td colspan="5"><h5><?php echo _p($educ, 'education_level');?>: <?php echo _p($educ, 'school');?></h5></td>
							</tr>
							<tr>
								<td><?php echo _d($educ->date_from, 'Y');?> - <?php echo _d($educ->date_to, 'Y');?></td>
								<td><?php echo _d($educ->date_graduated, 'Y');?></td>
								<td><?php echo _p($educ, 'degree');?></td>
								<td><?php echo _p($educ, 'honors');?></td>
							</tr>
							<?php endforeach;?>
						</tbody>

					</table>

					<div class="row page-border"> </div>
					<?php endif;?>
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
					<h3>Address</h3>

					<h5 style="margin-top:10px">Present</h5>
					<table class="responsive-table" style="margin-top:10px;">

						<tbody>
							<tr>
								<td style="width:200px;">Unit/Bldg/House/Street</td><td>*** 4F A Francisco Gold</td>
							</tr>
							<tr>
								<td>Subdivision/Village/Barangay</td><td>*** Kamias</td>
							</tr>
							<tr>
								<td>City/Municipality</td><td>*** EDSA, Quezon City</td>
							</tr>
							<tr>
								<td>Province</td><td>*** </td>
							</tr>
							<tr>
								<td>Zip Code</td><td>*** 1101</td>
							</tr>
						</tbody>

					</table>

					<h5 style="margin-top:10px">Permanent</h5>
					<table class="responsive-table" style="margin-top:10px;">

						<tbody>
							<tr>
								<td style="width:200px;">Unit/Bldg/House/Street</td><td>*** 4F A Francisco Gold</td>
							</tr>
							<tr>
								<td>Subdivision/Village/Barangay</td><td>*** Kamias</td>
							</tr>
							<tr>
								<td>City/Municipality</td><td>*** </td>
							</tr>
							<tr>
								<td>Province</td><td>*** Cagayan De Oro</td>
							</tr>
							<tr>
								<td>Zip Code</td><td>*** 1101</td>
							</tr>
						</tbody>

					</table>


					<div class="row page-border"> </div>

				</div> <!-- end of CONTACT TAB -->

				<!-- [ACCOUNTABILITIES TAB] -->
				<div class="tab-pane fade in" id="tab-accountabilities">

					<!-- [1] -->
					<h3>Skills</h3>
					<table class="responsive-table">

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

						<tbody>
							<tr>
								<td colspan="4">
									<h5>*** LAPTOP</h5></td>
								<td colspan="3">
									Remarks: *** Needed for work</td>
							</tr>
							<tr>
								<td>*** Unretuned</td>
								<td>*** 0.00</td>
								<td>*** 1</td>
								<td>*** Systech 0083</td>
								<td>*** Jan 2010</td>
								<td>*** </td>
								<td><a href="#" title="334554734234234234.pdf"><i class="icon-folder-open"></i></a></td>
							</tr>

						</tbody>

					</table>

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

    var messageModel = new MessageModel({recipient_id: <?php echo $user_id;?> });
    var modalMessageForm  = new ModalMessageForm({model: messageModel});
});
</script>