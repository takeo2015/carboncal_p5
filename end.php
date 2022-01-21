<?php
    //created by Yu Luo
    //date: August 25, 2021
    //copyright @ Yu Luo

    #UNCOMMENT LINE 45, LINE 152, LINE 201 BEFORE LAUNCH
	
    session_start();

    $_SESSION['ipcompleted'] = $_SERVER['REMOTE_ADDR'];
    // echo $_SESSION['ipaddress'] ;
	#store mturk code
	$stringcode=array();
	$stringcode = array(
	//record the IP that has completed the study
	$_SESSION['ipcompleted']);



    $allcode = array($stringcode);

	$alldata = "carboncal_p4_insideframe/data/IPcompleted.csv";
	$fhcode = fopen($alldata,'a') or die("Can't open IPcompleted.csv!");
	
    foreach ($allcode as $line){
            fputcsv($fhcode, $line); 
    }
    
    fclose($fhcode);

    
?>

<html>
<head>
	<title>CO2 Calculator</title>
    
    	<!-- Font Awsome Core CSS -->
    <link rel="stylesheet" href="style2.css">

    </script>

</head>

<body onload="hideDiv()">


<div class="content">
    <div class="indexText">
        <br /><br />
        <div id = "welcomemsg" style="display:block">
            We thank you for your time spent taking this survey.
            <br /><br />
            Your response has been recorded.
            <br /><br />
        </div>
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


