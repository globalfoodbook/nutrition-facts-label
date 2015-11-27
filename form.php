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
      <div id="nutrition-label-outer">
        <div id="nutrition-label"> </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery( document ).ready(function() {
  jQuery('#nutrition-label').nutritionLabel();
});
</script>
