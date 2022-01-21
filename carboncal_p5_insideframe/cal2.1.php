<?php
    session_start();
    // echo "no cal";
    // echo $_SESSION['condition'] ;
    // echo '<pre>'; print_r(  $_SESSION["co2DataArray"]); echo '</pre>';


    // [StateFull] => British Columbia
    // [State] => BC
    // [Country] => Canada
    // [Gasoline] => 1.244833333
    // [Diesel] => 1.125375
    // [CarbonIntensity] => 12.9
    // [SingleDetached_sqft] => 0.020903221
    // [SingleAttached_sqft] => 0.01677419
    // [SmallApartmentBuilding_sqft] => 0.015483867
    // [LargeApartmentBuilding_sqft] => 0.015483867
    // [MobileHome_sqft] => 0.029935477
    // [SingleDetached_household] => 37.9722526
    // [SingleAttached_household] => 26.6389102
    // [SmallApartmentBuilding_household] => 17.8889032
    // [LargeApartmentBuilding_household] => 17.8889032
    // [MobileHome_household] => 37.0555852

    // check whehter the form value was saved. if empty, assign 0.
    function checkPostValueSet($postValue){
        if (!empty($postValue)) {
            $savedValue = $postValue;
        } else {  
            $savedValue= 0;
        }

        return $savedValue;
    }

    #driving
    $_SESSION["gas"] = checkPostValueSet($_POST["fieldgas"]);

    #input total amount/priceperL*co2perL*12months
    $numberofmonths=12;
    $gasco2perlitre=0.002347;
    $gasco2pergallon=0.002347*3.78541;
    if($_SESSION["co2DataArray"]["Country"]=="Canada"){
        $_SESSION["gasCO2"]=$_SESSION["gas"]/($_SESSION["co2DataArray"]["Gasoline"])*$gasco2perlitre*$numberofmonths;
    }else{
        $_SESSION["gasCO2"]=$_SESSION["gas"]/($_SESSION["co2DataArray"]["Gasoline"])*$gasco2pergallon*$numberofmonths;
    }
    // echo ( "gas"."<br>" );
    // echo ( $_SESSION["gasCO2"] ."<br>");

    $_SESSION["diesel"] = checkPostValueSet($_POST["fielddiesel"]);

    $dieselco2perliter=0.01018/3.78541;
    $dieselco2pergallon=0.010180; #3.78541 L = 1 gallon
    if($_SESSION["co2DataArray"]["Country"]=="Canada"){
        $_SESSION["dieselCO2"]=$_SESSION["diesel"]/($_SESSION["co2DataArray"]["Diesel"])*$dieselco2perliter*$numberofmonths;
    }else{
        $_SESSION["dieselCO2"]=$_SESSION["diesel"]/($_SESSION["co2DataArray"]["Diesel"])*$dieselco2pergallon*$numberofmonths;
    }
    // echo ( "diesel"."<br>" );
    // echo ( $_SESSION["dieselCO2"] ."<br>");
    

    #flights

    // economy flight
    $_SESSION["eshortflight"] = checkPostValueSet($_POST["eshortflight"]);
    $_SESSION["emediumflight"] = checkPostValueSet($_POST["emediumflight"]);
    $_SESSION["elongflight"] = checkPostValueSet($_POST["elongflight"]);
    $_SESSION["everylongflight"] = checkPostValueSet($_POST["everylongflight"]);
    // business flight
    $_SESSION["bshortflight"] = checkPostValueSet($_POST["bshortflight"]);
    $_SESSION["bmediumflight"] = checkPostValueSet($_POST["bmediumflight"]);
    $_SESSION["blongflight"] = checkPostValueSet($_POST["blongflight"]);
    $_SESSION["bverylongflight"] = checkPostValueSet($_POST["bverylongflight"]);
    
    #input hours * co2 emission per hour
    function calculateCO2Multiply($inputValue, $co2perUnit){
        $co2Calculated=$inputValue*$co2perUnit;
        return $co2Calculated;
    }

    //economy flights
    $_SESSION["eshortflightCO2"] = calculateCO2Multiply( $_SESSION["eshortflight"], 0.15); #under 3 hours, for example San Francisco to Seattle
    $_SESSION["emediumflightCO2"] = calculateCO2Multiply( $_SESSION["emediumflight"], 0.60); #3 to 6 hours, for example Las Vegas to New York City
    $_SESSION["elongflightCO2"] = calculateCO2Multiply( $_SESSION["elongflight"], 1.15); #6 to 10 hours, for example Orlando, Florida to London, England
    $_SESSION["everylongflightCO2"] = calculateCO2Multiply( $_SESSION["everylongflight"], 1.95); #over 10 hours, for example Los Angeles, California to Sydney, Australia

    //business flights
    $_SESSION["bshortflightCO2"] = calculateCO2Multiply( $_SESSION["bshortflight"], 0.70); #under 3 hours, for example San Francisco to Seattle
    $_SESSION["bmediumflightCO2"] = calculateCO2Multiply( $_SESSION["bmediumflight"], 2.35); #3 to 6 hours, for example Las Vegas to New York City
    $_SESSION["blongflightCO2"] = calculateCO2Multiply( $_SESSION["blongflight"], 3.3); #6 to 10 hours, for example Orlando, Florida to London, England
    $_SESSION["bverylongflightCO2"] = calculateCO2Multiply( $_SESSION["bverylongflight"], 5.7); #over 10 hours, for example Los Angeles, California to Sydney, Australia

    // echo ( "flight"."<br>" );
    // echo ( $_SESSION["everylongflight"]."<br>" );
    // echo ( $_SESSION["flightCO2"]."<br>"  ); 
    
    $_SESSION["travelCO2"] = $_SESSION["gasCO2"]+$_SESSION["dieselCO2"]+ 
                             $_SESSION["eshortflightCO2"] + $_SESSION["emediumflightCO2"] + $_SESSION["elongflightCO2"] + $_SESSION["everylongflightCO2"] +
                             $_SESSION["bshortflightCO2"] + $_SESSION["bmediumflightCO2"] + $_SESSION["blongflightCO2"] + $_SESSION["bverylongflightCO2"];
    // echo ( "travel"."<br>" );
    // echo ( $_SESSION["travelCO2"]."<br>" );

    // #clothing
    // Jackets
    $_SESSION["jackets"] = checkPostValueSet($_POST["jackets"]);

    $_SESSION["jacketsCO2"] = calculateCO2Multiply( $_SESSION["jackets"], 18); #18/1000 is the co2 emitted per jacket
    // echo ( "jackets"."<br>" );
    // echo ( $_SESSION["jackets"]."<br>" );
    // echo ( $_SESSION["jacketsCO2"]."<br>"  );

    // Jeans
    $_SESSION["jeans"] = checkPostValueSet($_POST["jeans"]);

    $_SESSION["jeansCO2"] = calculateCO2Multiply( $_SESSION["jeans"], 33);
    // echo ( "jeans"."<br>" );
    // echo ( $_SESSION["jeans"]."<br>" );
    // echo ( $_SESSION["jeansCO2"]."<br>"  );

    // Shoes
    $_SESSION["shoes"] = checkPostValueSet($_POST["shoes"]);

    $_SESSION["shoesCO2"] = calculateCO2Multiply( $_SESSION["shoes"], 14);
    // echo ( "shoes"."<br>" );
    // echo ( $_SESSION["shoes"]."<br>" );
    // echo ( $_SESSION["shoesCO2"]."<br>"  );

    // Shirt
    $_SESSION["shirt"] = checkPostValueSet($_POST["shirt"]);

    $_SESSION["shirtCO2"] = calculateCO2Multiply( $_SESSION["shirt"], 4);
    // echo ( "shirt"."<br>" );
    // echo ( $_SESSION["shirt"]."<br>" );
    // echo ( $_SESSION["shirtCO2"]."<br>"  );

    $_SESSION["clothesCO2"] = ($_SESSION["jacketsCO2"]+$_SESSION["jeansCO2"]+$_SESSION["shoesCO2"]+$_SESSION["shirtCO2"])/1000;
    // echo ( "clothes"."<br>" );
    // echo ( $_SESSION["clothesCO2"]."<br>" );

    // #housing
    $_SESSION["housing"] = checkPostValueSet($_POST["housing"]);
    $_SESSION["housesize"] = checkPostValueSet($_POST["housesize"]);
    $_SESSION["numberpeople"] = checkPostValueSet($_POST["numberpeople"]);

    // echo ( $_SESSION["housing"]."<br>" );
    // echo ( $_SESSION["housesize"]."<br>" );
    // echo ( $_SESSION["numberpeople"]."<br>" );

    if ($_SESSION["housesize"] =="NA"){
        if ($_SESSION["housing"] =="detached"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SingleDetached_household"];
        }elseif ($_SESSION["housing"] =="attached"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SingleAttached_household"];
        }elseif ($_SESSION["housing"] =="smallapartment"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SmallApartmentBuilding_household"];
        }elseif ($_SESSION["housing"] =="largeapartment"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["LargeApartmentBuilding_household"];
        }elseif ($_SESSION["housing"] =="mobile"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["MobileHome_household"];
        }
    }else{
        if ($_SESSION["housing"] =="detached"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SingleDetached_sqft"]*$_SESSION["housesize"];
        }elseif ($_SESSION["housing"] =="attached"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SingleAttached_sqft"]*$_SESSION["housesize"];
        }elseif ($_SESSION["housing"] =="smallapartment"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["SmallApartmentBuilding_sqft"]*$_SESSION["housesize"];
        }elseif ($_SESSION["housing"] =="largeapartment"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["LargeApartmentBuilding_sqft"]*$_SESSION["housesize"];
        }elseif ($_SESSION["housing"] =="mobile"){
            $_SESSION["housingCO2"] = $_SESSION["co2DataArray"]["CarbonIntensity"]*$_SESSION["co2DataArray"]["MobileHome_sqft"]*$_SESSION["housesize"];
        }
    }



    $_SESSION["housingCO2"]=$_SESSION["housingCO2"]/1000/$_SESSION["numberpeople"];
    // echo ( "housing"."<br>" );
    // echo ( $_SESSION["housingCO2"]."<br>" );


    // #food
    $weekPerYear =52;
    // redmeat
    $_SESSION["redmeat"] = checkPostValueSet($_POST["redmeat"]);
    $_SESSION["redmeatCO2"] = calculateCO2Multiply( $_SESSION["redmeat"], 4.56*$weekPerYear);
    // echo ( "redmeat"."<br>" );
    // echo ( $_SESSION["redmeat"]."<br>" );
    // echo ( $_SESSION["redmeatCO2"]."<br>"  );

    // othermeat
    $_SESSION["othermeat"] = checkPostValueSet($_POST["othermeat"]);
    $_SESSION["othermeatCO2"] = calculateCO2Multiply( $_SESSION["othermeat"], 0.7*$weekPerYear);
    // echo ( "othermeat"."<br>" );
    // echo ( $_SESSION["othermeat"]."<br>" );
    // echo ( $_SESSION["othermeatCO2"]."<br>"  );

    // cheese
    $_SESSION["cheese"] = checkPostValueSet($_POST["cheese"]);
    $_SESSION["cheeseCO2"] = calculateCO2Multiply( $_SESSION["cheese"], 0.27*$weekPerYear);
    // echo ( "cheese"."<br>" );
    // echo ( $_SESSION["cheese"]."<br>" );
    // echo ( $_SESSION["cheeseCO2"]."<br>"  );

    // milk
    $_SESSION["milk"] = checkPostValueSet($_POST["milk"]);
    $_SESSION["milkCO2"] = calculateCO2Multiply( $_SESSION["milk"], 0.55* $weekPerYear);
    // echo ( "milk"."<br>" );
    // echo ( $_SESSION["milk"]."<br>" );
    // echo ( $_SESSION["milkCO2"]."<br>"  );

    // egg
    $_SESSION["egg"] = checkPostValueSet($_POST["egg"]);
    $_SESSION["eggCO2"] = calculateCO2Multiply( $_SESSION["egg"], 0.18*$weekPerYear);
    // echo ( "egg"."<br>" );
    // echo ( $_SESSION["egg"]."<br>" );
    // echo ( $_SESSION["eggCO2"]."<br>"  );
    
    // fruit
    $_SESSION["fruit"] = checkPostValueSet($_POST["fruit"]);
    $_SESSION["fruitCO2"] = calculateCO2Multiply( $_SESSION["fruit"], 0.06*$weekPerYear);
    // echo ( "fruit"."<br>" );
    // echo ( $_SESSION["fruit"]."<br>" );
    // echo ( $_SESSION["fruitCO2"]."<br>"  );

    // legume
    $_SESSION["legume"] = checkPostValueSet($_POST["legume"]);
    $_SESSION["legumeCO2"] = calculateCO2Multiply( $_SESSION["legume"], 0.06*$weekPerYear);
    // echo ( "legume"."<br>" );
    // echo ( $_SESSION["legume"]."<br>" );
    // echo ( $_SESSION["legumeCO2"]."<br>"  );

     // vegetable
     $_SESSION["vegetable"] = checkPostValueSet($_POST["vegetable"]);
     $_SESSION["vegetableCO2"] = calculateCO2Multiply( $_SESSION["vegetable"], 0.05*$weekPerYear);
     // echo ( "vegetable"."<br>" );
     // echo ( $_SESSION["vegetable"]."<br>" );
     // echo ( $_SESSION["vegetableCO2"]."<br>"  );

    // grain
    $_SESSION["grain"] = checkPostValueSet($_POST["grain"]);
    $_SESSION["grainCO2"] = calculateCO2Multiply( $_SESSION["grain"], 0.07*$weekPerYear);
    // echo ( "grain"."<br>" );
    // echo ( $_SESSION["grain"]."<br>" );
    // echo ( $_SESSION["grainCO2"]."<br>"  );

    #sum of food
    $_SESSION["foodCO2"] = ($_SESSION["redmeatCO2"]+$_SESSION["othermeatCO2"]+$_SESSION["cheeseCO2"]+$_SESSION["milkCO2"]+
                            $_SESSION["eggCO2"]+$_SESSION["fruitCO2"]+$_SESSION["legumeCO2"]+$_SESSION["vegetableCO2"]
                            +$_SESSION["grainCO2"])/1000;
    // echo ( "foodCO2"."<br>" );
    // echo ( $_SESSION["foodCO2"]."<br>" );


    // #device
    // phone
    $_SESSION["phone"] = checkPostValueSet($_POST["phone"]);
    $_SESSION["phoneCO2"] = calculateCO2Multiply( $_SESSION["phone"], 70);
    // echo ( "phone"."<br>" );
    // echo ( $_SESSION["phone"]."<br>" );
    // echo ( $_SESSION["phoneCO2"]."<br>"  );
    // laptop
    $_SESSION["laptop"] = checkPostValueSet($_POST["laptop"]);
    $_SESSION["laptopCO2"] = calculateCO2Multiply( $_SESSION["laptop"], 185);
    // echo ( "laptop"."<br>" );
    // echo ( $_SESSION["laptop"]."<br>" );
    // echo ( $_SESSION["laptopCO2"]."<br>"  );
    // tv
    $_SESSION["tv"] = checkPostValueSet($_POST["tv"]);
    $_SESSION["tvCO2"] = calculateCO2Multiply( $_SESSION["tv"], 824);
    // echo ( "tv"."<br>" );
    // echo ( $_SESSION["tv"]."<br>" );
    // echo ( $_SESSION["tvCO2"]."<br>"  );

    #sum of technology
    $_SESSION["techCO2"] = ($_SESSION["phoneCO2"]+$_SESSION["laptopCO2"]+$_SESSION["tvCO2"])/1000;
    // echo ( "techCO2"."<br>" );
    // echo ( $_SESSION["techCO2"]."<br>" );


    #carbon footprint total (tonnes)
    $_SESSION["carbonFootprint"]= $_SESSION["travelCO2"]+$_SESSION["clothesCO2"]+$_SESSION["housingCO2"]+$_SESSION["foodCO2"]+$_SESSION["techCO2"];
    // echo ( "carbonFootprint"."<br>" );
    // echo ( $_SESSION["carbonFootprint"]."<br>" );
?>

<html>

<head>
    <title>CO2 Calculator</title>
    <link rel="stylesheet" href="style2.css">

</head>

<body>

    <div class="content">
    <div class="indexText">
        <br /><br />
        <p id = "text">
            Thank you for reflecting and providing these responses about your lifestyle in 2019. 
            <br><br> When you’re ready, please continue to the next section.
        </p>

     </div>
    </div>   

    <center>
        <form method="post" action="checkpoint12.php">
            <input type="submit" value="Next">
        </form>
    </center>

</body>
</html>