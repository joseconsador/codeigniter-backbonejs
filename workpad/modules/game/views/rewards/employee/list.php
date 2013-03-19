<div class="container-fluid">
  <div class="page-header">
    <h2>Rewards Shop</h2>
  </div>

  <div class="row-fluid" id="rewards-container">
    <?php $this->load->view('rewards/template/list_item');?>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      <?php if ($rewards->_count > 0):?>
      var rewardsCollection = new RewardsCollection(<?php echo json_encode($rewards->data)?>);
      <?php ; else : ?>
      var rewardsCollection = new RewardsCollection();
      <?php endif;?>

      var rewardShopView = new RewardShopView({collection: rewardsCollection});

      rewardShopView.render();
    });
  </script>