<?php
    //created by Yu Luo
    //date: August 25, 2021
    //copyright @ Yu Luo

    #UNCOMMENT LINE 45, LINE 160, LINE 231, LINE 234 BEFORE LAUNCH
	
    session_start();

    $_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];
    // echo $_SESSION['ipaddress'] ;

    #read the previous IP data
    $array = $fields = array(); $i = 0;
    $handle = @fopen("data/subjip.csv", "r");
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

    #check whether the current ip is in the IP data file
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }
    $oldIP = in_array_r($_SESSION['ipaddress'], $array) ? 1 : 0; #if the ip exists = 1, else = 0
    $oldIP = in_array_r("73.45.108.140", $array) ? 1 : 0; #if the ip exists = 1, else = 0
    // echo $oldIP;

    #depending on the IP, p will get a new condition or the old condition    
    if($oldIP==0){
        ## Generate MTurk code 
        $digits = 8;
        $_SESSION['code'] = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        #record the time and date of the experiment
        date_default_timezone_set('America/Los_Angeles');
        $_SESSION['date'] = date("Y-m-d h:i:sa");

        //write subject number 
        $subjFile = "data/subj.txt";

        $fh = fopen($subjFile,'r');			// process subject number (max 9999999999)
        $subj = fread($fh,10);
        fclose($fh);
        
        //echo $subj;
        
        $_SESSION['subj'] = $subj;

        $strData = $subj + 1;
        
        $fh = fopen($subjFile,'w');
        fwrite($fh,$strData) or die("Couldn't write to subject file.");
        fclose($fh);


        //open carbonfoot pilot2 file
        $pilot2lines = file('data/pilot3CarbonFoot.csv');
        $pilot2row = $pilot2lines[$_SESSION['subj']]; // Assuming one header row
        $pilot2data = str_getcsv($pilot2row); // Parse line to CSV
        
        $_SESSION['carbonfootpilot2'] = $pilot2data[0];
        // echo $_SESSION['carbonfootpilot2'];

        // Assign participants to one of the 5 conditions
        // Condition 0: Control without calculator inputs
        // Condition 1: Control (do the calculator with NO outputs. No price tags on the intentions)
        // Condition 2: Price tags only (do the calculator with NO outputs. Price tags on the intentions)
        // Condition 3: Calculator outputs only (do the calculator and receive output information including the total annual footprint, a breakdown by domain, a personal 40% reduction target, and 3 personal recommendations. No price tags on the intentions)
        // Condition 4: Calculator outputs and price tags (do the calculator and receive output information including the total annual footprint, a breakdown by domain, a personal 40% reduction target, and 3 personal recommendations. Price tags on the intentions)

        #count the current number of p in each condition, assign new participants to the lowest condition 
        function getConditionCount($fileName){
            $fh = fopen($fileName,'r');
            $conditionCount = fread($fh,10);
            fclose($fh);
            return $conditionCount;
        }

        $zeroCount=getConditionCount("data/zero.txt");
        $oneCount=getConditionCount("data/one.txt");
        $twoCount=getConditionCount("data/two.txt");
        $threeCount=getConditionCount("data/three.txt");
        $fourCount=getConditionCount("data/four.txt");

        $conditionCountArray=array($zeroCount, $oneCount, $twoCount, $threeCount, $fourCount);

        if(count(array_unique($conditionCountArray))==1){
            // $conditionArray = array(0, 1 ,2,3,4);
            $conditionArray = array(0, 1);//change to condition 0 and 1
            shuffle($conditionArray);
            $_SESSION['condition'] = $conditionArray[0];    
        }else{
            $minCondCount=min(array_keys($conditionCountArray, min($conditionCountArray))); #if multiple minimum, choose the first index
            $_SESSION['condition'] = $minCondCount;
            // echo 'hha'.$minCondCount.'haha';
        }

        function writeNewConditionCount($caseCondition, $caseFile){
            $caseNewConditionCout = $caseCondition + 1;
            $fh = fopen($caseFile,'w');
            fwrite($fh,$caseNewConditionCout) or die("Couldn't write to condition file.");
            fclose($fh);
        }

        switch ($_SESSION['condition']) {
            case 0:
                writeNewConditionCount($zeroCount, "data/zero.txt");
                break;
            case 1:
                writeNewConditionCount($oneCount, "data/one.txt");
                break;
            case 2:
                writeNewConditionCount($twoCount, "data/two.txt");
                break;
            case 3:
                writeNewConditionCount($threeCount, "data/three.txt");
                break;
            case 4:
                writeNewConditionCount($fourCount, "data/four.txt");
                break;
        }

        #save the new ip, subj, code, condition to the subjip.csv
    	$stringcode=array();
    	$stringcode = array($_SESSION['subj'], $_SESSION['ipaddress'], 
                            $_SESSION['condition'], $_SESSION['code'], $_SESSION['carbonfootpilot2']);
        $allcode = array($stringcode);

        $alldata = "data/subjip.csv";
        $fhcode = fopen($alldata,'a') or die("Can't open subjip.csv!");
        
        foreach ($allcode as $line){
                fputcsv($fhcode, $line); 
        }
        
        fclose($fhcode);
    
    }else{
        $arrIt = new RecursiveArrayIterator($array);
        $searchIP = $_SESSION['ipaddress'];
        // $searchIP="73.45.108.140";
        foreach ($arrIt as $sub){
            if (in_array($searchIP,$sub)){
                $arraySubArr = $sub;
                break;
                }
            }
        
        $foundSubArr = array_search($arraySubArr, $array); #find the index of the exisiting IP in the multi array
        // echo '<pre>'; print_r($foundSubArr); echo '</pre>';
    
        $ipInfo = $array[$foundSubArr]; #get the subarray containing the exisiting IP
        // echo '<pre>'; print_r(  $ipInfo); echo '</pre>';

        ## get code 
        $_SESSION['code'] =  $ipInfo['code'];

        #record the time and date of the experiment
        date_default_timezone_set('America/Los_Angeles');
        $_SESSION['date'] = date("Y-m-d h:i:sa");
        
        //get $subj;
        $_SESSION['subj'] = $ipInfo['id'];

        #get condition
        $_SESSION['condition'] = $ipInfo['condition'];

        #get carbonfootpilot2
        $_SESSION['carbonfootpilot2'] = $ipInfo['carbonfootpilot2'];
    }

    $page = "";
    if ($_SESSION['condition']==0){
        $page = "checkpoint.php"; //for condition 1 and 2
    }else{
        $page = "cal1.php"; //for condition 3 and 4
    }
    
    // echo $_SESSION['subj'];
    // echo $_SESSION['ipaddress'];
    // echo $_SESSION['condition'];
    // echo $_SESSION['code'];

    if ($_SESSION['condition']==3 || $_SESSION['condition']==4){
        $_SESSION['carbonfootpilot2'] = 999999;
    }else{
        $_SESSION['carbonfootpilot2'] =$_SESSION['carbonfootpilot2'];
    }

    // check whether the ip address is in the completion csv. if the ip address completed the study before, warn that they cannot do it a second.
    #read the previous IP data
    $arrayIPcompleted = $fieldsIPcompleted = array(); $i = 0;
    $handleIPcompleted = @fopen("data/IPcompleted.csv", "r");
    if ($handleIPcompleted) {
        while (($rowIPcompleted = fgetcsv($handleIPcompleted, 4096)) !== false) {
            if (empty($fieldsIPcompleted)) {
                $fieldsIPcompleted = $rowIPcompleted;
                continue;
            }
            foreach ($rowIPcompleted as $k=>$value) {
                $arrayIPcompleted[$i][$fieldsIPcompleted[$k]] = $value;
            }
            $i++;
        }
        if (!feof($handleIPcompleted)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handleIPcompleted);
    }

    $_SESSION['completedIP'] = in_array_r($_SESSION['ipaddress'], $arrayIPcompleted) ? 1 : 0; #if the ip exists = 1, else = 0
    // $completedIP = in_array_r("73.45.108.140", $array) ? 1 : 0; #if the ip exists = 1, else = 0
    // echo $_SESSION['completedIP'];
    // echo $_SESSION['condition'];


