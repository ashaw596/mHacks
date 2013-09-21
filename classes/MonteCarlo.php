<?php
class MonteCarlo{


	 private	$totalBurn;		 //int
	 private	$firstDegBurnArea;	 //int
	 private	$secondDegBurnArea; //int
	 private	$thirdDegBurnArea;	 //int
	 private	$imagefile;		 //image	
	 private	$pointOfNormalSkin;	//point
	 private	$pointOfFirstDegBurn;  //point
	 private	$pointOfSecondDegBurn;  //point
	 private	$pointOfThirdDegBurn;  //point
	 private $leftMostXCoord;       //leftmost burn pixel
	 private $rightMostXCoord;		   //rightmost burn pixel
	 private $topMostYCoord;          //topmost burn pixel
	 private $bottomMostYCoord;       //bottommost burn pixel
	 private $firstDegList = array();   //list of points(x,y) that fit within first deg burn category
	 private $secondDegList = array();  //list of points that fit within second deg burn category
	 private $thirdDegList = array();   //list of points that fit within third deg burn category
	 private $totalPointsList = array();
	 private $imageXCoord; //int, x size of image passed in
	 private $imageYCoord; //int, y size of image passed in
	 private $calibrationStick;
	 private $magnitude; //cal stick magnitude
	 private $squareArea;
	 private $numOfPixelsInSquare;


	 
	public function setImageToUse($anImage) {
   	$this->imagefile = $anImage;
		$this->imageXCoord = imagesx($imagefile);
		$this->imageYCoord = imagesy($imagefile);
   }
	
	public function setCalibration($point1, $point2, $magnitude){
		$x = $point1->getX() - $point2->getX();
		$y = $point1->getY() - $point2->getY();
		$this->calibrationStick = sqrt($x*$x + $y*$y);
		$this->magnitude = $magnitude;
	}
	 
	public function setNormalSkinPoint($pointOfNormalSkin){
	 	$this->pointOfNormalSkin = $pointOfNormalSkin;
		
	}
	
	public function setFirstDegPoint($pointOfFirstDegBurn){
	 	$this->pointOfFirstDegBurn = $pointOfFirstDegBurn;	
	}
	
	public function setSecondDegPoint($pointOfSecondDegBurn){
		$this->pointOfSecondDegBurn = $pointOfSecondDegBurn;			
	}
	
	public function setThirdDegPoint($pointOfThirdDegBurn){
	 	$this->pointOfThirdDegBurn = $pointOfThirdDegBurn;
	}



   public function getTotalBurnArea() {
	 	$totalBurnArea = $firstDegBurn + $secondDegBurn + $thirdDegBurn;
    	return $this->totalBurn;
   }
	 
	 
	public function getFirstDegreeArea() {
		getSquare();
		$numberOfFirstDegPoints = 0;
		foreach ($firstDegList as &$value) {
			$numberOfFirstDegPoints = $numberOfFirstDegPoints + 1;
		}
		$this-> $firstDegBurnArea = ($numberOfFirstDegPoints*$squareArea)/$numOfPixelsInSquare;
   	return $this->firstDegBurnArea;
   }
	 
	public function getSecondDegreeArea() {
		getSquare();
		$numberOfSecondDegPoints = 0;
		foreach ($secondDegList as &$value) {
			$numberOfSecondDegPoints = $numberOfSecondDegPoints + 1;
		}
		$this-> $secondDegBurnArea = ($numberOfSecondDegPoints*$squareArea)/$numOfPixelsInSquare;
   	return $this->secondDegBurnArea;
   }

	public function getThirdDegreeArea() {
		getSquare();
		$numberOfThirdDegPoints = 0;
		foreach ($ThirdDegList as &$value) {
			$numberOfThirdDegPoints = $numberOfThirdDegPoints + 1;
		}
		$this-> $thirdDegBurnArea = ($numberOfThirdDegPoints*$squareArea)/$numOfPixelsInSquare;
   	return $this->thirdDegBurnArea;
   }
	
	 
	
