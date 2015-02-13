<?php
//$timestart=microtime(true);
//charge le fichier XML
while (true) {
$dom = simplexml_load_file('/var/www/pin.xml');
if ($dom) {	
$silent = exec('/usr/sbin/i2cget -y 1 0x20 0x12');
$h = substr($silent, -2);
$pinA = base_convert($h, 16, 2);
$pinA = sprintf( "%08d",$pinA);
//echo "<br>hard : ";

$silent = exec('/usr/sbin/i2cget -y 1 0x20 0x13');
$h = substr($silent, -2);
$pinB = base_convert($h, 16, 2);
$pinB = sprintf( "%08d",$pinB);
//$pinA = $pinA.$pinB;
//echo $pinA;
//echo '<br>';
//echo $pinB;
//echo "xml : ";
for($i = 7; $i >=  0; $i--){
			$chaine = "pinA".$i;
			$invertchaine = 'invertA'.$i;
			$xmlpinA[$i] = $dom->pinstate->$chaine;
			$invertpin = $dom->$invertchaine;
			$pinA{(7-$i)} = $pinA{(7-$i)} ^ $invertpin;
			//echo $dom->pinstate->$chaine;
			if ($pinA{(7-$i)} != $xmlpinA[$i]) {
			$chainetype = 'typeA' . $i;
			$typepin = $dom->$chainetype;
			$silent = exec('/usr/bin/php /var/www/scripts/input-launch.php A'.$i.' '.$pinA{(7-$i)}.' '.$typepin);
			//echo $silent;
			}
		}

for($i = 7; $i >=  0; $i--){
			$chaine = "pinB".$i;
			$invertchaine = 'invertB'.$i;
			$xmlpinB[$i] = $dom->pinstate->$chaine;
			$invertpin = $dom->$invertchaine;
			$pinB{(7-$i)} = $pinB{(7-$i)} ^ $invertpin;
			if ($pinB{(7-$i)} != $xmlpinB[$i]) {
			//echo $pinB{(7-$i)};
			$chainetype = 'typeB' . $i;
			$typepin = $dom->$chainetype;
			$silent = exec('/usr/bin/php /var/www/scripts/input-launch.php B'.$i.' '.$pinB{(7-$i)}.' '.$typepin);
			echo $silent;
			}
		}
//echo '<br>';



}
/*$timeend=microtime(true);
$time=$timeend-$timestart;
$page_load_time = number_format($time, 3);
echo "Debut du script: ".date("H:i:s", $timestart);
echo "<br>Fin du script: ".date("H:i:s", $timeend);
echo "<br>Script execute en " . $page_load_time . " sec";
*/
$dom = "";
usleep(300000);
}
?>