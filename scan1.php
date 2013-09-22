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
      <img src="img/facebooklogo.jpg" height="40" align="right">
      <img src="img/twitterlogo.jpg" height="40" align="right">
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
    <form class="form-horizontal well" data-async data-target="#rating-modal" action="/some-endpoint" method="POST">
     
                    <label for="name">Name</label>
                    <input type="text" value="" name="name">
                    <label for="email">Email</label>
                    <input type="text" value="@" name="email">
                    
    </br></br>
                    
    <fieldset>
    <form method="POST" action=""></form>
    <label  for="phone">Phone </label>
    <span>
      <input name="phonenumber"  size="3" maxlength="3" value="" type="text"> -
      <label for="">(###)</label>
    </span>
    <span>
      <input id="phonenumber2"  class="element text" size="3" maxlength="3" value="" type="text"> -
      <label for="element_4_2">###</label>
    </span>
    <span>
      <input id="phonenumber3"  class="element text" size="4" maxlength="4" value="" type="text">
      <label for="element_4_3">####</label>
      </br></br>
      <h4>Leave your feedback!</h4>
      <textarea class="form-control" rows="3"></textarea>
      </fieldset>

    </form>

  </div>
        
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
          <a href="#" class="btn btn-primary">Save changes</a>
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
	require_once("classes/GeneralAreaFinding.php");
    
    $skinX[0]=$_POST["skinX0"];
    $skinY[0]=$_POST["skinY0"];
    for($i=1;$i<=1;$i++)
    {
        if(isset($_POST["skinX".$i]))
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
            
            
			$normal = new Point($skinX[0], $skinY[0]);
			$question = new Point($skinX[1], $skinY[1]);
            $calibration1 = new Point($calX[0], $calY[0]);
			$calibration2 = new Point($calX[1], $calY[1]);


			$areaFinder = new GeneralAreaFinding($normal,$question,$image);

			$areaFinder->setCalibration($calibration1, $calibration2, $calibrationLength);
			
            
			$answer = $areaFinder->getTotalArea();
			
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

 						<span class="label label-success">Area of texture:</span> 
                        <br />
                        <?php echo round($answer,2);?> cm<sup>2</sup>
			
			
 						</br></br></br>
 						
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