var GFBNutritionLabel = function(){};

GFBNutritionLabel.prototype.generateImage = function(){
  var node = [document.getElementById('nutrition-label')],
  servingSizeField = document.getElementById("n-label-servingsizefield")

  servingSizeField.style.display = "none";

  html2canvas(node, {
    // logging: true,
    useCORS: true,
    background :'#FFFFFF',
    allowTaint: true,
    letterRendering: true,
    onrendered: function(canvas) {
      var context = canvas.getContext('2d');
      // context.webkitImageSmoothingEnabled = false;
      context.mozImageSmoothingEnabled = false;
      context.imageSmoothingEnabled = false;
      context.oImageSmoothingEnabled = false;
			var image = canvas.toDataURL("image/jpeg");
			var anchor = document.createElement('a');
	    anchor.setAttribute('download', 'nutrition-label.jpg');
	    anchor.setAttribute('href', image);
	    anchor.click();
    }
  });
  servingSizeField.style.display = "inline";
}

GFBNutritionLabel.prototype.get = function(ingredients, post_id, url){
  var path = url+"?action=nutrition_request&ingredients="+ingredients+"&post_id="+post_id,
  loader = document.getElementById("gfb-nutrition-label-loader"),
  errorMsg = "An error has occured. Please verify that you ingredient(s) are correctly entered line by line.",
  _this = this,
  xmlhttp,
  response

  loader.style.display = "inline";

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState == 4){
      if(xmlhttp.status == 200) {
        try {
          var settings = {
              "showServingUnitQuantity":true,
              "showPolyFat":true,
              "showMonoFat":true,
              // "showDisclaimer" : true,
              "itemName": "",
              "ingredientList": ingredients
            };
          response = JSON.parse(xmlhttp.responseText);
          if(typeof response.Errors === 'undefined') {
            jQuery('#nutrition-label').nutritionLabel(jQuery.extend(settings, response));
          } else {
            _this.notify(errorMsg);
          }
        } catch(error) {
          _this.notify(errorMsg + "\n" + error);
        }
      } else {
        _this.notify(errorMsg);
      }
      loader.style.display = "none";
    }
   }

  xmlhttp.open("GET",path,true);
  xmlhttp.send();
}

GFBNutritionLabel.prototype.update = function(page_number){
  var url = document.getElementById("gfb-nutrition-label-update-url").value,
  path = url+"?action=update_recipes_request",
  loader = document.getElementById("gfb-nutrition-label-loader"),
  _this = this,
  xmlhttp,
  response

  loader.style.display = "inline";

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onload = function(){
    if (xmlhttp.readyState == 4){
      if(xmlhttp.status == 200) {
        console.log("Response: ", xmlhttp.responseText);
        try {
          response = JSON.parse(xmlhttp.responseText);
        } catch(error) {
          _this.notify("\n" + error);
        }
      } else {
        _this.notify("Error!");
      }
    }
   }

  loader.style.display = "none";
  xmlhttp.open("POST",path,false);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("page_number="+page_number);
}

GFBNutritionLabel.prototype.submitForm = function() {
  var contentOfTextArea = document.getElementById("gfb-nutrition-label-textarea").value,
  url = document.getElementById("gfb-nutrition-label-url").value,
  post_id = document.getElementById("gfb-nutrition-label-post-id").value

  if (contentOfTextArea.length <= 1) {
    this.notify("Please add your ingredients before submitting this form.")
    return false;
  } else if (contentOfTextArea.indexOf('!') > -1) {
    this.notify("Please remove exclammation mark (!) from your ingredients listing.")
    return false;
  } else {
    this.get(this.format(contentOfTextArea), post_id, url);
    // document.forms['gfb-nutrition-label-form'].submit();
  }
}

GFBNutritionLabel.prototype.notify = function(message) {
  jQuery('#gfb-nutrition-label-notify').show().html(message).delay(10000).fadeOut('slow');
}

GFBNutritionLabel.prototype.format = function(ingredients) {
  return ingredients.split("\n").join(",").replace(/\s\s+/g, " ").trim();
}

gfbnutritionlabel = new GFBNutritionLabel();
