<?php
/*
If you have setup your own private Nutrition API server then you can set up an environment variable
Example:
In system profiles files like ~/.bashrc ~/.profile or /etc/environment etc
export NUT_API = 'http://<ip or domain>/v1/nutrition/facts?ingredients='

or

In /etc/php-fpm.conf
env[NUT_API] = 'http://<ip or domain>/v1/nutrition/facts?ingredients='

This would be use by default else it would fallback to publie nutrion api.

HOW TO ADD ENVIRONMENT VARIABLES:
OPEN
/etc/php.ini
FIND
variables_order = "GPCS"
REPLACE TO
variables_order = "EGPCS"
# http://php.net/manual/ru/ini.core.php#ini.variables-order
OPEN
/etc/php-fpm.d/www.conf (maybe /etc/php5/fpm/pool.d/www.conf)
(do not confuse with /etc/php-fpm.conf)
FIND IF EXIST
clear_env = yes
REPLACE TO OR ADD
clear_env = no
# http://php.net/manual/en/install.fpm.configuration.php
OPEN
/etc/environment
ADD
#any variables you need, for example:
MY_VAR=1234
RUN IN SHELL FOR CHECK
source /etc/environment
echo $MY_VAR # 1234
RUN IN SHELL
ln -fs /etc/environment /etc/sysconfig/php-fpm
systemctl daemon-reload && service php-fpm restart
TESTING THE ENVIRONMENT VARIABLE
OPEN
index.php # in your project folder, running with php-fpm
ADD
var_dump(getenv('MY_VAR'), $_ENV['MY_VAR']);exit;
RUN IN BROWSER
http://mylink.to.project/index.php
string(4) "1234"
string(4) "1234"
ENJOY!
SEE THIS FOR MORE: http://stackoverflow.com/questions/30822695/how-to-get-php-to-be-able-to-read-system-environment-variables
*/

if(isset($_ENV["NUT_API"])) {
  define("NUT_API", $_ENV["NUT_API"]);
} else {
  define("NUT_API", "http://nuts.globalfoodbook.net/v1/nutrition/facts?ingredients=");
}
define(C_URL, admin_url('admin-ajax.php'));
define(META_KEY, "gfb_recipe_meta_nutrition_facts");
ini_set('default_socket_timeout', 900); // increase default_socket_timeout

add_action( 'wp_ajax_nutrition_request', 'nutrition_request' );
add_action( 'wp_ajax_nopriv_nutrition_request', 'nutrition_request' );

function nutrition_request(){
  if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["ingredients"]) && !empty($_GET["post_id"])) {
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
  $context = stream_context_create(array('http'=>array('method'=>'GET','ignore_errors'=>TRUE)));

  $json = file_get_contents($url, 0, $context);

  return json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
}

function options($ingredients){
  if(is_array($ingredients)) {
    return implode(",", $ingredients);
  } else {
    return implode(",", explode("\n", trim($ingredients)));
  }
}

function isValid($response) {
  if(property_exists(json_decode($response), 'valueCalories') == 1) {
    return true;
  } else {
    return false;
  }
}

add_action( 'wp_ajax_update_recipes_request', 'update_recipes_request' );
function update_recipes_request() {
  if (!empty($_POST["id"])) {
    $post_id     = $_POST["id"];
    $post        = get_post($post_id);
    $url         = post_permalink($post_id);
    $ingredients = get_post_meta($post_id, 'RECIPE_META_ingredients', true);

    $nutrition_facts = process_request($ingredients);
    if(isValid($nutrition_facts)) {
      if (!add_post_meta($post_id, META_KEY, $nutrition_facts, true)) {
         update_post_meta ($post_id, META_KEY, $nutrition_facts);
      }
      echo json_encode(array('ID' => $post->ID,'post_title' => $post->post_title,'url' => $url, 'success' => true, 'error' => false, 'message' => 'Update successful.'));
    } else {
      echo json_encode(array('ID' => $post->ID,'post_title' => $post->post_title,'url' => $url, 'success' => false, 'error' => true, 'message' => 'Update unsuccessful.'));
    }
  }
  die();
}
?>
