<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<form action="" method="POST">
    <div>
        <label for="msrp">MSRP:</label>
        <input required type="number" id="msrp" name="msrp" min="0">
      </div>
      <div>
        <label for="vehicle_year">Vehicle Year (Manufactured):</label>
        <input required type="number" id="vehicle_year" name="vehicle_year" min="0" max="2021">
        <!-- change to dynamic year  -->
      </div>
      <div>
        <label for="vehicle_month">Vehicle Month (Manufactured):</label>
        <input required type="number" id="vehicle_month" name="vehicle_month" min="1" max="12">
      </div>
      <div>
        <label for="freight">Freight Cost:</label>
        <input required type="number" id="freight" name="freight" min="0">
      </div>
      <div>
        <label for="insurance">Insurance Cost:</label>
        <input required type="number" id="insurance" name="insurance" min="0">
      </div>
      <div>
        <label for="ambulance">Ambulance:</label>
        <input type="checkbox" id="ambulance" name="ambulance">
      </div>
      <div>
        <label for="hearse">Hearse:</label>
        <input type="checkbox" id="hearse" name="hearse">
      </div>
      <div>
        <label for="diesel">Diesel Passenger Vehicle:</label>
        <input type="checkbox" id="diesel" name="diesel">
      </div>
      <div>
        <label for="petrol">Petrol Passenger Vehicle:</label>
        <input type="checkbox" id="petrol" name="petrol">
      </div>
      <div>
        <label for="motorcycle">Motorcycle:</label>
        <input type="checkbox" id="motorcycle" name="motorcycle">
      </div>
      <div>
        <label for="tenplus">Seats 10+ Passengers:</label>
        <input type="checkbox" id="tenplus" name="tenplus">
      </div>
      <div>
        <label for="thirtyplus">Seats 30+ Passengers:</label>
        <input type="checkbox" id="thirtyplus" name="thirtyplus">
      </div>
      <div>
        <label for="displacement">Displacement:</label>
        <input type="number" id="displacement" name="displacement" min="1">
      </div>
      <div>
        <input type="submit" name="submit" value="Submit">
      </div>
</form>

<?php
// Github: https://github.com/mehadh


