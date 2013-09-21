<?php
class Point{

	private $xCoord;
	private $yCoord;
	
	function __construct($x,$y){
    $this -> xCoord = $x;
    $this -> yCoord = $y;
	
	}
	
	public function setX($xCoord) {
   	$this->xCoord = $xCoord;
   }
	
	public function setY($yCoord) {
   	$this->yCoord = $yCoord;
   }
	
	public function getX(){
		$toReturn = 0;
		if (isset($xCoord)) {
			$ToReturn = xCoord;
		}
		return $toReturn;
	}
	
	public function getY(){
		$toReturn = 0;
		if (isset($xCoord)) {
			$ToReturn = xCoord;
		}
		return $toReturn;
	}
}
?>
