<?
$xml = simplexml_load_file('../xml-weather.xml');

if ($xml) {
$date= "Date";
$date= $xml->$date;

$time= "Time";
$time= $xml->$time;

$tempint = $xml->Temperature->Indoor->Value;
$humint = $xml->Humidity->Indoor->Value;

$tempout = $xml->Temperature->Outdoor->Value;
$humout = $xml->Humidity->Outdoor->Value;

$ressentie = $xml->Windchill->Value;
$rosee = $xml->Dewpoint->Value;

$rain_h = $xml->Rain->OneHour->Value;
$rain_d = $xml->Rain->TwentyFourHour->Value;

$wind_v = $xml->Wind->Value;
$wind_d = $xml->Wind->Direction->Text;
$wind_d2 = $xml->Wind->Direction->Dir0;

$pression = $xml->Pressure->Value;
$tendance = $xml->Pressure->Tendency;
$prevision = $xml->Forecast;
$prevision = strtolower($prevision);

echo 'new Array("'.$tempint.'", "'.$humint.'", "'.$tempout.'", "'.$humout.'", "'.$date.'", "'.$time.'", "'.$ressentie.'", "'.$rosee.'", "'.$rain_h.'", "'.$rain_d.'", "'.$wind_v.'", "'.$wind_d.'", "'.$wind_d2.'", "'.$pression.'", "'.$tendance.'", "'.$prevision.'");';
}
?>