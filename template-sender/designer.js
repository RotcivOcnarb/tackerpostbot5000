var minRectSize = 5;
var maxRectCount = 20;
var maxWidth = 500;
var intersectLeniency = 100;

var canvas;
var ctx;
var penId = 1;
var styles =   ["#000000",
				"#ff2222","#00ff00","#0000ff","#5C2A83", //red green blue purple
				"#fe7eff","#fff400","#ffb400","#00738b", //pink yellow orange cyan
				"#2abaca","#787878","#036500","#c10000"];//teal grey dgreen crimson

var isDragging;

var rectStartX;
var rectStartY;
var mouseX;
var mouseY;

var rects;

var size = {};

var keys = {};

//is called when the page has finished loading
function init(width, height, path){
	$('#canvas').css({'background': 'url('+path+')',
					  'background-size': 'cover'});
	if(isTouchScreen()){
		$('input.control').css({ 'height': '80px', 'font-size': '24px' });
	}
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	resizeCanvas(width, height);
	registerListeners();
	resetRects();
	doLiveUpdate();
}

//reinitializes the rects variable, then redraws. used for initialization and clearing
function resetRects(){
	rects = [];
	draw();
	doLiveUpdate();
}

function resizeCanvas(width, height){
	var scale = maxWidth / width;
	size.x = width * scale;
	size.y = height * scale;

	canvas.width = size.x;
	canvas.height = size.y;
}

//draws based on the mouse info and rects variable
function draw(){
	//clear the screen
	ctx.clearRect(0, 0, canvas.width, canvas.height);

	//first, the rectangle being currently drawn
	ctx.strokeStyle = styles[penId];
	if(isDragging){
		ctx.setLineDash([3,3]);
		ctx.strokeRect(rectStartX, rectStartY, mouseX - rectStartX, mouseY - rectStartY);
		ctx.setLineDash([1,0]);
	}

	//then all the rectangles that have been drawn already
	for(var p = 0; p < rects.length; p++){
		var rdata = rects[p];
		var rect = rdata[1].pos;
		if(typeof rdata[1].colour !== 'undefined') {
			ctx.fillStyle = '#'+rdata[1].colour;
			ctx.fillRect(rect[0], rect[1], rect[2] - rect[0], rect[3] - rect[1]);
		}
		ctx.strokeStyle = styles[rdata[0]];
		ctx.strokeRect(rect[0], rect[1], rect[2] - rect[0], rect[3] - rect[1]);
	}
}

//starts the rectangle drawing process
//called when the mouse is pressed down
function startDrawingRect(event){
	updateMouseCoords(event);
	rectStartX = mouseX;
	rectStartY = mouseY;
	draw();
}

//updates the rectangle drawing process
//called when the mouse is dragged
function updateDrawingRect(event){
	updateMouseCoords(event);
	draw();
}

//finishes the rectangle drawing process
//called when the mouse is released
function addRectangle(){
	var x1 = Math.min(mouseX, rectStartX);
	var y1 = Math.min(mouseY, rectStartY);
	var x2 = Math.max(mouseX, rectStartX);
	var y2 = Math.max(mouseY, rectStartY);
	var width = x2 - x1;
	var height = y2 - y1;
	if (penId == 0) {
		rects = rects.filter(function(d) {
			var r = d[1];
			if (x1 <= r[0] && y1 <= r[1] && x2 >= r[2] && y2 >= r[3]) {
				return false;
			}
			return true;
		});
		doLiveUpdate();
	} else if (width > minRectSize && height > minRectSize && getRectCount() < maxRectCount/* && !checkIntersection(x1, y1, x2, y2)*/){
		var data = [penId, {pos: [x1, y1, x2, y2]}];
		if(shouldAddFillColour()){
			if(isFillColourValid()){
				data[1].colour = getSelectedFillColour();
			}
		}
		var filter = $('#filter').val()
		if(filter != "none"){
			data[1].filter = filter;
		}
		rects.push(data);
		doLiveUpdate();
	}
	draw();
}

