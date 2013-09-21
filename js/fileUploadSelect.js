$(function() {
	String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

	
});
var headerHeight = 0;
var imageScaleWidth = 500;
var imageScale;
var img = new Image();
var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
var canvas = document.getElementById('imageCanvas');
var ctx = canvas.getContext('2d');
var setting = 0;
var skinX = new Array();
var skinY = new Array();

var isDrawing = false;
init();
function draw(event) {
    if(isDrawing) {
        //clearCanvas();
       // ctx.drawImage(img,0,0,imageScaleWidth,imageScaleWidth * img.height / img.width);
        
        //ctx.strokeRect(startx,starty,getX(event)-startx,getY(event)-starty);
        //ctx.stroke();
        
    }
    event.preventDefault();
}
 function clearCanvas() {
		ctx.clearRect(0,0,canvas.width,canvas.height);
	}
function start(event) {
    
   // startx = getX(event);
   // starty = getY(event);
    skinX[setting] = getX(event);
    skinY[setting] = getY(event);

    $("#skinX" + setting).val(skinX[setting] / imageScale );
    $("#skinY" + setting).val(skinY[setting] / imageScale );
       
    setting++;
    isDrawing = true;
    event.preventDefault();
}
function stop(event) {
 
    if(isDrawing) {
       

        isDrawing = false;
    }
    event.preventDefault();
}
function init() {
    canvas.addEventListener("touchstart",start,false);
    canvas.addEventListener("touchmove",draw,false);
    canvas.addEventListener("touchend",stop,false);
    canvas.addEventListener("mousedown",start,false);
    canvas.addEventListener("mousemove",draw,false);
    canvas.addEventListener("mouseup",stop,false);
    canvas.addEventListener("mouseout",stop,false);
}

function getX(event) {
    
		if(event.type.contains("touch")) {
			return event.targetTouches[0].pageX-canvas.position().left;
		}
		else {
			return event.layerX;
		}
	}
	
function getY(event) {
 
    if(event.type.contains("touch")) {
        return event.targetTouches[0].pageY-canvas.position().top;
    }
    else {
       return event.layerY;
    }
}
function handleImage(e){

    var reader = new FileReader();
    reader.onload = function(event){
        
        img.onload = function(){
            imageScaleWidth = Math.min(imageScaleWidth,img.width);
            imageScale = imageScaleWidth/img.height;
            canvas.width = imageScaleWidth;
            canvas.height = imageScaleWidth * img.height / img.width;
            ctx.drawImage(img,0,0,imageScaleWidth,imageScaleWidth * img.height / img.width);
            
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);     
}