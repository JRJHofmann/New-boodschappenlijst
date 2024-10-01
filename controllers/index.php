<?php
$config= require 'Config.php';
$db = new Database($config['database']);
$query = 'SELECT * FROM groceries';
$statemant = $db->query($query);
$boodschappen = [];


while($row = $statemant->fetch(PDO::FETCH_ASSOC)){
    $boodschappen[]= $row;
}



$totaal_prijs = array_reduce($boodschappen, function($carry, $item){
    return $carry + ($item['number'] * $item['price']);
},0 );


include 'views/index.view.php';
?>

