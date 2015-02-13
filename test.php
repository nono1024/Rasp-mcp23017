<?

$silent = exec('ps aux | grep routine.php',$out);
foreach ($out as $pout) {
if (preg_match("#/var/www/routine.php#i", $pout)) {
$arr = preg_split('/[\s]+/', $pout);
echo 'OK Process en cours. PID:'.$arr[1].' Ressources Proc Utilisé:'.$arr[2].'%<br>';
print_r($arr);
}
}
?>