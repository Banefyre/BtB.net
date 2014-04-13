<?php

class Frigate extends Ship
{
	function __construct(array $kwargs)
	{
		parent::__construct($kwargs);
		$this->setType('Fregate');
		$this->setWidth(4);
		$this->setHeight(1);
		$this->setShell(5);
		$this->setPower(10);
		$this->setManeuverability(4);
		$this->setShield(0);
	}
}

?>