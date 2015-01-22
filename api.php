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
<link rel="stylesheet" href="css/style.css">
<body>
<?php
$page = 'Api';
include("menu.php" );
?>
<div style="clear:both;margin-left:3%">
<table class="tableaurelais">
<tr><th>Nom</th><th>Fonction</th><th>Uri</th><th>Variable</th><th>Exemple</th></tr>
<tr>
	<td style="min-width:120px;width:10%;text-align:left;">
		Init
	</td>
	<td style="min-width:350px;width:10%;font-size:10px;line-height:1.1;text-align:left;">
		Remet les Pins du MCP23017 conforme à ce qui est dans la sauvegarde "pin.xml".
		A utiliser lorsque le MCP23017 a été désalimenté et que les relais sont revenu à 0.
	</td>
	<td style="min-width:300px;width:10%;text-align:left;">
		/global.php?action=init
	</td>	
	<td style="min-width:150px;width:10%;text-align:left;">
		Aucune
	</td>
	<td style="min-width:550px;width:12%;text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=init
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		Demo
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Permet de jouer un script. Juste pour montrer la rapidité d'execution du MCP.
		Le script est directement dans le fichier global.php à la fin.
	</td>
	<td style="text-align:left;">
		/global.php?action=demo
	</td>	
	<td style="text-align:left;">
		Aucune
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=demo
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		Clear
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Remet à zéro tous les relais.
	</td>
	<td style="text-align:left;">
		/global.php?action=clear
	</td>	
	<td style="text-align:left;">
		Aucune
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=clear
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		ClearA
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Remet à zéro tous les relais de la Bank A
	</td>
	<td style="text-align:left;">
		/global.php?action=clearA
	</td>	
	<td style="text-align:left;">
		Aucune
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=clearA
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		ClearB
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Remet à zéro tous les relais de la Bank B
	</td>
	<td style="text-align:left;">
		/global.php?action=clearB
	</td>	
	<td style="text-align:left;">
		Aucune
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=clearB
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		ChangeState
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Permet de faire changer l'état d'un PIN, en précisant ou non son état futur.
		Ce ChangeState prend en compte les Pin "Linkés" qui seront automatiquement modifié. 	
	</td>
	<td style="text-align:left;">
		/global.php?action=cs&pin=x[&state=y]
	</td>	
	<td style="text-align:left;">
		<u>pin:</u> A0-A7 B0-B7<br>
		<u>state:</u> 0 ou 1
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=cs&pin=A1&state=1
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		Fugitif
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Permet de faire changer l'état d'un PIN comme un bouton poussoir.
		Il est possible de préciser si on veux un ON ou OFF en fugitif.
		Le temps paramétré de base est de 1s. C'est à dire que le contact sera fermé ou ouvert pendant 1s.
		Il est également possible de préciser le temps de fermeture/ouverture.
	</td>
	<td style="text-align:left;">
		/global.php?action=fugitif&pin=x
	</td>	
	<td style="text-align:left;">
		<u>pin:</u> A0-A7 B0-B7<br>
		<u>state:</u> 0 ou 1<br>
		<u>time:</u> x secondes
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=fugitif&pin=A1&state=1&time=3
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		GetState
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Permet de récupérer l'état d'un PIN en interrogant le MCP.
		Ne se base pas sur le XML.
		Le résultat est en JSON de type :
		({"type":"A1","state":"0","error":""})
	</td>
	<td style="text-align:left;">
		/global.php?action=getstate&pin=x
	</td>	
	<td style="text-align:left;">
		<u>pin:</u> A0-A7 B0-B7<br>
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=getstate&pin=A1
	</td>	
</tr>

<tr>
	<td style="text-align:left;">
		GetSonde
	</td>
	<td style="font-size:10px;line-height:1.1;text-align:left;">
		Permet de récupérer la valeur d'une sonde en interrogant le bus 1-wire.
		Un nom ou un ID de sonde doit être précisé, pas les deux.
		Si un nom est précisé, il écrasera forcément l'id.
		Le nom peux comporter des espaces.
		Le résultat est en JSON de type :
		({"type":"28-00000477d605","state":"19.25","error":""})
	</td>
	<td style="text-align:left;">
		/global.php?action=getsonde&name=x
	</td>	
	<td style="text-align:left;">
		<u>name:</u>nom<br>
		<u>id:</u>28-xxxxxxxxx<br>
	</td>
	<td style="text-align:left;">
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=getsonde&name=Test sonde
		http://<?echo $_SERVER['SERVER_ADDR'];?>/global.php?action=getsonde&id=28-xxxxxxxxxxx
	</td>	
</tr>

</table>
</div>
</body>
</html>
