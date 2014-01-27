 <!DOCTYPE html>
 <html>
 <head>
 	<title>Results</title>
 	<meta name ="viewport" content="width=device-width, initial-scale =1.0">
 	<link href="css/styles.css" rel = "stylesheet">
 	<link rel="stylesheet" type="text/css" href="css/bootstrap-fileupload.css">
 	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
 	<link href="css/bootstrap.min.css" rel = "stylesheet">
 	<link href="css/justified-nav.css" rel="stylesheet">
 </head>

 <body>
 	<div class="container">
    <div class="masthead">
      <a href="http://www.facebook.com/burnizer"><img src="img/facebooklogo.jpg" height="40" align="right"></a>
      <a href="https://twitter.com/Burnizer"><img src="img/twitterlogo.jpg" height="40" align="right"></a>
      <img src="img/rsslogo.png" height="40" align="right">
      <h1> Burnize </h1> 
      <ul class="nav nav-justified">
       <li><a href="index.html">Home</a></li>
       <li class="active"><a href="scan.html">Scan</a></li>
       <li><a href="about.html">About</a></li>
       <li><a href="#myModal" data-toggle="modal">Contact</a>
       <div class="modal" id="myModal">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h4 class="modal-title">Contact Us</h4>
        </div>
        
         <div class="modal-body">
    <!-- The async form to send and replace the modals content with its response -->
    <form method="POST" action="sendMail.php" id="contact">
     
                    <label for="name">Name</label>
                    <input type="text" value="" name="name">
                    <label for="email">Email</label>
                    <input type="text" value="" name="email">
                    
    </br></br>
                    
    <fieldset>
    <label  for="phone">Phone </label>
    <span>
      <input name="phonenumber"  size="3" maxlength="3" value="" type="text"> -
      <label for="">(###)</label>
    </span>
    <span>
      <input name="phonenumber2"  class="element text" size="3" maxlength="3" value="" type="text"> -
      <label for="element_4_2">###</label>
    </span>
    <span>
      <input name="phonenumber3"  class="element text" size="4" maxlength="4" value="" type="text">
      <label for="element_4_3">####</label>
      </br></br>
      <h4>Leave your feedback!</h4>
      <textarea name="message" class="form-control" rows="3"></textarea>
      </fieldset>

    </form>

  </div>
        
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
          <a href="#" class="btn btn-primary" onClick='document.getElementById("contact").submit();'>Send Feedback</a>
        </div>
      </div>
    </div>
</div></li>
     </ul>
   </div>
 </div>

 	

<?php
    require_once("classes/ImageFile.php");
	require_once("classes/Point.php");
	require_once("classes/MonteCarlo.php");
    
    $skinX[0]=$_POST["skinX0"];
    $skinY[0]=$_POST["skinY0"];
    for($i=1;$i<=3;$i++)
    {
        if(isset($_POST["skinX".$i])&&(!empty($_POST["skinX".$i])))
        {
            $skinX[$i]=$_POST["skinX".$i];
            $skinY[$i]=$_POST["skinY".$i];
            $isEnabled[$i - 1 ] = true;
        }
        else
        {
             $skinX[$i] = "";
             $skinY[$i]= "";
            $isEnabled[$i] = false;
        }
        
    }
    for($i=0;$i<=1;$i++)
    {
        $calX[$i]=$_POST["calX".$i];
        $calY[$i]=$_POST["calY".$i];
    }
    $calibrationLength=$_POST["length"];
    
    
    if ($_FILES["imageLoader"]["error"] > 0)
    {
        echo "Error: " . $_FILES["imageLoader"]["error"] . "<br>";
    }
    else
    {

        
        
        
      
        try
        {
            $imageFile = new ImageFile($_FILES["imageLoader"]);
            $image = $imageFile->toGDImage();

            
            $imageX = $imageFile -> x;
            $imageY = $imageFile -> y;
            
            
			$normalSkin = new Point($skinX[0], $skinY[0]);
			$firstDegBurn = new Point($skinX[1], $skinY[1]);
			$secondDegBurn = new Point($skinX[2], $skinY[2]);
			$thirdDegBurn = new Point($skinX[3], $skinY[3]);
			$calibration1 = new Point($calX[0], $calY[0]);
			$calibration2 = new Point($calX[1], $calY[1]);


			$monteCarlo = new MonteCarlo();
    
			$monteCarlo->setImageToUse($image);
            $monteCarlo->setWhichOnes($isEnabled);
			$monteCarlo->setCalibration($calibration1, $calibration2, $calibrationLength);
			$monteCarlo->setNormalSkinPoint($normalSkin);
			$monteCarlo->setFirstDegPoint($firstDegBurn);
			$monteCarlo->setSecondDegPoint($secondDegBurn);
			$monteCarlo->setThirdDegPoint($thirdDegBurn);
			$monteCarlo->getSquare();
			$firstDegreeAnswer = $monteCarlo->getFirstDegreeArea();
			$secondDegreeAnswer = $monteCarlo->getSecondDegreeArea();
			$thirdDegreeAnswer = $monteCarlo->getThirdDegreeArea();
			$totalDegreeAnswer = $monteCarlo->getTotalBurnArea();
			
			if($isEnabled[0]) {
				$firstDegreeAnswer = round($firstDegreeAnswer,2) . "cm<sup>2</sup>";
			} else {
				$firstDegreeAnswer = "Disabled";
			}
			if($isEnabled[1]) {
				$secondDegreeAnswer = round($secondDegreeAnswer,2) . "cm<sup>2</sup>";
			} else {
				$secondDegreeAnswer = "Disabled";
			}
			if($isEnabled[2]) {
				$thirdDegreeAnswer = round($thirdDegreeAnswer,2) . "cm<sup>2</sup>";
			} else {
				$thirdDegreeAnswer = "Disabled";
			}
			
			
			
			ob_start();
            imagepng($image);
            // Capture the output
            $imagedata = ob_get_contents();
            // Clear the output buffer
            ob_end_clean();
			

    
            
            

        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
<div class="container">
 		<div class= "jumbotron">
 			<center><h1>Results</h1></center>
 			<table class="table" border = "0">
 				<tr>

 					<td> <img src="<?php echo 'data:image/png;base64,'.base64_encode($imagedata) ;?>" alt="burn image" align="center" style="max-width: 500px;"> </td>
 					<td> <p>Here are the areas of your burn according to the photo uploaded.</p>

 						<span class="label label-success">Area of 1st Degree Burn:</span> 
                        <br />
                        <?php echo $firstDegreeAnswer;?> 
 						</br></br></br>
 						<span class="label label-warning">Area of 2nd Degree Burn:</span> 
                        <br />
                        <?php echo $secondDegreeAnswer; ?>
 						</br></br></br>
 						<span class="label label-danger">Area of 3rd Degree Burn:</span> 
                        <br />
                        <?php echo $thirdDegreeAnswer;?>
                        <br />
 					</td> 
 				</tr>
 			</table>
 		</div>
	</div>

 
 
 	<div class="modal fade" id="contact" role = "dialog">
 		<div class= "modal-dialog">
 		</div>
 	</div>

 	<div class="navbar navbar-default navbar-fixed-bottom">
 		<div class="container">
 			<p class="navbar-text pull-left">Site build by MHacks---Team-Dorito</p>
 			<a href ="#myModal" data-toggle="modal" class="navbar-button btn-info btn pull-right">Join us!</a>
 		</div>
 	</div>

 	<script src="js/jquery.js"></script>
  	<script src="js/bootstrap.js"></script>
 	<script src="js/bootstrap-fileupload.js"></script>
 </body>
 </html>
