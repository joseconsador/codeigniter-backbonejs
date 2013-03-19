    <div class="container-fluid">

      <div class="row-fluid">
        <div class="span12 well" id="profile-header">

        <img src="<?php echo $employee->thumbnail_url?>" id="user-photo">
        <h2><?php echo _p($employee, 'first_name')?>, <?php echo _p($employee, 'last_name')?></h2>
        <p class="grey"><?php echo _p($employee, 'position')?>, <?php echo _p($employee, 'company')?></p>
        <br/>

        <div class="profile-stats">
          <p class="grey">Level</p>
          <h1>24</h1>      
        </div>

        <div class="profile-stats">
          <p class="grey">Points</p>
          <h1>250</h1>      
        </div>

        <div class="profile-stats">
          <p class="grey">Badge</p>
          <h1>8</h1>      
        </div>

        <div class="profile-stats">
          <p class="grey">Trophy</p>
          <h1>1</h1>       
        </div>

        <div class="profile-stats" style="border:0">
          <p class="grey">Thank You's</p>
          <h1>16</h1>      
        </div>

        <div class="clearfix"></div>
        
      </div>

      <div class="row-fluid"> 
        <div class="span12">

          <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#tab-a" data-toggle="tab">Activities</a></li>
              <li><a href="#tab-b" data-toggle="tab">Wall of Recognition</a></li>
              <li><a href="#tab-goals" data-toggle="tab">Goals Overview</a></li>
              <li><a href="#tab-d" data-toggle="tab">Reward Shop</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="tab-a">
                <div class="span4 well dash-box">
                  <h3>Activity Feed</h3>
                  <?php if (count($activities) > 0):?>
                    <?php foreach ($activities as $day => $day_activities):?>
                      <div class="activity-feed-box">
                        <h4><?php echo _d($day, 'M d');?></h4>                                
                        <ul>
                          <?php foreach ($day_activities as $activity):?>
                          <li>
                            <strong><?php echo _d($activity->created, 'h:i');?></strong> 
                            : <?php echo $activity->get_display();?>
                          </li>
                          <?php endforeach;?>
                        </ul>
                      </div>
                    <?php endforeach;?>
                  <?php endif;?>
                </div>

                <div class="span4 well dash-box">
                  <h3>Notes</h3>
                  <textarea name="note" class="yellow-pad" placeholder="Write your notes here..."><?php echo $notes->note;?></textarea>
                </div>

                <div class="span4 well dash-box">   
                  <?php $this->load->view('todo/main');?>
                </div> 
              
              </div>

              <div class="tab-pane fade" id="tab-b">
                <div class="page-header">
                  <h3>Trophy</h3>
                </div>
          
                <ul class="thumbnails">
                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_1.png"></a>

                      <div class="caption well">
                        <h5>Trophy Title</h5>
                        <p>Some description about this trophy, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>
                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_2.png"></a>

                      <div class="caption well">
                        <h5>Trophy Title</h5>
                        <p>Some description about this trophy, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>
                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_3.png"></a>

                      <div class="caption well">
                        <h5>Trophy Title</h5>
                        <p>Some description about this trophy, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>
                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_4.png"></a>

                      <div class="caption well">
                        <h5>Trophy Title</h5>
                        <p>Some description about this trophy, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>
                </ul>

                <div class="page-header">
                  <h3>Badge</h3>
                </div>

                        
                <ul class="thumbnails">

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/badge_1.png"></a>
                      
                      <div class="caption well">
                        <h5>Badge title</h5>
                        <p>some description about this unlocked badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/badge_2.png"></a>
                      
                      <div class="caption well">
                        <h5>Badge title</h5>
                        <p>some description about this unlocked badge, lorem ipsum dolor set amet.</p>                
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/badge_3.png"></a>
                      
                      <div class="caption well">
                        <h5>Badge title</h5>
                        <p>some description about this unlocked badge, lorem ipsum dolor set amet.</p>                 
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                   
                </ul>

                <ul class="thumbnails">

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                  <li class="span2">
                    <div class="thumbnail">
                      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/default_off_big.png"></a>
                      
                      <div class="caption well">
                        <h5>Locked Badge</h5>
                        <p>description on how to unlock this badge, lorem ipsum dolor set amet.</p>               
                      </div>
                    </div>
                  </li>

                   
                </ul>

                <div class="page-header">
                  <h3>Thank you's</h3>
                </div>

                <ul class="thumbnails">

                  <li class="span1">
                    <div class="thumbnail">

                      <a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Smith"><img src="<?php echo base_url();?>/extra/img/user-photo.jpg"></a>

                    </div>
                  </li>

                  <li class="span1">
                    <div class="thumbnail">
                     
                      <a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Smith"><img src="<?php echo base_url();?>/extra/img/user-photo.jpg"></a>

                    </div>
                  </li>

                  <li class="span1">
                    <div class="thumbnail">
                      
                      <a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Smith"><img src="<?php echo base_url();?>/extra/img/user-photo.jpg"></a>

                    </div>
                  </li>

                  <li class="span1">
                    <div class="thumbnail">
                      
                      <a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Smith"><img src="<?php echo base_url();?>/extra/img/user-photo.jpg"></a>

                    </div>
                  </li>
                </ul>

              </div>
              <div class="tab-pane fade" id="tab-goals">
                <?php $this->load->view('dashboard/employee/goals');?>
              </div>
              <div class="tab-pane fade" id="tab-d">
                <ul class="thumbnails">
                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>Ipad 2</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>

                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>2 Days Vacation Leave</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>

                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>Ipad 2</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>
                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>2 Days Vacation Leave</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>
                </ul>

                <ul class="thumbnails">
                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>Ipad 2</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>

                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>2 Days Vacation Leave</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>

                  <li class="span3">
                    <div class="thumbnail">
                      <img src="http://placehold.it/260x180" alt="">
                      <div class="caption">
                        <h5>Ipad 2</h5>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a href="#" class="btn btn-success">Redeem</a> <a href="#" class="btn">Add to wishlist</a></p>
                      </div>
                    </div>
                  </li>
                 
                </ul>

              </div>

            </div>
                      
        </div>
      </div>
    </div>

    <script>
      $(function() {

        notes = new NoteView({model: new UserNoteModel(<?php echo json_encode($notes);?>)});

        $('a[rel*=popover]').popover({
          placement: get_popover_placement
        });

        function get_popover_placement(pop, dom_el) {
          var width = window.innerWidth;
          if (width<500) return 'bottom';
          var left_pos = $(dom_el).offset().left;
          if (width - left_pos > 400) return 'right';
          return 'left';
        }

      });
    </script>
