<?php

class Photo
{
	public $numeroImage;
	public $nomImage;
	public $description;
	
	public function Photo ($numeroImage,$nomImage,$description)
	{
		$this->numeroImage = $numeroImage;
		$this->nomImage = $nomImage;
		$this->description = $description;
	}
}
?>