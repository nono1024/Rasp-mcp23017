<?
if($_GET['sonde'] != "" ){
$sonde = $_GET['sonde'];
}
	$path = "/sys/bus/w1/devices/".$sonde."/w1_slave";

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
if(empty($temperature)) {
        echo "Attention, champs vide !\n";
} else     {
        echo 'new Array("'.$temperature.'");';
}

?>