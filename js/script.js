function changestate(pin,states){
	$.ajax({
			type: "GET",
			  url: "./global.php?action=cs&pin=" + pin + "&state=" + states,
			success: function(r){
			var result = eval(r);
				if(result.state == 1){
					$(document.getElementById("pin"+pin)).removeClass('on');
					$(document.getElementById("pin"+pin)).removeClass('off');
					$(document.getElementById("pin"+pin)).addClass((states=='1'?'on':'off'));
					if (result.link) {
					var link = (result.link).split(",");
						for(var i=0;i<link.length;i++){
						$(document.getElementById("pin"+link[i])).removeClass('on');
						$(document.getElementById("pin"+link[i])).removeClass('off');
						$(document.getElementById("pin"+link[i])).addClass((states=='1'?'on':'off'));
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
			location.reload();
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

function changeinput(pin,type){
	var url = document.getElementById('input'+ type + pin).value;
	var uri = encodeURIComponent(url);
	$.ajax({
			type: "GET",
			  url: "./global.php?action=changeinput&mcppinpin=" + pin + "&mcptypetype=" + type +"&mcpurlurl=" + uri,
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

function change(type){
	var val = document.getElementById(type).value;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=change&type=" + type + "&val=" + val,
			success: function(r){
			
		 }});
}

function changeinvert(pin){
if (document.getElementById('invert'+pin).checked == true) {
var val = 1;
}else if (document.getElementById('invert'+pin).checked == false) {
var val = 0;
}
var type = 'invert' + pin;
	$.ajax({
			type: "GET",
			  url: "./global.php?action=change&type=" + type + "&val=" + val,
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

function razinput(pin){
	var r = confirm("Remettre à 0 le compteur " + pin + " ?");
	if (r == true) {
		$.ajax({
			type: "GET",
			  url: "./global.php?action=razinput&pin=" + pin,
			success: function(r){
			document.getElementById("countpin" + pin).innerHTML= 0;
		 }});
	}
	
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

