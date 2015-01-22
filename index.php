<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
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
		document.getElementById(sonde).innerHTML=temp[0]+'°C';
		document.getElementById(sonde).style.fontWeight = 'bold';
}};

xhr1.open("GET", "scripts/poll-temp.php?sonde=" + sonde, true);
xhr1.send(null);

setTimeout(function(){polltemp(sonde)},15000);
}

</script>

<?php
$xml = simplexml_load_file('conf.xml');
if ($xml) {
	
	if ($xml->sonde) {
	echo "<body onLoad=\"";
		foreach ($xml->sonde as $xmlsonde){
			echo "polltemp('" . $xmlsonde->serial . "');";
		}
	echo "\">";
?>

<?php
$page = 'Accueil';
include("menu.php" );
?>
<div style="clear:both;margin-left:3%">
<br>
<div style="padding-top:10px;float:left;">
<img style="width:50px;height:50px;" src="images/temp.png">
</div>
<div style="line-height: 1.4;font-size:12px;padding-top:10px;margin-left:100px">
<?

foreach ($xml->sonde as $xmlsonde){
echo "Température ". $xmlsonde->name . " : <span id=" . $xmlsonde->serial . "><b>Polling...</b></span><br>";
}

?>
</div>
<div style="clear:both;padding-top:10px;">
<hr style="width:82%;height:2px;" /> 
</div>
<?
	}else {
?>
<body>
<?php
$page = 'Accueil';
include("menu.php" );
?>
<div style="clear:both;margin-left:3%">
<?
	}
}
?>

<table style="width:30%;clear:both;float:left;" class="tableaurelais">
<tr><th>Equipements</th><th>Actions</th><th>Equipements</th><th>Actions</th></tr>
<?php 
$dom = simplexml_load_file('pin.xml');
if ($dom) {
$numpin = "NumberOfPin";
$numpin = $dom->$numpin;
for($j=0; $j<=1;$j++){
$letter='A';
if($j==1){
$letter='B';
}
for($i = 0; $i <= $numpin; $i++){ 
		$chaine = "pin".$letter.$i;
		$chaine2 = "name".$letter.$i;
		$chaine3 = "type".$letter.$i;
		$pinstatus[$i] = $dom->$chaine;
		$pintrim[$i] = (trim($pinstatus[$i])=="1"?'on':'off');
		$pinname[$i] = $dom->$chaine2;
		$pintype[$i] = $dom->$chaine3;
?>
<tr>
	<td style="min-width:180px;width:15%;"><span style="float:left;"><?php echo $pinname[$i]; ?></span><div style="cursor:auto;float:right;" id="pin<?php echo $letter.$i;?>" class="pinState <?php echo $pintrim[$i]; ?>"></div></td>
	<?php if ($pintype[$i] == 'fugitif') {?>
	<td style="min-width:140px;width:10%;" ><div class="action" style="min-width:100px;width:100px;float:left;" id="fugitif" onclick="fugitif('<?php echo $letter.$i; ?>')"><span>Actionner</span></div></td>
	<?php }elseif ($pintype[$i] == 'onoff') {?>
	<td style="min-width:180px;width:10%;" >
	<div class="action" id="on" onclick="changestate('<?php echo $letter.$i; ?>',1)">
			<span>On</span>
		</div>
		<div class="action" id="off" onclick="changestate('<?php echo $letter.$i; ?>',0)">
			<span>Off</span>
		</div>
	</td>
	
<?php }
$i++;
		$chaine = "pin".$letter.$i;
		$chaine2 = "name".$letter.$i;
		$chaine3 = "type".$letter.$i;
		$pinstatus[$i] = $dom->$chaine;
		$pintrim[$i] = (trim($pinstatus[$i])=="1"?'on':'off');
		$pinname[$i] = $dom->$chaine2;
		$pintype[$i] = $dom->$chaine3;
?>	
	<td style="min-width:180px;width:15%;"><span style="float:left;"><?php echo $pinname[$i]; ?></span><div style="cursor:auto;float:right;" id="pin<?php echo $letter.$i;?>" class="pinState <?php echo $pintrim[$i]; ?>"></div></td>
	<?php if ($pintype[$i] == 'fugitif') {?>
	<td style="min-width:140px;width:10%;" ><div class="action" style="min-width:100px;width:100px;float:left;" id="fugitif" onclick="fugitif('<?php echo $letter.$i; ?>')"><span>Actionner</span></div></td></tr>
	<?php }elseif ($pintype[$i] == 'onoff') {?>
	<td style="min-width:180px;width:10%;" >
	<div class="action" id="on" onclick="changestate('<?php echo $letter.$i; ?>',1)">
			<span>On</span>
		</div>
		<div class="action" id="off" onclick="changestate('<?php echo $letter.$i; ?>',0)">
			<span>Off</span>
		</div>
	</td>
	<?php }}}
}else {
	echo "Erreur de fichier XML";
	}
?>
</table>



</div>
</body>
</html>
