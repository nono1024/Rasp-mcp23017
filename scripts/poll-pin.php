<?
$xml = simplexml_load_file('../pin.xml');
if ($xml) {
foreach ($xml->pinstate as $xmlsonde){
echo json_encode($xmlsonde);
}
}
?>