//returns true if the specified coordinates intersect with any other coordinates
function checkIntersection(x1, y1, x2, y2){
	for(var p = 0; p < rects.length; p++){
		var rect = rects[p][1];
		var xOverlap = Math.max(0, Math.min(x2, rect[2]) - Math.max(x1, rect[0]));
		var yOverlap = Math.max(0, Math.min(y2, rect[3]) - Math.max(y1, rect[1]));
		if(xOverlap * yOverlap > intersectLeniency){
			return true;
		}
	}
	return false;
}

//updates the saved mouse coordinates
function updateMouseCoords(e){
	var rect = canvas.getBoundingClientRect();
	var clientX = null;
	var clientY = null;
	if (e.originalEvent) {
		if (e.originalEvent.touches && e.originalEvent.touches.length) {
			var touch = e.originalEvent.touches[0];
			clientX = touch.clientX/* - $(document).scrollLeft()*/;
			clientY = touch.clientY/* - $(document).scrollTop()*/;
		}
	}

	if(clientX == null){
		clientX = e.clientX;
		clientY = e.clientY;
	}

	mouseX = clientX - rect.left;
	mouseY = clientY - rect.top;
}

function isTouchScreen(){
	return 'ontouchstart' in document.documentElement;
}

function getRectCount(){
	return rects.length;
}

function undo() {
	if (rects.length) {
		rects.pop();
		draw();
		doLiveUpdate();
	}
}

function shouldAddFillColour(){
	return $('#fillcolourchk').is(':checked');
}

function isFillColourValid(){
	var colour = getSelectedFillColour();
	return /^[0-9A-F]{6}$/i.test(colour);
}

function getSelectedFillColour(){
	return $('#fillcolour').val();
}

//registers all the click listeners, including the ones for the canvas
function registerListeners(){
	$('#pen-colour').change(function(){
		penId = $(this).val();
	});

	$('#undo').click(undo);

	$('#clear').click(resetRects);

	$('#refresh').click(function(){
		doLiveUpdate();
	});

	$('div.tbutton').click(function(){
		$('div.tbutton').removeClass("active");
		$(this).addClass("active");
    });

	$('#canvas').on('mousedown touchstart', function(event){
		event.preventDefault(); //disables the text select cursor from showing up
		isDragging = true;
		startDrawingRect(event);
		return false;
	});

	$('#canvas').on('mousemove touchmove', function(event){
		event.preventDefault();
		if (isDragging) {
			updateDrawingRect(event);
		}
		return false;
	});

	$('#canvas').on('mouseup touchend', function(event){
		isDragging = false;
		addRectangle();
		return false;
	});

	$(document).keydown(function (e) {
		keys[e.which] = true;
		if(keys.hasOwnProperty(17) && keys.hasOwnProperty(90)){
			undo();
		}
	});

	$(document).keyup(function (e) {
		delete keys[e.which];
	});
}

function round(num){
	return Math.round(num * 10000) / 10000
}

function format() {
	var all = rects.slice().sort(function(d, f){ return d[0] - f[0]});
	var	lst = null;
	var	out = [];
	for (var i = 0; i < all.length; i++) {
		var cur = all[i];
		var	pen = cur[0];
		if (lst != pen) {
			var locs = [];
			out.push(locs);
			lst = pen;
		}
		var ecl = cur[1].pos;
		var	pos =
		{
			pos: [
				round(ecl[0] / size.x),
				round(ecl[1] / size.y),
				round(ecl[2] / size.x),
				round(ecl[3] / size.y)
			]
		};
		if(typeof cur[1].colour !== 'undefined'){
			pos.colour = cur[1].colour;
		}
		if(typeof cur[1].filter !== 'undefined'){
			pos.filter = cur[1].filter;
		}
		locs.push(pos);
	}
	return out;
}

function doLiveUpdate(){
	$('#designer-submit').prop('disabled', rects.length == 0);
	$('#json').text(JSON.stringify(format(), null, 2));
	$('#preview').attr("href", "/liveupdate?rects="+JSON.stringify(format())+'&t='+new Date().getTime());
	$('#form-positions').val(JSON.stringify(format()));
	$('pre').text(JSON.stringify(format(), null, 4));
}

$(document).ready(function(){
	$.get('/template/active-data', function(data){
		init(data.width, data.height, data.path);
	});
});
