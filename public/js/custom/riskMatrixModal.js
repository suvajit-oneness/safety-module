function openRiskMatrix(){
	//alert('Hello');
	$('#pop-bg').show();
	$('#popWindow').show();
	
	// Enable draggable and align popup to center
	$('#popWindow').draggable({cursor: "move", handle: '.pop-drag'});
	popalign();
}

$('#close-pop').click(function(){
	$('#pop-bg').hide();
	$('#popWindow').hide();
});

$(window).resize(function(){
	popalign();
});
function popalign(){
	var winH = $('body').height();
	var winW = $('body').width();
	//var winH = 1200;
	//var winW = 1900;
	//Set the popup window to center
	$("#popWindow").css('top',  winH/2-$("#popWindow").height()/2);
	$("#popWindow").css('left', winW/2-$("#popWindow").width()/2);
}