?>

<html>
<head>
	<title>CO2 Calculator</title>
    
    	<!-- Font Awsome Core CSS -->
    <link rel="stylesheet" href="style2.css">


    <script type="text/javascript">
        function validate() {

            //Q3 number of people
            if (locationstate.state.value==""){
                alert("Please select your province or state");
                return false;
            }
        }

        var condition =<?php echo json_encode($_SESSION['condition']); ?>;
        var completedIP =<?php echo json_encode($_SESSION['completedIP']); ?>;

        function hideDiv(){
            if (completedIP==1){
                document.getElementById("welcomefull").style.display = "none";  //hide
                document.getElementById("completedbefore").style.display = "block";  //hide
            }else{
                if (condition==0){
                document.getElementById("welcomemsg").style.display = "none";  //hide
                }
            }
        }


    </script>

</head>

<body onload="hideDiv()">
<div class="content">
    <div class="indexText">
        <div id = "completedbefore" style="display:none">
            We found your IP address in our completion list. 
            <br /><br />
            Unfortunately, you cannot do the survey more than once.
            <br /><br />
        </div>
    </div>
</div>

<div class="content" id="welcomefull">
    <div class="indexText">
        <br />
        <h1 id = "name">Welcome!</h1>

        <div id = "welcomemsg" style="display:block">
            In this survey, you will reflect on some of the things you did in the last year of &ldquo;normal&rdquo; activity pre-COVID (i.e., 2019). 
            Please answer the following questions to the best of your ability about your own <b>individual</b> behaviour (not your family&apos;s behaviour).
            <br /><br />
        </div>
        
        <!-- create the province and state dropdown menu -->
        <form name="locationstate" method="post" action="<?php echo $page?>" onSubmit="return validate()">
            
            Please select your province or state.

            <select id="state" name="state">
                <option value="">Select One</option>
                <optgroup label="U.S. States">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </optgroup>



                <optgroup label="Canadian Provinces">
                    <option value="AB">Alberta</option>
                    <option value="BC">British Columbia</option>
                    <option value="MB">Manitoba</option>
                    <option value="NB">New Brunswick</option>
                    <option value="NF">Newfoundland</option>
                    <option value="NT">Northwest Territories</option>
                    <option value="NS">Nova Scotia</option>
                    <option value="NU">Nunavut</option>
                    <option value="ON">Ontario</option>
                    <option value="PE">Prince Edward Island</option>
                    <option value="QC">Quebec</option>
                    <option value="SK">Saskatchewan</option>
                    <option value="YT">Yukon Territory</option>
                </optgroup>
            </select>

            <br /><br /><br /><br />
            <!-- move to the next page and record the province/state -->
            <input type="submit" value="Next">

        </form>
    </div>
</div>
            

    <!--Begin footer 2-->
    <!-- <footer class="footer">
            Copyright &copy; 2016 BALANCE WELL-BEING CENTRE INC. All Rights Reserved.
            <a href="https://www.facebook.com/Balance-Well-Being-Centre-Inc-1726974867530457/?ref=aymt_homepage_panel" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/ShawnaMcCrea" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="https://ca.linkedin.com/in/shawna-mccrea-1b8b1744" target="_blank"><i class="fa fa-linkedin"></i></a>
    </footer> -->
    <!--End footer 2-->
</body>
</html>


