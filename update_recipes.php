<?php
  $args = array(
    'post_type' => 'recipe',
    'post_status' => 'publish'
  );

  if($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = new WP_Query($args);
  }
  // if($_SERVER["REQUEST_METHOD"] == "POST") {
  //     update_recipes_request();
  // }
?>
<style media="screen">
  #gfb-nutrition-label-update-button {
    display: block;
    width: 140px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-color:transparent;
    border-radius: 5px;
    color: white;
    font-size:13.5px;
    font-weight: bold;
    cursor: pointer;
  }
</style>
<div class='wrap'>
  <img id="gfb-nutrition-label-loader" src="<?php echo plugin_dir_url( __FILE__ ) .'includes/assets/images/load.gif'?>" style="display:none"/>
  <p id="gfb-nutrition-label-notify" style="display:none"></p>
  <p>NB: You need to be an administrator to use this feature. Please backup your database before starting this process.</p>
  <div class='gfb-nutrition-label-section'>
    <form name='gfb-nutrition-label-form' method='post' action='#'>
      <input id='gfb-nutrition-label-update-button' type='button' name='Submit' value='Update All Recipes' style='' />
      <input id='gfb-nutrition-label-update-url' type='hidden' name='url' value='<?php echo C_URL;?>' style='' />
    </form>
  </div>
</div>

<script type='text/javascript'>
  jQuery('#gfb-nutrition-label-update-button').on('click', function(){
    console.log("Clicking");
    for(i = 1; i <= <?php echo $query->max_num_pages; ?>; i++) {
      gfbnutritionlabel.update(i);
    }
  });
</script>
