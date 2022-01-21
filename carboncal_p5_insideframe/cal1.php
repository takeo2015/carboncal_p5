<?php
	session_start();

    $_SESSION['state'] = $_POST['state']; 
    // echo $_SESSION['state'] ;

    #read the source data

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


    // Assign participants to one of the 4 conditions
    $page = "";
    if (($_SESSION['condition']==1) | ($_SESSION['condition']==2)){
        $page = "cal2.1.php"; //for condition 1 and 2
    }else{
        $page = "cal2.2.php"; //for condition 3 and 4
    }
?>

<html>
<head>
    <title>CO2 Calculator</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style2.css">

<script type="text/javascript">

    // function setUnit(){
    //     var location =<?php echo json_encode($_SESSION['state']); ?>; // state or province from the previous page
    //     var provinces = ["VT", "QC", "MB", "BC", "ID", "WA", "PE", "OR", "NF", "CA", "ON", "YT", "AZ", 
    //     "NV", "MT", "AK", "ME", "NH", "SD", "CO", "NM", "HI", "UT", "SC", "MD", "TN", "WY", "NY", "VA", 
    //     "NC", "OK", "AL", "GA", "IL", "NJ", "LA", "CT", "IA", "FL", "TX", "DE", "MS", "AR", "NB", "MN", 
    //     "PA", "KS", "MA", "RI", "MI", "NT", "WI", "OH", "NE", "KY", "ND", "WV", "NS", "IN", "MO", "SK", "NU", "AB", "DC"];
    //     // console.log(location);
    // }

    //show slider value
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }

    function validate() {
            var noneChecked = true;

            noneChecked = true;
            for (var i=calculator.housing.length-1; i > -1; i--) {
                if (calculator.housing[i].checked){
                    noneChecked = false;
                }
            }
            
            if (noneChecked) {
                alert("Please answer question 1");
                return false;
            }

            //Q3 number of people
            // -Number of people in home =< 10
            if ((calculator.numberpeople.value=="") || (calculator.numberpeople.value==0)){
                alert("Please answer question 3");
                return false;
            }

            if (calculator.numberpeople.value>10){
                alert("Sorry the response in question 3 is not within the accepted range for this question. The maximum value for this question is 10.");
                return false;
            }

            //Q4 -Gas and diesel =< $1000 per category
            if (calculator.fieldgas.value==""){
                alert("Please answer question 4a");
                return false;
            }

            if (calculator.fieldgas.value>1000){
                alert("Sorry the response in question 4a is not within the accepted range for this question. The maximum value for this question is 1000.");
                return false;
            }

            if (calculator.fielddiesel.value==""){
                alert("Please answer question 4b");
                return false;
            }

            if (calculator.fielddiesel.value>1000){
                alert("Sorry the response in question 4b is not within the accepted range for this question. The maximum value for this question is 1000.");
                return false;
            }




            // question 5 business flight
            // -Flights =< 20 per category of flight type. 

            if (calculator.eshortflight.value==""){
                alert("Please answer question 5a");
                return false;
            }

            if (calculator.eshortflight.value>20){
                alert("Sorry the response in question 5a is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.emediumflight.value==""){
                alert("Please answer question 5b");
                return false;
            }
            
            if (calculator.emediumflight.value>20){
                alert("Sorry the response in question 5b is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.elongflight.value==""){
                alert("Please answer question 5c");
                return false;
            }

            if (calculator.elongflight.value>20){
                alert("Sorry the response in question 5c is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.everylongflight.value==""){
                alert("Please answer question 5d");
                return false;
            }

            if (calculator.everylongflight.value>20){
                alert("Sorry the response in question 5d is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.bshortflight.value==""){
                alert("Please answer question 5e");
                return false;
            }

            if (calculator.bshortflight.value>20){
                alert("Sorry the response in question 5e is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.bmediumflight.value==""){
                alert("Please answer question 5f");
                return false;
            }
            
            if (calculator.bmediumflight.value>20){
                alert("Sorry the response in question 5f is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.blongflight.value==""){
                alert("Please answer question 5g");
                return false;
            }

            if (calculator.blongflight.value>20){
                alert("Sorry the response in question 5g is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }

            if (calculator.bverylongflight.value==""){
                alert("Please answer question 5h");
                return false;
            }

            if (calculator.bverylongflight.value>20){
                alert("Sorry the response in question 5h is not within the accepted range for this question. The maximum value for this question is 20.");
                return false;
            }


            //Q6 food
            // -Each food item =< 70 servings/week 
            if (calculator.redmeat.value==""){
                alert("Please answer question 6a");
                return false;
            }

            if (calculator.redmeat.value>70){
                alert("Sorry the response in question 6a is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.othermeat.value==""){
                alert("Please answer question 6b");
                return false;
            }

            if (calculator.othermeat.value>70){
                alert("Sorry the response in question 6b is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.cheese.value==""){
                alert("Please answer question 6c");
                return false;
            }

            if (calculator.cheese.value>70){
                alert("Sorry the response in question 6c is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.milk.value==""){
                alert("Please answer question 6d");
                return false;
            }

            if (calculator.milk.value>70){
                alert("Sorry the response in question 6d is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }
            
            if (calculator.egg.value==""){
                alert("Please answer question 6e");
                return false;
            }

            if (calculator.egg.value>70){
                alert("Sorry the response in question 6e is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.grain.value==""){
                alert("Please answer question 6f");
                return false;
            }

            if (calculator.grain.value>70){
                alert("Sorry the response in question 6f is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.fruit.value==""){
                alert("Please answer question 6g");
                return false;
            }

            if (calculator.fruit.value>70){
                alert("Sorry the response in question 6g is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.vegetable.value==""){
                alert("Please answer question 6h");
                return false;
            }

            if (calculator.vegetable.value>70){
                alert("Sorry the response in question 6h is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            if (calculator.legume.value==""){
                alert("Please answer question 6i");
                return false;
            }

            if (calculator.legume.value>70){
                alert("Sorry the response in question 6i is not within the accepted range for this question. The maximum value for this question is 70.");
                return false;
            }

            // -Each clothing item =< 30 purchases per category
            //question 7 clothes
            if (calculator.jackets.value==""){
                alert("Please answer question 7a");
                return false;
            }

            if (calculator.jackets.value>30){
                alert("Sorry the response in question 7a is not within the accepted range for this question. The maximum value for this question is 30.");
                return false;
            }
            
            if (calculator.jeans.value==""){
                alert("Please answer question 7b");
                return false;
            }

            if (calculator.jeans.value>30){
                alert("Sorry the response in question 7b is not within the accepted range for this question. The maximum value for this question is 30.");
                return false;
            }

            if (calculator.shoes.value==""){
                alert("Please answer question 7c");
                return false;
            }

            if (calculator.shoes.value>30){
                alert("Sorry the response in question 7c is not within the accepted range for this question. The maximum value for this question is 30.");
                return false;
            }

            if (calculator.shirt.value==""){
                alert("Please answer question 7d");
                return false;
            }

            if (calculator.shirt.value>30){
                alert("Sorry the response in question 7d is not within the accepted range for this question. The maximum value for this question is 30.");
                return false;
            }
            //question 9 devices
            // -Each technology item =<5 purchases per category
            if (calculator.phone.value==""){
                alert("Please answer question 8a");
                return false;
            }

            if (calculator.phone.value>5){
                alert("Sorry the response in question 8a is not within the accepted range for this question. The maximum value for this question is 5.");
                return false;
            }
            
            if (calculator.laptop.value==""){
                alert("Please answer question 8b");
                return false;
            }

            if (calculator.laptop.value>5){
                alert("Sorry the response in question 8b is not within the accepted range for this question. The maximum value for this question is 5.");
                return false;
            }

            if (calculator.tv.value==""){
                alert("Please answer question 8c");
                return false;
            }

            if (calculator.tv.value>5){
                alert("Sorry the response in question 8c is not within the accepted range for this question. The maximum value for this question is 5.");
                return false;
            }
        }


</script>

</head>

<body onload="setUnit()">
<div class="content">

    <div class="instruction">
        Please fill in the questions below about your lifestyle in 2019.<br /><br />
    </div>

    <div class="text">
        <form name="calculator" method="post" action="<?php echo $page?>" autocomplete="off" onSubmit="return validate()">
        <!-- <form name="calculator" method="post" action="cal2.2.php" onSubmit="return validate()"> -->


                <div id="questionboxGray">
                   <b>1. What kind of house did you live in?</b>
                    <div class="choice">
                        <br /><input type="radio" name="housing" value="detached" />Single detached
                        <br /><input type="radio" name="housing" value="attached" />Single attached (row/terrace, duplex/townhouse/semi-detached)
                        <br /><input type="radio" name="housing" value="smallapartment" />Apartment in a building with 2–4 units 
                        <br /><input type="radio" name="housing" value="largeapartment" />Apartment in a building with 5+ units
                        <br /><input type="radio" name="housing" value="mobile" />Mobile home
                    </div>
                        
                </div>

                <div id="questionboxWhite">
                    <b>2. What was the approximate size of your home in square feet? </b>(Move the slider to adjust the size)
                    <!-- <div class="choice">                     -->
                        <div class="slidecontainer">
                            <p>Home size: <span id="demo"></span> square feet</p>
                            <input type="range" min="500" max="4500" value="2300" step="5" class="slider" id="myRange" name="housesize">
                            <br /><br />
                        </div>
                        <div class="choice">
                            <input type="checkbox" id="housesizeidk" name="housesize" value="NA">
                            <label for="housesizeidk"> I don't know the size of my home</label><br>
                        </div>
                        
                    <!-- </div> -->

                    <script>
                        var slider = document.getElementById("myRange");
                        var output = document.getElementById("demo");
                        output.innerHTML = slider.value;

                        slider.oninput = function() {
                        output.innerHTML = this.value;
                        }
                    </script>

                </div>

                <div id="questionboxGray">                
                <b> 3. How many people were in your household (including yourself)?</b>
                    <div class="choice">
                        <br />
                        <input type="number" min="1" id="numberpeople" name="numberpeople">
                        <label id="numberpeople">people</label>
                    </div>
                </div>


                <div id="questionboxWhite">
                    4. This question is about your driving behaviour.
                    <b>How much money did you spend on gasoline and/or diesel on average per month?</b> (If you didn't drive, you can put 0. If you drive
                    an electric vehicle and did not purchase gasoline, you can also put 0.)
                    <div class="choice">
                        <br />
                        <table>
                            <tr>
                            <td align="left">a. Gasoline:</td>
                            <!-- You need to add input field in your table to post data -->
                            <td align="left"><input type="number" min="0" name="fieldgas"> $ </td>
                            </tr>
                            <tr>
                            <td align="left">b. Diesel:</td>
                            <td align="left"><input type="number" min="0" name="fielddiesel"> $</td>
                            </tr>
                        </table>
                        
                        <!-- Gasoline: <input type="number" min="0" name="gas"> $
                        Diesel: <input type="number" min="0" name="diesel"> $ -->
                    </div>
                </div>

                <div id="questionboxGray">
                   5. This question is about your air travel behaviour.  
                    <b>How many one-way <u>economy class</u> flights did you take in 2019?</b> 
                    Please enter the number of flights you took within each length category. 
                    (If you had no flights in a category, you can put 0. For a roundtrip flight, you can put 2)
                        <div class="choice">
                            <br />
                            <table>
                                <tr>
                                <td align="left"> a. Short flight one-way economy (under 3 hours, for example San Francisco to Seattle):</td>
                                <!-- You need to add input field in your table to post data -->
                                <td align="left"><input type="number" min="0" id="flight" name="eshortflight"> </td>
                                </tr>
                                <tr>
                                <td align="left">b. Medium flight one-way economy (3 to 6 hours, for example Las Vegas to New York City):</td>
                                <td align="left"><input type="number" min="0" id="flight" name="emediumflight"> </td>
                                </tr>
                                <td align="left">c. Long flight one-way economy(6 to 10 hours, for example Orlando, Florida to London, England): </td>
                                <td align="left"><input type="number" min="0" id="flight" name="elongflight"> </td>
                                </tr>
                                <td align="left">d. Very long flight one-way economy (over 10 hours, for example Los Angeles, California to Sydney, Australia): </td>
                                <td align="left"><input type="number" min="0" id="flight" name="everylongflight"> </td>
                                </tr>
                            </table>
                        </div>
                    <br /><br />     
                    This question is about your air travel behaviour. 
                    <b>How many one-way <u>business or first class</u> flights did you take in 2019?</b>
                    Please enter the number of flights you took within each length category. 
                    (If you had no flights in a category, you can put 0. For a roundtrip flight, you can put 2)
                        <div class="choice">
                            <br />     
                            <table>
                                <tr>
                                <td align="left">e. Short flight one-way business (under 3 hours, for example San Francisco to Seattle):</td>
                                <!-- You need to add input field in your table to post data -->
                                <td align="left"><input type="number" min="0" id="flight" name="bshortflight"> </td>
                                </tr>
                                <tr>
                                <td align="left">f. Medium flight one-way business (3 to 6 hours, for example Las Vegas to New York City):</td>
                                <td align="left"><input type="number" min="0" id="flight" name="bmediumflight"> </td>
                                </tr>
                                <td align="left">g. Long flight one-way business(6 to 10 hours, for example Orlando, Florida to London, England): </td>
                                <td align="left"><input type="number" min="0" id="flight" name="blongflight"> </td>
                                </tr>
                                <td align="left">h. Very long flight one-way business (over 10 hours, for example Los Angeles, California to Sydney, Australia): </td>
                                <td align="left"><input type="number" min="0" id="flight" name="bverylongflight"> </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                
                <div id="questionboxWhite">
                    6. This question is about your food consumption. 
                    <b>How many servings of these foods did you eat <u>per week</u>? </b>
                    If you didn't eat some of the food categories, you can put 0.

                    <div class="choice">
                        <br />
                        <table>

                            <tr class="foodtable">
                                <td align="left">a. Red meat including beef and lamb <br />
                                (1 serving = 110g, e.g., 4oz burger or half a sirloin steak)</td>
                                <td align="left"><input type="number" min="0" id="redmeat" name="redmeat"></td>
                            </tr>
                            
                            <tr class="foodtable">
                                <td align="left">b. Other meat including poultry, pork, and fish <br />
                                (1 serving = 110g,  e.g., a small chicken breast or a pork chop the size of your palm)</td>
                                <td align="left"><input type="number" min="0" id="othermeat" name="othermeat"></td>
                            </tr>

                            <tr class="foodtable">
                                <td align="left">c. Cheese  <br />
                                (1 serving = 30g,  e.g., 3 tablespoons of grated cheddar or 1 cheese string)</td>
                                <td align="left"><input type="number" min="0" id="cheese" name="cheese"></td>
                            </tr>

                            <tr class="foodtable">
                                <td align="left">d. Dairy milk <br />
                                (1 serving = 1 cup)  </td>
                                <td align="left"><input type="number" min="0" id="milk" name="milk"></td>
                            </tr>

                            <tr class="foodtable">
                                <td align="left">e. Eggs <br />
                                 (1 serving = 1 egg)  </td>
                                <td align="left"><input type="number" min="0" id="egg" name="egg"></td>
                            </tr>

                            <tr class="foodtable">
                                <td align="left">f. Grains and cereals including corn, oatmeal, bread, pasta, and baked goods 
                                    <br />(1 serving = 50g, e.g., 1 cup cooked pasta, a slice of bread, a donut, or 1/2 cup of dry oats)</td>
                                <td align="left"><input type="number" min="0" id="grain" name="grain"></td>
                            </tr>


                            <tr class="foodtable">
                                <td align="left">g. Fruits 
                                    <br />(1 serving = 140g, e.g., an apple or a banana)</td>
                                <td align="left"><input type="number" min="0" id="fruit" name="fruit"></td>
                            </tr>

                            
                            <tr class="foodtable">
                                <td align="left">h. Vegetables
                                    <br />(1 serving = 85g, e.g., 1 heaping cup of salad greens or 1/2 cup of cooked broccoli)</td>
                                <td align="left"><input type="number" min="0" id="vegetable" name="vegetable"></td>
                            </tr>

                            <tr class="foodtable">
                                <td align="left">i. Legumes including beans, lentils, peas, tofu, peanuts 
                                    <br />(1 serving = 35g, e.g., 1/2 cup of cooked beans or lentils, or 1/4 cup of peanuts)</td>
                                <td align="left"><input type="number" min="0" id="legume" name="legume"></td>
                            </tr>
                        </table>
                    </div>  
                </div> 

                <div id="questionboxGray">        
                    7. This question is about your clothing purchases. 
                    <b>How many of the following items of clothing did you buy new in 2019?</b> 
                    (If you did not buy a clothing item, you can put 0. 
                    If you purchased clothing from a thrift store or any other second hand purchases, 
                    where the clothing had a previous owner, do not count these items.)
           
                    <div class="choice">
                        <br />
                        <table>
                            <tr>
                            <td align="left">a. Jackets:</td>
                            <td align="left"><input type="number" min="0" id="jackets" name="jackets"> </td>
                            </tr>
                            <tr>
                            <td align="left">b. Jeans:</td>
                            <td align="left"><input type="number" min="0" id="jeans" name="jeans"> </td>
                            </tr>
                            <tr>
                            <td align="left">c. Shoes:</td>
                            <td align="left"><input type="number" min="0" id="shoes" name="shoes"> </td>
                            </tr>
                            <tr>
                            <td align="left">d. Cotton t-shirts:</td>
                            <td align="left"><input type="number" min="0" id="shirt" name="shirt"> </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div id="questionboxWhite">
                    8. This question is about your technology purchases.  
                    <b>How many of these devices did you buy new in 2019?</b> 
                    (If you did not buy a given item, you can put 0.)

                    <div class="choice">
                        <br />
                        <table>
                            <tr>
                            <td align="left">a. Smart phone:</td>
                            <td align="left"><input type="number" min="0" id="phone" name="phone"> </td>
                            </tr>
                            <tr>
                            <td align="left">b. Laptop:</td>
                            <td align="left"><input type="number" min="0" id="laptop" name="laptop"> </td>
                            </tr>
                            <tr>
                            <td align="left">c. TV:</td>
                            <td align="left"> <input type="number" min="0" id="tv" name="tv"> </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr /><br />

                <center>
                    <input type="submit" value="Next"><br />
                </center>
        </form>
    </div>
</div>
</body>
</html>