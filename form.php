<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["ingredients"])) {
    $ingredients = $_POST["ingredients"];
    $nutrition = process_request($ingredients);
  }
}

function process_request($ingredients){
  $url = NUT_API.urlencode(options($ingredients));

  $context = stream_context_create(array('http'=>array('method'=>"GET")));
  $json = file_get_contents($url, 0, $context);
  return json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
}

function options($ingredients){
  return implode(",", explode("\n", trim($ingredients)));
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
  <div class='gfb-nutrition-label-section'>
    <?php require_once 'sections.php'; ?>
  </div>
</div>
