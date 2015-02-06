<?php
//charge le fichier XML
$dom = simplexml_load_file('pin.xml');
//Récupère le nombre de pin
$numpin = "NumberOfPin";
$numpin = $dom->$numpin;
	//Définis le que le mot clé LOW sera équivalent à 0 (utilisé pour mettre les GPIO à 0 ou 1)
	DEFINE('LOW',0);
	//Définis le que le mot clé HIGH sera équivalent à 1 (utilisé pour mettre les GPIO à 0 ou 1)
	DEFINE('HIGH',1);
	//Définis le que le mot clé OUTPUT sera équivalent à out (utilisé pour régler le mode des GPIO en sortie/entrée)
	DEFINE('OUTPUT','out');
	//Définis le que le mot clé INPUT sera équivalent à in (utilisé pour régler le mode des GPIO en sortie/entrée)
	DEFINE('INPUT','in');
	//Définis le nombre total de PIN utilisés
	DEFINE('numOfRegisterPins',$numpin);

//lit le status des pin pour récupérer la mémoire des états
	if ($dom) {	
	for($i = numOfRegisterPins; $i >=  0; $i--){
		$chaine = "pinA".$i;
		$GLOBALS['registerA'][$i] = $dom->pinstate->$chaine;
	}
	for($i = numOfRegisterPins; $i >=  0; $i--){
		$chaine = "pinB".$i;
		$GLOBALS['registerB'][$i] = $dom->pinstate->$chaine;
	}
	}else {
	echo "Erreur de fichier XML";
	}
$result['type'] = '';
$result['state'] = '';
$result['error'] = '';

