<P style="text-align:center"><img src="images/Pi.png" style="width:150px;height:133px;"></P>
<div id="navcontainer">
<ul style="min-width:400px;" id="navlist">
<li ><a <?php if($page == 'Accueil'){echo 'id="active"';}else{echo '';};?> href="index.php">Accueil</a></li>
<li ><a <?php if($page == 'Relais'){echo 'id="active"';}else{echo '';};?> href="relay.php">Relais</a></li>
<li ><a <?php if($page == 'Conf Relais'){echo 'id="active"';}else{echo '';};?> href="confrelais.php">Conf Relais</a></li>
<li ><a <?php if($page == 'Sonde'){echo 'id="active"';}else{echo '';};?> href="sonde.php">Sonde</a></li>
<li ><a <?php if($page == 'Api'){echo 'id="active"';}else{echo '';};?> href="api.php">Api</a></li>
</ul>
</div>