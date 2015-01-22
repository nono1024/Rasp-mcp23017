function changestate(pin,state){
	$.ajax({
			type: "GET",
			  url: "./global.php?action=cs&pin=" + pin + "&state=" + state,
			success: function(r){
			var result = eval(r);
				if(result.state == 1){
				if (state != '1' || state != '0') {
					var state = ($(document.getElementById("pin"+pin)).hasClass('on')?0:1);
				}
				
					$(document.getElementById("pin"+pin)).removeClass('on');
					$(document.getElementById("pin"+pin)).removeClass('off');
					$(document.getElementById("pin"+pin)).addClass((state=='1'?'on':'off'));
					if (result.link) {
					var link = (result.link).split(",");
						for(var i=0;i<link.length;i++){
						$(document.getElementById("pin"+link[i])).removeClass('on');
						$(document.getElementById("pin"+link[i])).removeClass('off');
						$(document.getElementById("pin"+link[i])).addClass((state=='1'?'on':'off'));
						}
					}				
				}else{
					alert('Erreur : '+result.error);
				}
		 }});
}

function changetype(pin){
	var type = document.getElementById('selectortype'+pin).value;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=changetype&pin=" + pin + "&type=" + type,
			success: function(r){
			
		 }});
}

function changelink(pin,linked){
var operation = 'remove';
if (document.getElementById('linked'+pin+linked).checked == true) {
operation = 'add';
}
	$.ajax({
			type: "GET",
			  url: "./global.php?action=changelink&pin=" + pin + "&linked=" + linked + "&operation=" + operation,
			success: function(r){
			
		 }});
}

function changename(pin){
	var name = document.getElementById('name'+pin).value;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=changename&pin=" + pin + "&name=" + name,
			success: function(r){
			
		 }});
}

function savesonde(serial,familyid){
	var name = document.getElementById('name'+serial).value;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=savesonde&serial=" + serial + "&name=" + name + "&familyid=" + familyid,
			success: function(r){
			location.reload();
		 }});
}

function deletesonde(serial){
	$.ajax({
			type: "GET",
			  url: "./global.php?action=deletesonde&serial=" + serial,
			success: function(r){
			location.reload();
		 }});
}

function savesondename(serial,name){
	var name = document.getElementById('sonde'+serial).value;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=savesondename&serial=" + serial + "&name=" + name,
			success: function(r){
			
		 }});
}



function fugitif(pin){
	var newState = ($(document.getElementById("pin"+pin)).hasClass('on')?1:0);
	$(document.getElementById("pin"+pin)).removeClass((newState==1?'on':'off'));
	$(document.getElementById("pin"+pin)).addClass((newState==1?'off':'on'));
	$.ajax({
			type: "GET",
			 url: "./global.php?action=fugitif&pin=" + pin,
			success: function(r){
			$(document.getElementById("pin"+pin)).removeClass((newState==1?'off':'on'));
			$(document.getElementById("pin"+pin)).addClass((newState==1?'on':'off'));
			
		 }});
}

function advfugitif(pin,time){
	$.ajax({
			type: "POST",
			 url: "./global.php?action=fugitif&pin=" + pin + "&time=" + time,
			 data:{pin:pin,time:time},
			success: function(r){
		 }});
}

function init(){

	$.ajax({
			type: "POST",
			 url: "./global.php?action=init",
			success: function(r){
		
			
		 }});
}

function clear(){

	$.ajax({
			type: "POST",
			 url: "./global.php?action=clear",
			success: function(r){
		
			
		 }});
}

function clearA(){

	$.ajax({
			type: "POST",
			 url: "./global.php?action=clearA",
			success: function(r){
		
			
		 }});
}

function clearB(){

	$.ajax({
			type: "POST",
			 url: "./global.php?action=clearB",
			success: function(r){
		
			
		 }});
}

function demo(){

	$.ajax({
			type: "POST",
			 url: "./global.php?action=demo",
			success: function(r){
		
			
		 }});
}

