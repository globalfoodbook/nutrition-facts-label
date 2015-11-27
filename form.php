<style media="screen">
  .gfb-nutrition-label-section .section1, .gfb-nutrition-label-section .section2 {
    width:350px !important;
  }
</style>
<div class='wrap'>
  <h1><?php echo __( 'Nutrition Facts Label by <a href="http://globalfoodbook.com" target="_blank">Global Food Book</a>', 'menu-gfb-nutrition-label' ) ?> </h1>
  <div class='gfb-nutrition-label-section'>
    <div class='section1'>
      <form method='post' action='form.php'>
         <h4>Ingredients:</h4>
         <p><textarea name='ingredients' rows='12' cols='33'></textarea></p>
         <p><input type='submit' name='Submit' value='Generate Label' /></p>
      </form>
    </div>
    <div class='section2'>
    </div>
  </div>
</div>
