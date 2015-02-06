<?
// $argv[0] is '/var/www/scripts/input-launch.php'
$pin = $argv[1];
$state = $argv[2];
$typepin = $argv[3];

	if ($typepin == 'entree'){
		
	}elseif ($typepin != 'entree') {
		$url = "http://192.168.0.210/global.php?action=cs&pin=".$pin."&state=".$state;
		$response = file_get_contents($url);
		echo $response;
	}


?>