if (isset($_POST['submit'])){ // to avoid premature calculation

// We need to calculate the Home Delivery Price (HDP), so we'll use the First Purchase Price (FPP) for that.
$msrp = $_POST['msrp'];
$vehicle_year = $_POST['vehicle_year'];
$vehicle_month = $_POST['vehicle_month'];

// Calculate rate of depreciation
$year = date("Y");
$month = date('m');
$depreciation_year = $year-$vehicle_year;
//$depreciation_month = ($month-$vehicle_month)/2;
//$depreciation_age = $depreciation_year+$depreciation_month;
$depreciation_age = $depreciation_year;

if ($depreciation_age < 0.5) {
    $depreciation_duty = 1;
}
elseif ($depreciation_age >= 0.5 && $depreciation_age < 1.5){
    $depreciation_duty = 0.85;
}
elseif ($depreciation_age >= 1.5 && $depreciation_age < 2.5){
    $depreciation_duty = 0.70;
}
elseif ($depreciation_age >= 2.5 && $depreciation_age < 5){
    $depreciation_duty = 0.60;
}
elseif ($depreciation_age >= 5){
    $depreciation_duty = 0.50;
}

$hdp = $msrp*$depreciation_duty;

// Vehicle year is also used to determine if there is an overage penalty.
if ($depreciation_age <= 10){
    $penalty_duty = 0;
}
elseif ($depreciation_age > 10 && $depreciation_age <= 12){
    $penalty_duty = 0.05;
}
elseif ($depreciation_age > 12 && $depreciation_age <= 15){
    $penalty_duty = 0.20;
}
elseif ($depreciation_age > 15 && $depreciation_age <= 25){
    $penalty_duty = 0.50;
}
elseif ($depreciation_age > 25 && $depreciation_age <= 35){
    $penalty_duty = 0.70;
}
elseif ($depreciation_age > 35){
    $penalty_duty = 1;
}


// Cost Insurance Freight value is next to be calcualted. This is the price used for duties.
$freight = $_POST['freight'];
$insurance = $_POST['insurance'];
// The cost part of the duty is the HDP.
$cif = $hdp+$freight+$insurance;


// These apply to every vehicle equally
$vat = 0.125; // Value Added Tax
$nhil = 0.025; // National Health Insurance Levy
$getfund = 0.025; // GETFUND Levy
$au = 0.02; // AU Levy
$ecowas = 0.005; // ECOWAS Levy
$exim = 0.0075; // Exim. Levy
$examination = 0.01; // Examination Fee
$special = 0.02; // Special Import Levy

//$duties = array($vat, $nhil, $getfund, $au, $ecowas, $exim, $examination, $special, $penalty_duty);

// Finally, let's calculate the import duty itself.
//$displacement = $_POST['displacement'];

if(isset($_POST['ambulance'])){
    $ambulance = $_POST['ambulance'];
}
else {
    $ambulance = false;
}

if(isset($_POST['hearse'])){
    $hearse = $_POST['hearse'];
}
else {
    $hearse = false;
}

if(isset($_POST['diesel'])){
    $diesel = $_POST['diesel'];
}
else {
    $diesel = false;
}

if(isset($_POST['petrol'])){
    $petrol = $_POST['petrol'];
}
else {
    $petrol = false;
}

if(isset($_POST['snowgolf'])){
    $snowgolf = $_POST['snowgolf'];
}
else {
    $snowgolf = false;
}

if(isset($_POST['tenplus'])){
    $tenplus = $_POST['tenplus'];
}
else {
    $tenplus = false;
}

if(isset($_POST['thirtyplus'])){
    $thirtyplus = $_POST['thirtyplus'];
}
else {
    $thirtyplus = false;
}

if(isset($_POST['motorcycle'])){
    $motorcycle = $_POST['motorcycle'];
}
else {
    $motorcycle = false;
}

// $ambulance = $_POST['ambulance'];
// $hearse = $_POST['hearse'];
// $diesel = $_POST['diesel'];

// $petrol = $_POST['petrol'];
// $snowgolf = $_POST['snowgolf'];
// $tenplus = $_POST['tenplus'];
// $thirtyplus = $_POST['thirtyplus'];

// $motorcycle = $_POST['motorcycle'];

// Missing from this section is bicycles, transport of goods vehicles

if ($ambulance == true || $hearse == true){
    $import_duty = $cif*0.2;
}
elseif ($diesel == true){
    $displacement = $_POST['displacement'];
    if ($displacement <= 1500){
        $import_duty = 0.05;
    }
    elseif ($displacement > 1500 && $displacement < 2500){
        $import_duty = 0.10;
    }
    elseif ($displacement > 2500){
        $import_duty = 0.20;
    }
}
elseif ($petrol == true){
    if ($snowgolf == true){
        $import_duty = 0.20;
    }
    elseif ($tenplus == true){
        $import_duty = 0.05;
    }
    elseif ($thirtyplus == true){ // fix this and two above
        $import_duty = 0.05;
    }
    else{
        $displacement = $_POST['displacement'];
        if ($displacement <= 1000){
            $import_duty = 0.05;
        }
        elseif ($displacement > 1000 && $displacement <= 3000){
            $import_duty = 0.10;
        }
        elseif ($displacement > 3000){
            $import_duty = 0.20;
        }
    }
}
elseif ($motorcycle == true){
    $import_duty = 0.20;
}
else{
	die("Your duties could not be calculated because you did not tick a single checkbox! Please try again.");
}

// And now let's bring it all together!

$duties = array($vat, $nhil, $getfund, $au, $ecowas, $exim, $examination, $special);
$currentduty = 0;
foreach ($duties as &$duty){
    $currentduty = $currentduty+($cif*$duty);
}

$penalty = $cif*$penalty_duty;
$import = $cif*$import_duty;

$total = $penalty+$import+$currentduty;
echo "Your duties are $" . $total . ", including $" . $import . " in import duties, and $" . $penalty . " in penalties.";
}
?>