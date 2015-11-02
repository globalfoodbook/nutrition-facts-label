var GFBNutritionLabel = function(){};

GFBNutritionLabel.prototype.generateImage = function(){
  var node = [document.getElementById('nutrition-label')];
  html2canvas(node, {
   // logging: true,
   // useCORS: true,
    onrendered: function(canvas) {
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
gfbnutritionlabel = new GFBNutritionLabel();
