<?php 
//This prevents what happens in part .3
declare(strict_types=1);

//Link db connection file
require 'connect.php';

//.1 Code commenting
//inline
/*
block comment
*/
#shell style comment

//.2 Variables, Data Types, Concatenation, and Conditions

$firstName = "John";
$lastName = "Doe";
$age = 30;
$isEmployed = true;

echo "<p>Name: " . $firstName . " " . $lastName . "</p>";

if ($isEmployed) {
    echo "<p>Status: Employed</p>";
} else {
    echo "<p>Status: Unemployed</p>";
}

//.3 PHP is loosely typed
//Create two variables, one with a string and one with an integer
$numberString = "100";
$numberInt = 50;

function addValues($a, $b) {
    return $a + $b;
}
$result = addValues($numberString, $numberInt);
echo "<p>Result of adding string and integer: " . $result . "</p>";
//Without strict types, PHP converts the string to an integer automatically
// Result will be 150 with loose typing

//Lets try adding the delcare(strict_types=1) and adding tyoe hints
// $numberString = "100";
// $numberInt = 50;

// function addValues(int $a, int $b) : int{
//     return $a + $b;
// }
// $result = addValues($numberString, $numberInt);
// echo "<p>Result of adding string and integer: " . $result . "</p>";

//.4 OOP Basics
class Person {
    public string $name;
    public int $age;
    public bool $isEmployed;

    public function __construct(string $name, int $age, bool $isEmployed) {
        $this->name = $name;
        $this->age = $age;
        $this->isEmployed = $isEmployed;
    }
    public function getBadge(): String{
        $role = $this->isEmployed ? "Employee" : "Guest";
        return "Name: {$this->name}, Age: {$this->age}, Role: {$role}";
    }
}

//Create instance of the class
$person1 = new Person("Alice", 28, true);

echo        $person1->getBadge();
?>