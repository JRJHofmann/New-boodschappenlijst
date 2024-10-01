<?php 
require 'Validator.php';

$config= require 'Config.php';
$db = new Database($config['database']);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $errors = [];
    $validator = new Validator();

    $name = $_POST['name'];
    $number = $_POST['number'];
    $price = $_POST['price'];

    if(!Validator::validateString($_POST['name'], 3 , 255)){
        $errors['name'] = "naam moet minimaal  tussen 3 en 255 characters hebben.";
    }

    if(!Validator::validateInteger($_POST['number'], 1 , 100)){
        $errors['number'] = "het aantal moet minimaal 1 zijn";
    }

    if(!Validator::validateDecimal($_POST['price'], 0.01, 1000)){
        $errors['price'] = "de prijs moet minimaal 0.01 zijn.";
    }

    if(empty($errors)) {
        $name = htmlspecialchars($name, ENT_QUOTES,'UTF_8');
        $number = (int)$number;
        $price = (float)$price;

        $query = 'INSERT INTO groceries(name,number,price) VALUES(?, ?, ?)';
        $param = [$name, $number, $price];

        $statemant = $db->query($query, $param);

        if($statemant){
            header("Location: / ");
            exit();
        } else {
            echo "er is iets fout gegaan bij het toevoegen van u boodschap";
        }
        $statemant->close();
    }

} 
    include "views/create.view.php";



