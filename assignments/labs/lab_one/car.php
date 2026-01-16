<?php

//Car class
class car {
    //Properties
    public string $make;
    public string $model;
    public int $year;

    //Constructor
    public function __construct(string $make, string $model, int $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }
    //Method to display car info
    public function showInfo(): String{
        return "Make: {$this->make}, Model: {$this->model}, Year: {$this->year}";
    }
}
//Create an instance of the car class
$car1 = new car("Ford", "F150", 1995);
//Display car info
echo $car1->showInfo();

