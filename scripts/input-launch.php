<?
// $argv[0] is '/var/www/scripts/input-launch.php'
$pin = $argv[1];
$state = $argv[2];
$typepin = $argv[3];

	if ($typepin == 'entree'){
		$dom = simplexml_load_file('/var/www/input.xml');
		if ($state == '0') {
		$url2 = "http://192.168.0.210/global.php?action=input&pin=".$pin."&state=".$state;
		$response = file_get_contents($url2);
		echo $response;
		
		$url = $dom->$pin->down;
		$url = htmlspecialchars_decode($url);
		$response = file_get_contents($url);
		echo $response;
		
		}else if ($state == '1') {
		$url2 = "http://192.168.0.210/global.php?action=input&pin=".$pin."&state=".$state;
		$response = file_get_contents($url2);
		echo $response;
		
		$url = $dom->$pin->up;
		$url = htmlspecialchars_decode($url);
		$response = file_get_contents($url);
		echo $response;
		}
	}elseif ($typepin == 'onoff') {
		$url = "http://192.168.0.210/global.php?action=cs&pin=".$pin."&state=".$state;
		$response = file_get_contents($url);
		echo $response;
	}
?>