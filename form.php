<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["ingredients"])) {
    $ingredients = $_POST["ingredients"];
    process_request($ingredients);
  }
}

function process_request($ingredients){
  $api = "http://nuts.globalfoodbook.net/v1/nutrition?ingredients=";
  $url = $api.urlencode(implode(",", explode("\n", trim($ingredients))));
  $opts = array(
  'http'=>array(
    'method'=>"GET"
    )
  );

  $context = stream_context_create($opts);
  $json = file_get_contents($url, 0, $context);
  $response = json_decode($json);
  return $response;
}
?>
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
      <form method='post' action='<?php echo admin_url( 'admin.php' ); ?>?page=gfb-nutrition-label-settings'>
         <h4>Ingredients:</h4>
         <p><textarea name='ingredients' rows='12' cols='33'><?php echo $ingredients; ?></textarea></p>
         <p><input type='submit' name='Submit' value='Generate Label' /></p>
      </form>
    </div>
    <div class='section2'>
       <h4>Nutrition Facts Label:</h4>
      <div id="nutrition-label-outer">
        <div id="nutrition-label"> </div>
      </div>
       <p><input type='button' onclick='generateImage()' value='Download' /></p>
    </div>
    <div class='section3'>
       <h4>Embedded Code:</h4>
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

function generateImage(){
  domtoimage.toPng(document.getElementById('nutrition-label'))
    .then(function (dataUrl) {
      console.log('Image url:', dataUrl)
      var img = new Image();
      img.src = dataUrl;
      document.appendChild(img);
    })
    .catch(function (error) {
      console.error('oops, something went wrong!', error);
  });
}

</script>
