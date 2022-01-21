<?php
	session_start();

	if ($_SESSION["condition"]==0){

		$array = $fields = array(); $i = 0;
		$handle = @fopen("data/co2data.csv", "r");
		if ($handle) {
			while (($row = fgetcsv($handle, 4096)) !== false) {
				if (empty($fields)) {
					$fields = $row;
					continue;
				}
				foreach ($row as $k=>$value) {
					$array[$i][$fields[$k]] = $value;
				}
				$i++;
			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($handle);
		}
	
		// echo '<pre>'; print_r($array); echo '</pre>';
	
		$arrIt = new RecursiveArrayIterator($array);
		$searchState = $_SESSION["state"];
		
		foreach ($arrIt as $sub){
			if (in_array($searchState,$sub)){
				$arraySubArr = $sub;
				break;
				}
			}
		
		$foundSubArr = array_search($arraySubArr, $array);
		// echo '<pre>'; print_r($foundSubArr); echo '</pre>';
		// echo '<pre>'; print_r(  $_SESSION["co2DataArray"]); echo '</pre>';
	
		$_SESSION["co2DataArray"] = $array[$foundSubArr];
	
		//gasoline
		$_SESSION["gas"]=99999;
		$_SESSION["gasCO2"]=99999;
		//diesel
		$_SESSION["diesel"]=99999;
		$_SESSION["dieselCO2"]=99999;

		//economy flights
		$_SESSION["eshortflight"]=99999;
		$_SESSION["emediumflight"]=99999;
		$_SESSION["elongflight"]=99999;
		$_SESSION["everylongflight"]=99999;
	
		$_SESSION["eshortflightCO2"]=99999;
		$_SESSION["emediumflightCO2"]=99999;
		$_SESSION["elongflightCO2"]=99999;
		$_SESSION["everylongflightCO2"]=99999;
	
		
		$_SESSION["bshortflight"]=99999; 
		$_SESSION["bmediumflight"]=99999;
		$_SESSION["blongflight"]=99999;
		$_SESSION["bverylongflight"]=99999; 
	
		$_SESSION["bshortflightCO2"]=99999;
		$_SESSION["bmediumflightCO2"]=99999;
		$_SESSION["blongflightCO2"]=99999;
		$_SESSION["bverylongflightCO2"]=99999;
		
		$_SESSION["travelCO2"]=99999;
	
		//clothes
		$_SESSION["jackets"]=99999;
		$_SESSION["jacketsCO2"]=99999; 
		$_SESSION["jeans"]=99999;
		$_SESSION["jeansCO2"]=99999; 
		$_SESSION["shoes"]=99999;
		$_SESSION["shoesCO2"]=99999; 
		$_SESSION["shirt"]=99999; 
		$_SESSION["shirtCO2"]=99999;
	
		$_SESSION["clothesCO2"]=99999;
	
		//housing
		$_SESSION["housing"]=99999;
		$_SESSION["housesize"]=99999;
		$_SESSION["numberpeople"]=99999;
		$_SESSION["housingCO2"]=99999;
	
		//food
		$_SESSION["redmeat"]=99999;																
		$_SESSION["redmeatCO2"]=99999;			
	
		$_SESSION["othermeat"]=99999;																
		$_SESSION["othermeatCO2"]=99999;																
															
		$_SESSION["cheese"]=99999;																
		$_SESSION["cheeseCO2"]=99999;																
																	
		$_SESSION["milk"]=99999;																
		$_SESSION["milkCO2"]=99999;																
															
		$_SESSION["egg"]=99999;																
		$_SESSION["eggCO2"]=99999;																
																
		$_SESSION["fruit"]=99999;																
		$_SESSION["fruitCO2"]=99999;																
																
		$_SESSION["legume"]=99999;																
		$_SESSION["legumeCO2"]=99999;																
																	
		$_SESSION["vegetable"]=99999;																
		$_SESSION["vegetableCO2"]=99999;																
																
		$_SESSION["grain"]=99999;																
		$_SESSION["grainCO2"]=99999;																
																	
		$_SESSION["foodCO2"]=99999;
	
		//tech device
		$_SESSION["phone"]=99999;
		$_SESSION["phoneCO2"]=99999;
		$_SESSION["laptop"]=99999;
		$_SESSION["laptopCO2"]=99999;
		$_SESSION["tv"]=99999;
		$_SESSION["tvCO2"]=99999;
	
		$_SESSION["techCO2"]=99999;
	
		#carbon footprint
		$_SESSION["carbonFootprint"]=99999;


	} 


	#meat and dairy per week
	$_SESSION["redmeatperweek"]=$_SESSION["redmeat"];
	$_SESSION["othermeatperweek"]=$_SESSION["othermeat"];
	$_SESSION["cheeseperweek"]=$_SESSION["cheese"];
	$_SESSION["milkperweek"]=$_SESSION["milk"];
	
	#meat price tag 1
	$_SESSION["meattag1"] = ((($_SESSION["redmeatperweek"]/2*52*4.56)+($_SESSION["othermeatperweek"]/2*52*0.7)+($_SESSION["cheeseperweek"]/2*52*0.27)+($_SESSION["milkperweek"]/2*52*0.55))-(($_SESSION["redmeatperweek"]/2+$_SESSION["othermeatperweek"]/2+$_SESSION["cheeseperweek"]/2+$_SESSION["milkperweek"]/2)*52*0.06))/1000;
	// echo ($_SESSION["meattag1"]."<br>");

	#meat price tag 2
	$_SESSION["meattag2"] = (($_SESSION["redmeatperweek"]*52*4.56)-($_SESSION["redmeatperweek"]*52*0.7))/1000;
	
	// echo ($_SESSION["meattag2"]."<br>");

	#flight question
	if ($_SESSION["eshortflight"]>0 || $_SESSION["eshortflight"]>0 || $_SESSION["emediumflight"]>0 || $_SESSION["elongflight"]>0 || $_SESSION["everylongflight"] ||
		$_SESSION["bshortflight"]>0 || $_SESSION["bshortflight"]>0 || $_SESSION["bmediumflight"]>0 || $_SESSION["blongflight"]>0 || $_SESSION["bverylongflight"] ){
		$_SESSION["flight"] = 1;
	}else{
		$_SESSION["flight"] = 0;
	}
	
	#if medium, long, very long flight is >0
	if ($_SESSION["elongflight"]>0 || $_SESSION["blongflight"]>0 || $_SESSION["emediumflight"]>0 || $_SESSION["bmediumflight"]>0 || $_SESSION["everylongflight"]>0 || $_SESSION["bverylongflight"]>0){
		
		$_SESSION["flightlong"] = 1;
	}else{
		$_SESSION["flightlong"] = 0;
	}

	$_SESSION["flightCO2"]=$_SESSION["eshortflightCO2"]+$_SESSION["emediumflightCO2"]+$_SESSION["elongflightCO2"]+$_SESSION["everylongflightCO2"]+$_SESSION["bshortflightCO2"]+$_SESSION["bmediumflightCO2"]+$_SESSION["blongflightCO2"]+$_SESSION["bverylongflightCO2"];

	// echo ($_SESSION["flight"]."<br>");
	// echo ($_SESSION["flightlong"]."<br>");
	// echo ($_SESSION["flightCO2"]."<br>");

	//driving question
	$_SESSION["drivingCO2"]=$_SESSION["gasCO2"]+$_SESSION["dieselCO2"];

	//participants need to eat some animal products to include food in the ranking
	if ($_SESSION["redmeat"]>0 || $_SESSION["othermeat"]>0 || $_SESSION["cheese"]>0 || $_SESSION["milk"]>0){
		$fourcategory = array(
			"food" => $_SESSION["foodCO2"],
			"driving" => $_SESSION["drivingCO2"],
			"flight" => $_SESSION["flightCO2"],
			"clothes" => $_SESSION["clothesCO2"],
		);
	}else{
		$fourcategory = array(
			"driving" => $_SESSION["drivingCO2"],
			"flight" => $_SESSION["flightCO2"],
			"clothes" => $_SESSION["clothesCO2"],
		);
	}

	arsort($fourcategory); //sort array with key-value in descending order
	$firstdomain =  array_keys($fourcategory)[0];
	$seconddomain =  array_keys($fourcategory)[1];

	// echo '<pre>'; print_r(  $fourcategory); echo '</pre>';
	// echo  $firstdomain;
	// echo  $seconddomain;


	$gasco2perlitre=0.002347;
    $gasco2pergallon=0.002347*3.78541;
    if($_SESSION["co2DataArray"]["Country"]=="Canada"){
        $_SESSION["gasCarbontag"]=100/($_SESSION["co2DataArray"]["Gasoline2021"])*$gasco2perlitre;
    }else{
        $_SESSION["gasCarbontag"]=100/($_SESSION["co2DataArray"]["Gasoline2021"])*$gasco2pergallon;
	}
	$_SESSION["gasCarbontag"]=$_SESSION["gasCarbontag"]*1000;
    // echo ( $_SESSION["gasCarbontag"] ."<br>");

    $dieselco2perliter=0.01018/3.78541;
    $dieselco2pergallon=0.010180; #3.78541 L = 1 gallon
    if($_SESSION["co2DataArray"]["Country"]=="Canada"){
        $_SESSION["dieselCarbontag"]=100/($_SESSION["co2DataArray"]["Diesel2021"])*$dieselco2perliter;
    }else{
        $_SESSION["dieselCarbontag"]=100/($_SESSION["co2DataArray"]["Diesel2021"])*$dieselco2pergallon;
	}
	$_SESSION["dieselCarbontag"]=$_SESSION["dieselCarbontag"]*1000;
    // echo ( $_SESSION["dieselCarbontag"] ."<br>");

	//housing question 
	$detached = $_SESSION["co2DataArray"]["SingleDetached_household"]*$_SESSION["co2DataArray"]["CarbonIntensity"];
	$attached = $_SESSION["co2DataArray"]["SingleAttached_household"]*$_SESSION["co2DataArray"]["CarbonIntensity"];
	$smallapartment = $_SESSION["co2DataArray"]["SmallApartmentBuilding_household"]*$_SESSION["co2DataArray"]["CarbonIntensity"];
	$largeapartment = $_SESSION["co2DataArray"]["LargeApartmentBuilding_household"]*$_SESSION["co2DataArray"]["CarbonIntensity"];
	$mobilehome = $_SESSION["co2DataArray"]["MobileHome_household"]*$_SESSION["co2DataArray"]["CarbonIntensity"];


	
	//Qualtrics link
	$qualtricslink="https://ubc.ca1.qualtrics.com/jfe/form/SV_3Dhh3vcfPcTdzYW?condition=".$_SESSION['condition']."&subject=".$_SESSION['code']."&attentioncheckpilot2=".$_SESSION['carbonfootpilot2']."&carbonfoot2019=". $_SESSION["carbonFootprint"]
	."&country=".($_SESSION["co2DataArray"]["Country"])."&redmeat=".$_SESSION["redmeat"]."&othermeat=".$_SESSION["othermeat"]."&cheese=".$_SESSION["cheese"]."&milk=".$_SESSION["milk"]."&meattag1=".$_SESSION["meattag1"]."&meattag2=".$_SESSION["meattag2"]
	."&flight=".$_SESSION["flight"]."&flightlong=".$_SESSION["flightlong"]."&flightCO2=".$_SESSION["flightCO2"]."&drivingCO2=".$_SESSION["drivingCO2"]."&clothesCO2=".$_SESSION["clothesCO2"]
	."&firstdomain=".$firstdomain."&seconddomain=".$seconddomain."&gascarbontag=".$_SESSION["gasCarbontag"]."&dieselcarbontag=".$_SESSION["dieselCarbontag"]
	."&detached=".$detached."&attached=".$attached."&smallapartment=".$smallapartment."&largeapartment=".$largeapartment."&mobilehome=".$mobilehome;

	// echo $qualtricslink;


	#store mturk code
	$stringcode=array();
	$stringcode = array(
	//record the data
	$_SESSION['subj'],
	$_SESSION['date'],
	$_SESSION['code'],
	$_SESSION['ipaddress'],
	$_SESSION['state'],
	$_SESSION['condition'],
	$_SESSION['carbonfootpilot2'],

	//existing CO2 data
	$_SESSION["co2DataArray"]["Country"],
	$_SESSION["co2DataArray"]["Gasoline"],
	$_SESSION["co2DataArray"]["Diesel"],
	$_SESSION["co2DataArray"]["Gasoline2021"],
	$_SESSION["co2DataArray"]["Diesel2021"],
	$_SESSION["co2DataArray"]["CarbonIntensity"],
	$_SESSION["co2DataArray"]["SingleDetached_sqft"],
	$_SESSION["co2DataArray"]["SingleAttached_sqft"],
	$_SESSION["co2DataArray"]["SmallApartmentBuilding_sqft"],
	$_SESSION["co2DataArray"]["LargeApartmentBuilding_sqft"],
	$_SESSION["co2DataArray"]["MobileHome_sqft"],
	$_SESSION["co2DataArray"]["SingleDetached_household"],
	$_SESSION["co2DataArray"]["SingleAttached_household"],
	$_SESSION["co2DataArray"]["SmallApartmentBuilding_household"],
	$_SESSION["co2DataArray"]["LargeApartmentBuilding_household"],
	$_SESSION["co2DataArray"]["MobileHome_household"],


	//gasoline
	$_SESSION["gas"],
	$_SESSION["gasCO2"],
	//diesel
	$_SESSION["diesel"],
	$_SESSION["dieselCO2"],

	//economy flights
	$_SESSION["eshortflight"],
	$_SESSION["emediumflight"],
	$_SESSION["elongflight"],
	$_SESSION["everylongflight"],

	$_SESSION["eshortflightCO2"],
	$_SESSION["emediumflightCO2"],
	$_SESSION["elongflightCO2"],
	$_SESSION["everylongflightCO2"],
	
	//business
	
	$_SESSION["bshortflight"], 
	$_SESSION["bmediumflight"],
	$_SESSION["blongflight"],
	$_SESSION["bverylongflight"], 

	$_SESSION["bshortflightCO2"],
	$_SESSION["bmediumflightCO2"],
	$_SESSION["blongflightCO2"],
	$_SESSION["bverylongflightCO2"],
	
	$_SESSION["travelCO2"],

	//clothes
	$_SESSION["jackets"],
	$_SESSION["jacketsCO2"], 
	$_SESSION["jeans"],
	$_SESSION["jeansCO2"], 
	$_SESSION["shoes"],
	$_SESSION["shoesCO2"], 
	$_SESSION["shirt"], 
	$_SESSION["shirtCO2"],

	$_SESSION["clothesCO2"],

	//housing
	$_SESSION["housing"],
	$_SESSION["housesize"],
	$_SESSION["numberpeople"],
	$_SESSION["housingCO2"],

	//food
	$_SESSION["redmeat"],																
	$_SESSION["redmeatCO2"],			

	$_SESSION["othermeat"],																
	$_SESSION["othermeatCO2"],																
														
	$_SESSION["cheese"],																
	$_SESSION["cheeseCO2"],																
																
	$_SESSION["milk"],																
	$_SESSION["milkCO2"],																
														
	$_SESSION["egg"],																
	$_SESSION["eggCO2"],																
															
	$_SESSION["fruit"],																
	$_SESSION["fruitCO2"],																
															
	$_SESSION["legume"],																
	$_SESSION["legumeCO2"],																
																
	$_SESSION["vegetable"],																
	$_SESSION["vegetableCO2"],																
															
	$_SESSION["grain"],																
	$_SESSION["grainCO2"],																
																
	$_SESSION["foodCO2"],

	//tech device
	$_SESSION["phone"],
	$_SESSION["phoneCO2"],
	$_SESSION["laptop"],
	$_SESSION["laptopCO2"],
	$_SESSION["tv"],
	$_SESSION["tvCO2"],

	$_SESSION["techCO2"],

	#carbon footprint
	$_SESSION["carbonFootprint"]);



    $allcode = array($stringcode);

	$alldata = "data/calculatorOutputData.csv";
	$fhcode = fopen($alldata,'a') or die("Can't open calculatorOutputData.csv!");
	
    foreach ($allcode as $line){
            fputcsv($fhcode, $line); 
    }
    
    fclose($fhcode);

?>

<html>
<head>
	<title>CO2 Calculator</title>
    
    <link rel="stylesheet" href="style2.css">

	<script type="text/javascript">
		
		// function setQualtricsLink{
		// 	var condition =<?php echo json_encode($_SESSION['condition']); ?>;
		// 	var subject =<?php echo json_encode($_SESSION['code']); ?>;
		// 	document.getElementById("qualtricsLink").src = "https://ubc.ca1.qualtrics.com/jfe/form/SV_81fExhKSkGztL5s" + "?condition="+condition +"&subject="+subject;
		// }

    </script>

</head>

<body>


<p><iframe src="<?php echo $qualtricslink?>" style="width:100%;height:99%;" frameBorder="0"></iframe></p>
            
</body>
</html>