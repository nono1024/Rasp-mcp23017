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

<?
$dom = simplexml_load_file('pin.xml');
if ($dom) {
$refreshpin = "refreshpin";
$refreshpin = $dom->$refreshpin;
$refreshpin = $refreshpin . "000";
}
?>
<script type="text/javascript">

function pollpin() {

var xhr1 = getXMLHttpRequest();

xhr1.onreadystatechange = function() {
        if (xhr1.readyState == 4 && (xhr1.status == 200 || xhr1.status == 0)) {
        JSON.parse(xhr1.responseText, function (k, v) {
		if (k != ""){
		document.getElementById(k).className = 'pinState ' + (v=='1'?'on':'off');
		}});
}};

xhr1.open("GET", "scripts/poll-pin.php", true);
xhr1.send(null);

setTimeout(function(){pollpin()},<?echo $refreshpin;?>);
}

</script>

<body>
<?php
$page = 'Relais';
include("menu.php" );
?>
<div style="clear:both;margin-left:3%">
<table class="tableaurelais">
<tr><th>Nom</th><th>Pin</th><th>Etat</th><th>Actions</th><th>Type</th><th>Link</th></tr>
<?php 

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
		$pinstatus[$i] = $dom->pinstate->$chaine;
		$chaine3 = "type".$letter.$i;
		$pintrim[$i] = (trim($pinstatus[$i])=="1"?'on':'off');
		$pinname[$i] = $dom->$chaine2;
		$pintype[$i] = $dom->$chaine3;
		$chaine4 = "link".$letter.$i;
		$pinlinked = $dom->$chaine4;
		$piecelinked = explode(";", $pinlinked);
		if ($pintype[$i] == 'fugitif') {
		$pinother[$i] = 'onoff';
		}elseif ($pintype[$i] == 'onoff') {
		$pinother[$i] = 'fugitif';
		}
		//echo "<td>TRIM: " . $pintrim[$i] . "    Status: " . $pinstatus[$i] . "</td>";
?>
<tr>
	<td style="min-width:220px;width:10%;">
		<span id="name<?php echo $letter.$i; ?>" ></span><?php echo $pinname[$i];?>
		</div>
	</td>
	<td style="min-width:50px;width:10%;">
		<?php echo $letter.$i;?>
	</td>
	<td style="min-width:50px;width:10%;">
		<div id="pin<?php echo $letter.$i;?>" class="pinState <?php echo $pintrim[$i]; ?>">
		</div>
	</td>
	<td style="min-width:280px;width:10%;" >
		<div class="action" id="on" onclick="changestate('<?php echo $letter.$i; ?>',1)">
			<span>On</span>
		</div>
		<div class="action" id="off" onclick="changestate('<?php echo $letter.$i; ?>',0)">
			<span>Off</span>
		</div>
		<div class="action" id="fugitif" onclick="fugitif('<?php echo $letter.$i; ?>')">
			<span>Fugitif</span>
		</div>
	</td>
	<td style="min-width:100px;width:10%;">
	<span id="nametype<?php echo $letter.$i;?>"></span><?php echo $pintype[$i]; ?>
	</td>
	<td style="min-width:100px;width:10%;">
	<?php
		$z=0;
		for($a=0; $a<=1;$a++){
		$letter2='A';
		if($a==1){
		$letter2='B';
		}
		for($b = 0; $b <= $numpin; $b++){
		$pins = $letter.$i;
		$testlink = $letter2.$b;
		foreach ($piecelinked as $piece){
			if ($piece == $testlink) {
			if($z>=1){echo "-";}
		?>
		<span id="linked<?php echo $pins;?><?php echo $letter2.$b; ?>"></span><?php echo $letter2.$b;?>
		<?php
			$z++;
			}
		}
		}}
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
