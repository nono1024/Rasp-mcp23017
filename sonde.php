<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>PiHome</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
</head>
<script src="js/script.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/xhr.js"></script>
<link rel="stylesheet" href="css/style.css">

<script type="text/javascript">

function polltemp(sonde) {

var xhr1 = getXMLHttpRequest();

xhr1.onreadystatechange = function() {
        if (xhr1.readyState == 4 && (xhr1.status == 200 || xhr1.status == 0)) {
        var temp = eval(xhr1.responseText);
		document.getElementById(sonde).innerHTML=temp[0];
		document.getElementById(sonde).style.fontWeight = 'bold';
}};

xhr1.open("GET", "scripts/poll-temp.php?sonde=" + sonde, true);
xhr1.send(null);
}

</script>

<body>
<?php
$page = 'Sonde';
include("menu.php" );
?>
<div style="clear:both;margin-left:3%">
<span style="clear:both;"><b>Scanné</b></span>
<hr style="clear:both;width:82%;height:2px;" /> 
<table class="tableaurelais">
<tr><th>Adresse 1 Wire</th><th>Type</th><th>Valeur</th></tr>
<?php 
chdir("/var/www/");
$xml = simplexml_load_file('conf.xml');
if ($xml) {

chdir("/sys/bus/w1/devices/"); 
exec('ls',$output);
$a=0;
foreach ($output as $sondex) {
	$sonde[$a] = $sondex;

	if ($sondex != "w1_bus_master1") {
	
	$family = explode("-", $sondex);
	$familyid[$a] = $family[0];
	/*
	$path = "/sys/bus/w1/devices/".$sonde[$a]."/w1_slave";
		// Open resource file for thermometer
		$thermometer = fopen($path, "r");
		// Get the contents of the resource
		$thermometerReadings = fread($thermometer, filesize($path));
		// Close resource file for thermometer
		fclose($thermometer);
		// We're only interested in the 2nd line, and the value after the t= on the 2nd line
		preg_match("/t=(.+)/", preg_split("/\n/", $thermometerReadings)[1], $matches);
		$temperature = $matches[1] / 1000;
		$temperature = number_format($temperature,2);
		$value[$a] = $temperature; */
?>

<tr>
	<td style="min-width:120px;width:10%;">
		<?php echo $sonde[$a];?>
	</td>
	<td style="min-width:100px;width:10%;">
		<?php echo $familyid[$a];?>
	</td>
	<td style="min-width:60px;width:10%;">
		<span id="<?php echo $sonde[$a];?>" onclick="polltemp('<?php echo $sonde[$a];?>');" >Reading...<span>
	</td>
	<td style="min-width:300px;width:10%;">
		<?$exist = 0;
			foreach ($xml->sonde as $xmlsonde){
			$savesonde= $xmlsonde->serial;
			if ($sonde[$a] == $savesonde) {
			$exist = 1;
			}
			}
			if ($exist == 1) {
		?>	
			<span>Déjà Sauvegardé</span>
		<?
			}else {
		?>
		<input style="float:left;" id="name<?php echo $sonde[$a];?>" value="<?php echo $sonde[$a];?>" class="input" ></input>
		<div class="action" style="min-width:100px;width:100px;float:left;" onclick="savesonde('<?php echo $sonde[$a]; ?>','<?php echo $familyid[$a];?>')">
		<span>Sauvegarder</span>
		</div>
		<?
		
			}
		
		?>
	</td>
	
</tr>
<?
	echo "<script type='text/javascript'> window.onload=polltemp('".$sonde[$a]."'); </script>";
	$a++;
	}
	
}
}
?>
</table>

</div>

<div style="clear:both;padding-top:20px;margin-left:3%">
<span style="clear:both;"><b>Sauvegardé</b></span>
<hr style="clear:both;width:82%;height:2px;" /> 
<table class="tableaurelais">
<tr><th>Nom</th><th>Adresse 1 Wire</th><th>Type</th></tr>
<tr>
<?php 

if ($xml) {
foreach ($xml->sonde as $xmlsonde){
?>
	<td style="min-width:220px;width:12%;">
		<input class="input"  style="float:left;" id="sonde<?php echo $xmlsonde->serial;?>" value="<?php echo $xmlsonde->name; ?>"></input>
		<div class="action" style="min-width:60px;width:60px;float:left;" onclick="savesondename('<?php echo $xmlsonde->serial;?>','<?php echo $xmlsonde->name;?>')">
		<span>Save</span>
		</div>
	</td>
	<td style="min-width:100px;width:10%;">
		<?php echo $xmlsonde->serial;?>
	</td>
	<td style="min-width:60px;width:10%;">
		<?php echo $xmlsonde->familyid;?>
	</td>
		<td style="min-width:60px;width:2%;">
		<div class="action" style="min-width:100px;width:100px;float:left;" onclick="deletesonde('<?php echo $xmlsonde->serial;?>')">
		<span>Delete</span>
	</td>
<tr>
<?
}
}
?>
</div>
</body>
</html>
