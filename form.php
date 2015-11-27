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
    <div class='section3'>
      <textarea id="gfb-nut-textarea" rows='12' cols='33' readonly>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script type="text/javascript" src="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/javascript/nutritionLabel-min.js"></script>
      <link rel="stylesheet" href="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/css/nutritionLabel-min.css" type="text/css" media="all">
      </textarea>
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery( document ).ready(function() {
  jQuery('#nutrition-label').nutritionLabel();
  code = jQuery.trim(jQuery('#gfb-nut-textarea').text()+jQuery('#nutrition-label').clone().html());
  jQuery('#gfb-nut-textarea').val(code);
  // jQuery('#nutrition-label').clone().appendTo('#gfb-nut-textarea');
});

</script>
