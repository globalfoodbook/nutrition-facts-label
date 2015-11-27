var GFBNutritionLabel = function(){};

GFBNutritionLabel.prototype.generateImage = function(){
  var node = [document.getElementById('nutrition-label')];
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
			// console.log("Image: ", image);
			// window.location.href=image;
			var anchor = document.createElement('a');
	    anchor.setAttribute('download', 'nutrition-label.jpg');
	    anchor.setAttribute('href', image);
	    anchor.click();
    }
  });
}

GFBNutritionLabel.prototype.get = function(ingredients, url){
  var path = url+"?action=nutrition_request&ingredients="+ingredients,
  xmlhttp

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function(){
   if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
     {
      var settings = {
          "showServingUnitQuantity":true,
          "showPolyFat":true,
          "showMonoFat":true,
          // "showDisclaimer" : true,
          "itemName": "",
          "ingredientList": ingredients
        };
        jQuery('#nutrition-label').nutritionLabel(jQuery.extend(settings, JSON.parse(xmlhttp.responseText)));
     }
   }
  //  console.log("url: ", path);
  xmlhttp.open("GET",path,true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send();
}

GFBNutritionLabel.prototype.submitForm = function() {
  var contentOfTextArea = document.getElementById("gfb-nutrition-label-textarea").value,
  url = document.getElementById("gfb-nutrition-label-url").value,
  ingredients

  if (contentOfTextArea.length <= 1) {
    alert("Please add your ingredients before submitting this form.")
    return false;
  } else if (contentOfTextArea.indexOf('!') > -1) {
    alert("Please remove exclammation mark (!) from your ingredients listing.")
    return false;
  } else {
    ingredients = contentOfTextArea.split("\n").join(",").trim();
    this.get(ingredients, url);
    // document.forms['gfb-nutrition-label-form'].submit();
  }
}
gfbnutritionlabel = new GFBNutritionLabel();
