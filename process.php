<?php
define("NUT_API", "http://nuts.globalfoodbook.net/v1/nutrition/facts?ingredients=");
define(C_URL, admin_url('admin-ajax.php'));
define(META_KEY, "gfb_recipe_meta_nutrition_facts");
ini_set('default_socket_timeout', 900); // increase default_socket_timeout

add_action( 'wp_ajax_nutrition_request', 'nutrition_request' );
add_action( 'wp_ajax_nopriv_nutrition_request', 'nutrition_request' );

function nutrition_request(){
  if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["ingredients"] && !empty($_GET["post_id"]))) {
      $post_id = $_GET["post_id"];
      $nutrition_facts =  process_request($_GET["ingredients"]);
      if (!add_post_meta($post_id, META_KEY, $nutrition_facts, true)) {
         update_post_meta ($post_id, META_KEY, $nutrition_facts);
      }
    } elseif(!empty($_GET["ingredients"])) {
      $ingredients     = $_GET["ingredients"];
      $nutrition_facts = process_request($ingredients);
    }
    echo $nutrition_facts;
  } else {
    echo "{}";
  }
   die();
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