switch($_GET['action']){

	//remet en état suivant le fichier xml la mémoire
	case 'init':
		//Relais bank A
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinA".$i;
			$GLOBALS['registerA'][$i] = $dom->pinstate->$chaine;
		}
		//Relais bank B
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinB".$i;
			$GLOBALS['registerB'][$i] = $dom->pinstate->$chaine;
		}
		//mets à jour les relais
		writeRegisters();
		//Ré-enregistre le xml
		$dom->asXML("pin.xml"); 
		//Retour Json
		$result['type'] = 'Init OK';
		$result['state'] = 1;
	break;
	
	case 'demo':
		//Relais bank A Mise à zéeo
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinA".$i;
			$dom->pinstate->$chaine = '0';
			$GLOBALS['registerA'][$i] = 0;
		}
		//Relais bank B Mise à zéro
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinB".$i;
			$dom->pinstate->$chaine = '0';
			$GLOBALS['registerB'][$i] = 0;
		}
		//mets à jour les relais
		writeRegisters();
		//Lance la démo
		demo();
		//Enregistre le xml
		$dom->asXML("pin.xml"); 
		//Retour JSON
		$result['type'] = 'Clear OK';
		$result['state'] = 1;
	break;
	
	//Remet à zéro tous les relais
	case 'clear':
		//Relais bank A Mise à zéro
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinA".$i;
			$dom->pinstate->$chaine = '0';
			$GLOBALS['registerA'][$i] = 0;
		}
		//Relais bank B Mise à zéro
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinB".$i;
			$dom->pinstate->$chaine = '0';
			$GLOBALS['registerB'][$i] = 0;
		}
		//mets à jour les relais
		writeRegisters();
		//Enregistre le xml
		$dom->asXML("pin.xml"); 
		//Retour JSON
		$result['type'] = 'Clear OK';
		$result['state'] = 1;
	break;
	
	//Remet à zéro les relais Ax
	case 'clearA':
		//Relais bank A Mise à zéro
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinA".$i;
			$dom->$pinstate->chaine = '0';
			$GLOBALS['registerA'][$i] = 0;
		}
		//mets à jour les relais
		writeRegisters('A');
		//Enregistre le xml
		$dom->asXML("pin.xml"); 
		$result['type'] = 'ClearA OK';
		$result['state'] = 1;
	break;
	
	//Remet à zéro les relais Bx
	case 'clearB':
		//Relais bank B Mise à zéro
		for($i = numOfRegisterPins; $i >=  0; $i--){
			$chaine = "pinB".$i;
			$dom->pinstate->$chaine = '0';
			$GLOBALS['registerB'][$i] = 0;
		}
		//mets à jour les relais
		writeRegisters('B');
		//Enregistre le xml
		$dom->asXML("pin.xml"); 
		//Retour JSON
		$result['type'] = 'ClearB OK';
		$result['state'] = 1;
	break;
	
	//Change d'état avec état forcé ou non.
	case 'cs':
		//Récupère la Bank relais concerné
		$base = $_GET['pin']{0};
		//Récupère tout lien avec un autre relais
		$chainelink = "link".$_GET['pin'];
		$link = $dom->$chainelink;
		$chainetype = "type".$_GET['pin'];
		$type = $dom->$chainetype;
		//Récupère l'état avant modif du pin
		$chaine = "pin".$_GET['pin'];

		//Si on a un état forcé, on le force
		if ($_GET['state'] == '1') {
		$status = 0;
		}elseif ($_GET['state'] == '0') {
		$status = 1;
		}

		//cas 'ON'
		if ($status == 0) {	
		//Si le relais est link à d'autre
		if ($link) {
		$result['link'] = "";
		//On détaille les link
		$piecelink = array_filter( explode(";", $link));
			//Pour chaque pin link
			foreach ($piecelink as $piece) {
			//on recupere son status
			$chainestatuslink = "pin".$piece;
			$statuslink = $dom->pinstate->$chainestatuslink;
			//Si il n'est pas allumé, on l'allume
				if ($statuslink == '0') {
				$GLOBALS['register'.$piece{0}][$piece{1}] = 1;
				$dom->pinstate->$chainestatuslink = 1;
				$result['link'] = $piece . "," . $result['link'];
				}			
			}		
		}
		//met à jour la variable Pin
		$GLOBALS['register'.$base][$_GET['pin']{1}] = 1;
		//envoi la modif des pins
		writeRegisters();
		//Save Xml
		$dom->pinstate->$chaine = 1;
		$dom->asXML("pin.xml");
		//Json result
		$result['type'] = 'ON' .$_GET['pin'] .  ' OK';
		$result['state'] = 1;
		
		//CAS OFF
		}elseif ($status == 1) {
		//met à jour la variable Pin
		$GLOBALS['register'.$_GET['pin']{0}][$_GET['pin']{1}] = 0;
		$dom->pinstate->$chaine = 0;
		if ($link) {
		$result['link'] = "";
		//On détaille les link
		$piecelink = array_filter( explode(";", $link));
			//Pour chaque pin link
			foreach ($piecelink as $piece) {
			$doornotlink = 0;
			//On regarde les linked
			$chainelinked = "linked".$piece;
			$linked = $dom->$chainelinked;
				//Si il y a des linked
				if ($linked) {
				//On les détaillent
				$piecelinked = array_filter( explode(";", $linked));
					//Pour chaque linked
					foreach ($piecelinked as $piece2) {
					if ($piece2 != $_GET['pin'] && $piece2) {
						//on regarde leur status
						$chainestatuslinked = "pin".$piece2;
						$statuslinked = $dom->pinstate->$chainestatuslinked;
							//Si un seul est allumé
							if ($statuslinked == '1') {
							//On met la variable à 1
							$doornotlink = 1;						
							}
					}
					}
				}
				//Si aucun linked du link est allumé
				if ($doornotlink == 0) {
				//on met à 0 le link
				$GLOBALS['register'.$piece{0}][$piece{1}] = 0;
				$chainestatuslink = "pin".$piece;
				$dom->pinstate->$chainestatuslink = 0;
				$result['link'] = $piece . "," . $result['link'];
				}
			}		
		}
		//envoi la modif des pins
		writeRegisters();
		//Save Xml
		$dom->asXML("pin.xml");
		
		//Json result
		$result['type'] = 'OFF' .$_GET['pin'] .  ' OK';
		$result['state'] = 1;
		}else {
		$result = 'ERROR IN PARSING XML';
		}
	break;
	
	case 'changetype':
		$chaine = "type".$_GET['pin'];
		$dom->$chaine = $_GET['type'];
		$dom->asXML("pin.xml");
		$result['type'] = 'type' .$_GET['pin'] .  ' set to '.$_GET['type'];
		$result['state'] = 1;
	break;
	
	case 'changelink':
		$chaine = "link".$_GET['pin'];
		$chaine2 = "link".$_GET['pin'];
		$chainelinked = "linked".$_GET['linked'];
		if ($_GET['operation'] == 'add'){
		$dom->$chaine = $dom->$chaine . $_GET['linked'] . ";";
		$dom->$chainelinked = $dom->$chainelinked . $_GET['pin'] . ";";
		$dom->asXML("pin.xml");
		$result['type'] = 'linkpin' .$_GET['pin'] .  ' added '.$_GET['linked'] . ' to ' . $dom->$chaine;
		$result['state'] = 1;
		}elseif ($_GET['operation'] == 'remove'){
		$pinlinked = $dom->$chaine;
		$piecelinked = explode(";", $pinlinked);
		$linkedcomplet = "";
			foreach($piecelinked as $piece) {
				if (($piece != $_GET['linked']) &&  $piece){
				$completlinked = $completlinked . $piece . ";";
				}
			}
		$dom->$chaine = $completlinked;
		
		$linkedpin = $dom->$chainelinked;
		$linkedpiece = explode(";", $linkedpin);
		$completlinked = "";
		foreach($linkedpiece as $piece2) {
				if (($piece2 != $_GET['pin']) &&  $piece2){
				$linkedcomplet = $linkedcomplet . $piece2 . ";";
				}
			}
		$dom->$chainelinked = $linkedcomplet;
		$dom->asXML("pin.xml");
		$result['type'] = 'link' .$_GET['pin'] .  ' removed '.$_GET['linked'] . ' from ' . $dom->$chaine2;
		$result['state'] = 1;
		}
	break;
	
	case 'changename':
		$chaine = "name".$_GET['pin'];
		$dom->$chaine = $_GET['name'];
		$dom->asXML("pin.xml");
		$result['type'] = 'name' .$_GET['pin'] .  ' set to '.$_GET['name'];
		$result['state'] = 1;
		break;
		
	case 'change':
		$type = $_GET['type'];
		$dom->$type = $_GET['val'];
		$dom->asXML("pin.xml");
		$result['type'] = 'type' .$_GET['type'] .  ' set to '.$_GET['val'];
		$result['state'] = 1;
		break;
		
	case 'getstate':
		if ($_GET['pin']{0} == 'A') { 
		$silent = exec('/usr/sbin/i2cget -y 1 0x20 0x12');
		}else if ($_GET['pin']{0} == 'B') {
		$silent = exec('/usr/sbin/i2cget -y 1 0x20 0x13');
		}else {
		$result['error'] = "Unknown Pin";
		break;
		}
		if ($_GET['pin']{1} > '7'){
		$result['error'] = "Unknown Pin";
		}else if ($_GET['pin']{2}) {
		$result['error'] = "Unknown Pin";
		}else {
		$h = substr($silent, -2);
		$decimal = hexdec($h);
		$bin = sprintf( "%08d",decbin($decimal));
		$bin = str_replace("0", "x", $bin);
        $bin = str_replace("1", "0", $bin);
        $bin = str_replace("x", "1", $bin);
		$result['type'] = $_GET['pin']{0}.$_GET['pin']{1};
		$result['state'] = $bin{(7-$_GET['pin']{1})};
		}
		break;
	
	case 'getsonde':
		if ($_GET['name']) {
		$_GET['name'] = str_replace("%20"," ",$_GET['name']);
		$xml = simplexml_load_file('conf.xml');
			foreach ($xml->sonde as $xmlsonde){
				if ($xmlsonde->name == $_GET['name']) {
				$_GET['id'] = $xmlsonde->serial;
				$a = "found";
				}
			}
			if ($a != "found"){
				$_GET['id'] = "";
				$result['type'] = $_GET['name'];
				$result['error'] = "nom introuvable";
				}
			
		}
		if ($_GET['id']) {
			chdir("/sys/bus/w1/devices/"); 
			exec('ls',$output);
			foreach ($output as $sonde) {
				if ($_GET['id'] == $sonde) {
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
							$result['error'] = "Pas de température";
							$result['type'] = $sonde;
					} else     {
							$result['type'] = $sonde;
							$result['state'] = $temperature;
					}
				}
			}
			if (!$result['state']) {
				$result['type'] = $_GET['id'];
				$result['error'] = "Sonde introuvable";
				}
		}
		break;
	
	case 'fugitif':
		$base = $_GET['pin']{0};
		$chaine = "pin".$_GET['pin'];
		$status = $dom->pinstate->$chaine;
		//Si on a un état forcé, on le force
		if ($_GET['state'] == '1') {
		$status = 0;
		}elseif ($_GET['state'] == '0') {
		$status = 1;
		}
		//Si on a un temps forcé, on le force
		if ($_GET['time']) {
		$time = $_GET['time'];
		}else {
		//Sinon ça sera 1s
		$time = 1;
		}
			if ($status == '0') {
			$GLOBALS['register'.$base][$_GET['pin']{1}] = 1;
			writeRegisters($base);
			sleep($time);
			$GLOBALS['register'.$base][$_GET['pin']{1}] = 0;
			writeRegisters($base);
			$result['type'] = 'FUGITIF ON OFF ' .$_GET['pin'] .  ' OK';
			$result['state'] = 1;
			}elseif ($status == '1') {
			$GLOBALS['register'.$base][$_GET['pin']{1}] = 0;
			writeRegisters($base);
			sleep($time);
			$GLOBALS['register'.$base][$_GET['pin']{1}] = 1;
			writeRegisters($base);
			$result['type'] = 'FUGITIF OFF ON ' .$_GET['pin'] .  ' OK';
			$result['state'] = 1;
			}else {
			$result = 'ERROR IN PARSING XML';
			}
	break;
	
	case 'savesonde':
		$xml = simplexml_load_file('conf.xml');
		$sonde = $xml->addChild('sonde');
		$name = $sonde->addChild('name', $_GET['name']);
		$name = $sonde->addChild('serial', $_GET['serial']);
		$name = $sonde->addChild('familyid', $_GET['familyid']);
		$xml->asXML("conf.xml");
	break;
		
	case 'savesondename':
		$xml = simplexml_load_file('conf.xml');
		foreach ($xml->sonde as $xmlsonde){
		if ($xmlsonde->serial == $_GET['serial']) {
		$xmlsonde->name = $_GET['name'];
		}
		}
		$xml->asXML("conf.xml");
	break;
	
	case 'changeinput':
		$xml = simplexml_load_file('input.xml');
		$xml->$_GET['pin']->$_GET['type'] = $_GET['url'];
		$xml->asXML("input.xml");
	break;
	
	case 'deletesonde':
		$xml = new SimpleXMLElement('conf.xml', NULL, TRUE);
		foreach($xml->sonde as $xmlsonde)
		{
			if($xmlsonde->serial == $_GET['serial']) {
				$docm=dom_import_simplexml($xmlsonde);
				$docm->parentNode->removeChild($docm);
				$result['type'] = 'DELETING SONDE'. $xmlsonde->serial .'OK';
			}else {
			$result['type'] = 'ID not found';
			}
		}
		$xml->asXml("conf.xml");
	break;
	
	default:
		$result = 'Aucune action definie';
	break;
	}