	private function getSquare(){
		seeWhereDiffBurnsAre();
		$this->leftMostXCoord = 100000000000000;
		$this->rightMostXCoord = 0;
		$this->topMostYCoord = 100000000000000;
		$this->bottomMostYCoord = 0;
		foreach ($totalBurnsList as &$value) {
    		$valueX = $value->getX();
			$valueY = $value->getY();
			if($valueX < $leftMostXCoord){ //may need to cast to int
				$leftMostXCoord = $valueX;
			}
			if($valueX > $rightMostXCoord){ //may need to cast to int           //need to know how coordinate system
				$rightMostXCoord = $valueX;                                      //works in php this assumes (0,0) is at top
			}                                                                   //left corner
			if($valueY < $topMostYCoord){ //may need to cast to int
				$topMostYCoord = $valueY;
			}
			if($valueY > $bottomMostYCoord){ //may need to cast to int
				$bottomMostYCoord = $valueY;
			}
		}
		
		$width = $rightMostXCoord - $leftMostXCoord;
		$length = $bottomMostYCoord - $topMostYCoord;
		$magOfWidth = $magnitude*$width/$calibrationStick;
		$magOfHeight = $magnitude*$height/$calibrationStick
		$this->squareArea = $magOfLength * $magOfWidth;
		$this->numOfPixelsInSquare = $width*$length;
	}


		
	
	private function seeWhereDiffBurnsAre(){
		$firstX = $pointOfFirstDegBurn->getX();
		$firstY = $pointOfFirstDegBurn->getY();		
		$pixelOfFirstDeg = imagecolorat($imagefile , $firstX, $firstY);
		$firstDegRed = ($pixelOfFirstDeg >> 16) & 0xFF;
		$firstDegGreen= ($pixelOfFirstDeg >> 8) & 0xFF;
		$firstDegBlue = $pixelOfFirstDeg & 0xFF;
		
		
		$secondX = $pointOfSecondDegBurn->getX();
		$secondY = $pointOfSecondDegBurn->getY();		
		$pixelOfSecondDeg = imagecolorat($imagefile , $secondX, $secondY);
		$secondDegRed = ($pixelOfSecondDeg >> 16) & 0xFF;
		$secondDegGreen= ($pixelOfSecondDeg >> 8) & 0xFF;
		$secondDegBlue = $pixelOfSecondDeg & 0xFF;
		

		$thirdX = $pointOfThirdDegBurn->getX();
		$thirdY = $pointOfThirdDegBurn->getY();		
		$pixelOfThirdDeg = imagecolorat($imagefile , $thirdX, $thirdY);
		$thirdDegRed = ($pixelOfThirdDeg >> 16) & 0xFF;
		$thirdDegGreen= ($pixelOfThirdDeg >> 8) & 0xFF;
		$thirdDegBlue = $pixelOfThirdDeg & 0xFF;
		
		for ($x=0; $x<=imageXCoord; $x++){
			for ($y=0; $y<=imageYCoord; $y++){
				$aPixel = imagecolorat($imagefile , $x, $y);
				$red = ($aPixel >> 16) & 0xFF;
				$green = ($aPixel >> 8) & 0xFF;
				$blue =  $aPixel & 0xFF;
 				if($red == $firstDegRed + 20 || $red == $firstDegRed - 20){
					if($green == $firstDegGreen + 20 || $green == $firstDegGreen - 20){
						if($blue == $firstDegBlue + 20 || $blue == $firstDegBlue - 20){
							$pointToInsert = new Point();
							$pointToInsert->setX($x);
							$pointToInsert->setY($y);
							array_push($firstDegList,$pointToInsert);
							array_push($totalBurnsList,$pointToInsert);
						}
					}
				}
				if($red == $secondDegRed + 20 || $red == $secondDegRed - 20){
					if($green == $secondDegGreen + 20 || $green == $secondDegGreen - 20){
						if($blue == $secondDegBlue + 20 || $blue == $secondDegBlue - 20){
							$pointToInsert = new Point();
							$pointToInsert->setX($x);
							$pointToInsert->setY($y);
							array_push($secondDegList,$pointToInsert);
							array_push($totalBurnsList,$pointToInsert);
						}
					}
				}
				if($red == $thirdDegRed + 20 || $red == $thirdDegRed - 20){
					if($green == $thirdDegGreen + 20 || $green == $thirdDegGreen - 20){
						if($blue == $thirdDegBlue + 20 || $blue == $thirdDegBlue - 20){
							$pointToInsert = new Point();
							$pointToInsert->setX($x);
							$pointToInsert->setY($y);
							array_push($thirdDegList,$pointToInsert);
							array_push($totalBurnsList,$pointToInsert);
						}
					}
				}				
			} 
  		} 
	}
	
	
	
	
	
	 
}
?>