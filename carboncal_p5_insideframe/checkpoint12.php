<?php
	session_start();

?>

<html>
<head>
	<title>CO2 Calculator</title>
    
    	<!-- Font Awsome Core CSS -->
    <link rel="stylesheet" href="style2.css">

</head>

<body>

<div class="content">
	<div class="calResultText">

			<br /><br />
			<b><?php echo $_SESSION['carbonfootpilot2']; ?></b>
			<br><br>
			<b>Please remember the number above to enter on the next page.</b>
			<br /><br />
			This is a question checking your attention. You will only be paid for this survey if your answer is correct. 
			<br><br>
			When you're ready, please continue to the next section.

		<form name="checkpointform" method="post" action="qualtrics.php">

            <br /><br /><br /><br />
            <!-- move to the next page and record the province/state -->
            <input type="submit" value="Next">

        </form>
    </div>
</div>
            


</body>
</html>