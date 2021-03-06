﻿<!doctype html>
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
<link rel="stylesheet" href="css/style.css">
<body>
<?php
$page = 'Advanced';
include("menu.php" );

$dom = simplexml_load_file('pin.xml');
if ($dom) {
$refreshpin = "refreshpin";
$refreshpin = $dom->$refreshpin;
?>
<div style="clear:both;margin-left:3%">
	<span style="margin-top:0px;float:left;">Délai de mise à jour Status Pin (Page Accueil) &nbsp </span>
	<input class="input" style="margin-top:0px;float:left;width:28px;" id="refreshpin" value="<?php echo $refreshpin; ?>"></input>
	<span style="margin-top:0px;float:left;">&nbsp Secondes</span>
	<div style="color:white;width:40px;float:left;height:20px;padding:3px;padding-left:10px;" class="action" id="name" onclick="change('refreshpin')">Save
	</div>
</div>
<div style="clear:both;margin-left:3%">
<table class="tableaurelais">
<tr><th>Nom</th><th>Pin</th><th>Type</th><th>Inversé</th><th>Link</th></tr>
<?php 
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
		$chaineinvert = "invert".$letter.$i;
		$pinname[$i] = $dom->$chaine2;
		$pintype[$i] = $dom->$chaine3;
		$pininvert[$i] = $dom->$chaineinvert;
		if ($pininvert[$i] == 1) {
		$invertchecked = 'checked';
		}
		$chaine4 = "link".$letter.$i;
		$pinlinked = $dom->$chaine4;
		$piecelinked = explode(";", $pinlinked);
		if ($pintype[$i] == 'fugitif') {
		$pinother[$i] = 'onoff';
		$pinother2[$i] = 'entree';
		}elseif ($pintype[$i] == 'onoff') {
		$pinother[$i] = 'fugitif';
		$pinother2[$i] = 'entree';
		}elseif ($pintype[$i] == 'entree') {
		$pinother[$i] = 'fugitif';
		$pinother2[$i] = 'onoff';
		}

?>
<tr>
	<td style="min-width:290px;width:10%;">
		<input id="name<?php echo $letter.$i; ?>" value="<?php echo $pinname[$i]; ?>" class="input"></input>
		<div style="float:right" class="action" id="name" onclick="changename('<?php echo $letter.$i; ?>')">Save
		</div>
	</td>
	<td style="min-width:50px;width:10%;">
		<?php echo $letter.$i;?>
	</td>
	<td style="min-width:100px;width:10%;">
	<select id="selectortype<?php echo $letter.$i;?>" name="selectortype<?php echo $letter.$i;?>" class="input" onchange="changetype('<?php echo $letter.$i; ?>')">
        <option value="<?php echo $pintype[$i]; ?>"><?php echo $pintype[$i]; ?></option>
        <option value="<?php echo $pinother[$i]; ?>"><?php echo $pinother[$i]; ?></option>
		<option value="<?php echo $pinother2[$i]; ?>"><?php echo $pinother2[$i]; ?></option>
	</select>
	</td>
	<td style="min-width:70px;width:5%;">
	<input type="checkbox" id="invert<?php echo $letter.$i;?>" <?php echo $invertchecked;?> onchange="changeinvert('<?php echo $letter.$i;?>')">
	</td>
	<td style="min-width:600px;width:10%;">
	<?php
	if ($pintype[$i] != 'entree') { 
		for($a=0; $a<=1;$a++){
		$letter2='A';
		if($a==1){
		$letter2='B';
		}
		for($b = 0; $b <= $numpin; $b++){
		$checked = "";
		$pins = $letter.$i;
		$testlink = $letter2.$b;
		foreach ($piecelinked as $piece){
			if ($piece == $testlink) {
			$checked = 'checked';
			}
		}
		
		if ($pins != $testlink) {
	?>
	<input type="checkbox" id="linked<?php echo $pins; ?><?php echo $letter2.$b; ?>" <?php echo $checked;?> onchange="changelink('<?php echo $pins; ?>','<?php echo $letter2.$b;?>')"><?php echo $letter2.$b; ?>
	<?php
		}}}
		}else {
		$inputxml = simplexml_load_file('input.xml');
		$inputpin = $letter.$i;
		$inputup = $inputxml->$inputpin->up;
		$inputdown = $inputxml->$inputpin->down;
		?>
		<img style="float:left;width:50px;height:25px;clear:both;" src="images/0-1.png"></img><span style="float:left;">Up</span>
		<input  style="margin-left:32px;width:415px;float:left;" id="inputup<?php echo $letter.$i;?>" value="<?php echo $inputup; ?>" class="input"></input>
		<div class="action" style="margin-top:3px;margin-left:22px;width:40px;float:left;height:20px;padding:3px;float:right;" id="name" onclick="changeinput('<?php echo $letter.$i; ?>','up')">Save</div>
		<img style="float:left;width:50px;height:25px;clear:both;" src="images/1-0.png"></img><span style="float:left;">Down</span>
		<input style="margin-left:10px;width:415px;float:left;" id="inputdown<?php echo $letter.$i;?>" value="<?php echo $inputdown; ?>" class="input"></input>
		<div style="margin-top:3px;width:40px;float:left;height:20px;padding:3px;float:right;" class="action" id="name" onclick="changeinput('<?php echo $letter.$i; ?>','down')">Save</div>
		<?
		}
		?>
	</td>
</tr>
<?php }}
}else {
	echo "Erreur de fichier XML";
	}
?>

</table>
</div>
</body>
</html>
