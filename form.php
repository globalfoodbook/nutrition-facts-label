<style media="screen">
  .gfb-nutrition-label-section{
    padding-top: 30px;
  }
  #nutrition-label-outer {
    background-color: white;
    width: auto !important;
  }
  .gfb-nutrition-label-section .section2 {
    padding-left: 40px
  }
  .gfb-nutrition-label-section .section1, .gfb-nutrition-label-section .section2 {
    vertical-align: top;
    display: inline-block !important;
    overflow: hidden;
  }
  #gfb-nutrition-label-notify {
    color: red !important;
    font-weight: bold;
    margin-left: 12px;
  }
</style>
<div class='wrap'>
  <div class='gfb-nutrition-label-section'>
    <img id="gfb-nutrition-label-loader" src="<?php echo plugin_dir_url( __FILE__ ) .'includes/assets/images/load.gif'?>" style="display:none"/>
    <p id="gfb-nutrition-label-notify" style="display:none"></p>
    <div>
      <?php require_once 'sections.php'; ?>
    </div>
  </div>
</div>
