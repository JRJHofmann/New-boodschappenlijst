<?php

//index.php/.
$db = new Database();
$post = $db->query("select * from groceries")->fetch(PDO::ASSOC);
dd($post);

// associatief array/.
$boodschappen = [
    [  
        "naam" => "Brood",
        "aantal" => "1",
        "stuk_prijs" => "1.00"
    ],
    [    
        "naam" => "Broccolie",
        "aantal" => "2",
        "stuk_prijs" => "0.99"
    ],
    [   
        "naam" => "krentenbollen",
        "aantal" => "2",
        "stuk_prijs" => "1.20"
    ],
    [
        "naam" => "noten",
        "aantal" => "1",
        "stuk_prijs" => "2.99"
    ]
];

// database pt2.
class Database 
{
    private $conn;
    private function __construtor(){
        $config = include('config.php');

        $this->host = $config['host'];
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
    }

    public function connect(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host= $this->host;dbname= $this->dbname;user=$this->user");

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_Exception);
        } catch(PDOException $exception) {
            echo "connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
  
    public function query($query){
        try {
            $statement = $this->conn->prepare($query);
            $statement->execute();

            return $statement->fetchALL(PDO::FETCH_ASSOC);

        } catch(PDOException $exception){
            echo "Query error: " . $exception->getMessage();
            return false;
        }
    }
}


// create.php/controller 
if($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $number = isset($_POST['number']) ? intval($_POST['number']) : null;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : null;

    if(!empty($name) && $number > 0 && $price >= 0) {
        $sql = "INSERT INTO boodschappne.groceries(name, number, price) VALUES(:name, :number, :price)";
        try {
            $statement = $db->prepare($sql);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':number', $number);
            $statement->bindParam(':price', $price);
            $statement->execute();

            if($statement->execute()){

                header("Location: index.php");
                exit();

            } else {
                echo "er is een fout opgetreden bij het toevoegen van de boodschappen.";
            }
        } catch(PDOException $exception){
            
            echo "Query error: " . $exception->getMessage();
            return false;
        }
    } else {
        echo "ongeldige invoer. Zorg er voor dat alle velden correct zijn ingevuld.";
    }
} else {
    include 'views/create.view.php';
}

// create/controller pt2?
require "validator.php";
$validator = new Validator();

$config = require 'Config.php';
$db = new Database($config['database']);
$errors= [];


if($_SERVER['REQUEST_METHOD'] === "POST"){
    
    $name = $_POST['name'] ?? '';
    $number = $_POST['number'] ?? 1;
    $price = $_POST['price'] ?? 0.00;

    if(!$validator->validateString($name, 3, 255)){
        $error['name'] = "De naam moet tussen 3 en 255 tekens zijn.";
    }

    if(!$validator->validateInteger($number, 1)){
        $error['number'] = "het aantal moet minimaal 1 zijn";
    }

    if(!$validator->validateDecimal($price, 0.01)){
        $error['price'] = "de prijs moet minimaal 0.01 zijn.";
    }

    
    if(!empty($naam) && $number > 0 && $price >= 0){
        $query = ('INSERT INTO groceries(name, number, price) VALUES(:name, :number, :price)');
        try {
            $statement = $db->prepare($query);
            $statement->bindParam('name', $name);
            $statement->bindParam('number', $number);
            $statement->bindParam('price', $price);
            
            if($statement->execute()){
                header("Location: /");
                exit();

            } else {
                echo "Er is een fout opgetreden bij het toevoegen van de boodschappen.";
            }
        } catch (PDOException $e){
            echo "Databasefout: " . $e->getMessage();
        }
    } else {
        echo "ongeldige invoer. zorg ervoor dat alle velden correct zijn ingevuld.";
    }
}  else {
    include "views/create.view.php";
}

// create if()
$db->query("INSERT INTO groceries(name, number, price)VALUES(:name, :number, :price)", [
    'name' => $_POST['name'],
    'number' => $_POST['number'],
    'price' => $_POST['price']

]);

//validator 
class Validator {

    public function validateString($value, $min = 1, $max = INF){
        if (!is_string($value)){
            return false;
        }
        $lenght = strlen($value);
        return $lenght >=$min && $lenght <= $max;
    }

    public function validateInteger($value, $min){
        if(!filter_var($value, FILTER_VALIDATE_INT)){
            return false;
        }
        return $value >= $min;
    }
    
    public function validateDecimal($value, $min, $max){
        if(!filter_var($value, FILTER_VALIDATE_FLOAT)){
            return false;
        }
        return $value >= $min && $value <= $max;
    }
}

// create.view
?>
<label for="name">Naam (Product):</label>
            <input type="text" id="name" name="name" required>
            <br><br>

            <label for="number">Aantal:</label>
            <input type="number" id="number" name="number" min = "1"required>
            <br><br>

            <label for="stukprijs">prijs:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
            <br><br>

            <button type="submit" value="Toevoegen">Toevoegen</button>
</label>

<?php

// create.php werkened code
$config= require 'Config.php';
$db = new Database($config['database']);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $db->query('INSERT INTO groceries(name,number,price) VALUES(:name, :number, :price)',[
        'name' => $_POST['name'],
        'number' => $_POST['number'],
        'price' => $_POST['price']
    ]);


    $errors =[];
    $validator = new Validator();

    if(!Validator::validateString($_POST['name'], 3 , 255)){
        $errors['name'] = "naam moet minimaal  tussen 3 en 255 characters hebben.";
    }

    if(!Validator::validateInteger($_POST['number'], 1 , 100)){
        $errors['number'] = "het aantal moet minimaal 1 zijn";
    }

    if(!Validator::validateDecimal($_POST['price'], 0.01, 1000)){
        $errors['price'] = "de prijs moet minimaal 0.01 zijn.";
    }

    if(empty($errors)){
    $db->query('INSERT INTO groceries(name,number,price) VALUES(:name, :number, :price)',[
        'name' => $_POST['name'],
        'number' => $_POST['number'],
        'price' => $_POST['price']
    ]);
    }

    if(!empty($naam) && $number > 3 && $price >= 00.1){ 
        $statement = $db->prepare($query);
        $statement->bindParam('name', $name);
        $statement->bindParam('number', $number);
        $statement->bindParam('price', $price);
    }

}
require "views/create.view.php";