echo '('.json_encode($result).')';
 
function writeRegisters($base){
command("/usr/sbin/i2cset -y 1 0x20 0x00 0x00");
command("/usr/sbin/i2cset -y 1 0x20 0x01 0x00");

	if ($base == 'A'){
		$val ="";
			for($i = 0 ; $i <=  7; $i++){
			$mask = bindec('1');
			$pininverse = $GLOBALS['registerA'][$i] ^ $mask;
			$val = $pininverse . $val;
			}
		$hexA = dechex(bindec($val));
		command("/usr/sbin/i2cset -y 1 0x20 0x14 0x".$hexA);
	}elseif ($base == 'B'){
		$val ="";
			for($i = 0 ; $i <=  7; $i++){
			$mask = bindec('1');
			$pininverse = $GLOBALS['registerB'][$i] ^ $mask;
			$val = $pininverse . $val;
			}
		$hexB = dechex(bindec($val));
		command("/usr/sbin/i2cset -y 1 0x20 0x15 0x".$hexB);
	}else {
		$val ="";
			for($i = 0 ; $i <=  7; $i++){
			$mask = bindec('1');
			$pininverse = $GLOBALS['registerA'][$i] ^ $mask;
			$val = $pininverse . $val;
			}
		$hexA = dechex(bindec($val));
		command("/usr/sbin/i2cset -y 1 0x20 0x14 0x".$hexA);
		$val ="";
			for($i = 0 ; $i <=  7; $i++){
			$mask = bindec('1');
			$pininverse = $GLOBALS['registerB'][$i] ^ $mask;
			$val = $pininverse . $val;
			}
		$hexB = dechex(bindec($val));
		command("/usr/sbin/i2cset -y 1 0x20 0x15 0x".$hexB);
	}

}

//Fonction de base pour définir le mode d'un pin GPIO (entree/sortie) sur le rapsberry PI
function pinMode($pin, $mode){
	command('/usr/local/bin/gpio mode '.$pin.' '.$mode);
}

//Fonction de base pour ouvrir/fermer un pin GPIO sur le rapsberry PI
function digitalWrite($pin, $state){
	command('/usr/local/bin/gpio write '.$pin.' '.$state);
}

function command($command){
	system($command);
}

function demo(){
	command("/usr/sbin/i2cset -y 1 0x20 0x00 0x00");
	command("/usr/sbin/i2cset -y 1 0x20 0x01 0x00");

	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xFF");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xEE");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xBB");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0x88");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0x00");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0x88");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xBB");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xEE");
	command("/usr/sbin/i2cset -y 1 0x20 0x15 0xFF");
}
?>