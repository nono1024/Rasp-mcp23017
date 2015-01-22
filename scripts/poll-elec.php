<?
$recup = file_get_contents("http://192.168.0.211/elec.php");

$explode = explode("\n",$recup); 
//print_r($explode);    

foreach ($explode as $explode=>$valeurs) {
	$valeur =  explode(" ",$valeurs); 
	switch($valeur[0])
	{
	case 'HCHC':
		$HCHC = strip_tags($valeur[1]);
		//echo 'HCHC ' . $HCHC;
		break;
	case 'HCHP':
		$HCHP = strip_tags($valeur[1]);
		//echo 'HCHP ' . $HCHP;
		break;	
	case 'PTEC':
		$PTEC = strip_tags($valeur[1]);
		//echo 'PTEC ' . $PTEC;
		break;
	case 'IINST':
		$IINST = strip_tags($valeur[1]);
		//echo 'IINST ' . $IINST;
		break;
	}

}

echo 'new Array("'.$HCHC.'", "'.$HCHP.'", "'.$PTEC.'", "'.$IINST.'");';

?>