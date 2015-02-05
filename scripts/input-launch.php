<?
// $argv[0] is '/var/www/scripts/input-launch.php'
$pin = $argv[1];
$state = $argv[2];

$dom = simplexml_load_file('pin.xml');
if ($dom) {	
$chainetype = 'type' . $pin;
$typepin = $dom->$chainetype;

	if ($typepin == 'entree'){
		
	}elseif ($typepin != 'entree') {
		
	}

}
?>