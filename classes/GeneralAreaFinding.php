<?php
class GeneralAreaFinding{

	private $normalPoint;
	private $pointInQuestion;
	private $image;
	private $leftMostXCoord=100000;
	private $rightMostXCoord=0;
	private $topMostYCoord=100000;
	private $bottomMostYCoord=0;
	private $calibrationStick;
	private $magnitude;
	private $squareArea;
	private $numOfPixelsInSquare;
	private $counter = 0;
	
	function __construct($normalPoint, $pointInQuestion, $image){
		$this->normalPoint = $normalPoint;
		$this->pointInQuestion = $pointInQuestion;
		$this->image = $image;
	}
	
	public function setCalibration($point1, $point2, $magnitude){
		$x = $point1->getX() - $point2->getX();
		$y = $point1->getY() - $point2->getY();
		$this->calibrationStick = sqrt($x*$x + $y*$y);
		$this->magnitude = $magnitude;
	}
	
	public function getTotalArea() {
	 	$this->getSquare();
        
		$toReturn = ($this->counter*$this->squareArea)/$this->numOfPixelsInSquare;

        return $toReturn;
   }
	
	private function getSquare(){
		$this->seeWherePointsAre();
		$width = $this->rightMostXCoord - $this->leftMostXCoord;
		$length = $this->bottomMostYCoord - $this->topMostYCoord;
        $magOfWidth = $this->magnitude*$width/$this->calibrationStick;
		$magOfLength = $this->magnitude*$length/$this->calibrationStick;
		
        $this->squareArea = $magOfLength * $magOfWidth;
		$this->numOfPixelsInSquare = $width*$length;
	}
	
	private function seeWherePointsAre(){
		$firstX = $this->pointInQuestion->getX();
		$firstY = $this->pointInQuestion->getY();		
		$redToAverage = 0;
		$greenToAverage = 0;
		$blueToAverage = 0;
		for ($x=-2; $x<3; $x++){
			for ($y=-2; $y<3; $y++){
				$rgb = imagecolorat($this->image, $firstX + $x, $firstY + $y);
				$redToAverage += ($rgb >> 16) & 0xFF;
				$greenToAverage += ($rgb >> 8) & 0xFF;
				$blueToAverage += ($rgb & 0xFF);
			}
		}
		$redToUse = $redToAverage / 25;
		$greenToUse = $greenToAverage / 25;
		$blueToUse = $blueToAverage / 25;

		
		for ($x=0; $x<= imagesx($this->image) -1; $x++){
			for ($y=0; $y<=imagesy($this->image) - 1; $y++){
				$aPixel = imagecolorat($this->image , $x, $y);
				$red = ($aPixel >> 16) & 0xFF;
				$green = ($aPixel >> 8) & 0xFF;
				$blue =  $aPixel & 0xFF;
 				if($red <= $redToUse + 25 && $red >= $redToUse - 25){
					if($green <= $greenToUse + 25 && $green >= $greenToUse - 25){
						if($blue <= $blueToUse + 25 && $blue >= $blueToUse - 25){
							$this->counter = $this->counter + 1;
							if($x < $this->leftMostXCoord){
								$this->leftMostXCoord = $x;
							}
							if($x > $this->rightMostXCoord){
								$this->rightMostXCoord = $x;
							}
							if($y < $this->topMostYCoord){
								$this->topMostYCoord = $y;
							}
							if($y > $this->bottomMostYCoord){
								$this->bottomMostYCoord = $y;
							}
						}		
					}
				}
			}
		}
	}
}
?>