<html>
<head>
</head>
<body>
<?php
    require_once("classes/ImageFile.php");
    
    for($i=0;$i<=5;$i++)
    {
        $skinX[$i]=$_POST["skinX".$i];
        $skinY[$i]=$_POST["skinY".$i];
    }
    $calibrationLength=$_POST["length"];
    
    
    if ($_FILES["imageLoader"]["error"] > 0)
    {
        echo "Error: " . $_FILES["imageLoader"]["error"] . "<br>";
    }
    else
    {
        echo "Upload: " . $_FILES["imageLoader"]["name"] . "<br>";
        echo "Type: " . $_FILES["imageLoader"]["type"] . "<br>";
        echo "Size: " . ($_FILES["imageLoader"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["imageLoader"]["tmp_name"] . "<br />";
        
        
        
      
        try
        {
            $imageFile = new ImageFile($_FILES["imageLoader"]);
            $image = $imageFile->toGDImage();

            
            $imageX = $imageFile -> x;
            $imageY = $imageFile -> y;
            
            
            echo "<canvas id=\"myCanvas\" width=\"$imageX\" height=\"$imageY\"></canvas>";
            echo "<script>
                  var canvas = document.getElementById('myCanvas');
                  var context = canvas.getContext('2d');
                  var imageObj = new Image();

                  imageObj.onload = function() {
                    context.drawImage(imageObj);
                  };
                  imageObj.src = '"."';
                  </script>";
    
            
            

        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
  </body>
  </html>