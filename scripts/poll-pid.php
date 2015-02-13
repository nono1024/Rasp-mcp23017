<?
$silent = exec('ps aux | grep routine.php',$out);
foreach ($out as $pout) {
if (preg_match("#/var/www/routine.php#i", $pout)) {
$testpid = 1;
$arr = preg_split('/[\s]+/', $pout);
}
}
if ($testpid == 1){
echo 'new Array("'.$arr[1].'","'.$arr[2].'");';
}else {
echo 'new Array("NOK");';
}
?>