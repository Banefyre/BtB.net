<?php

class Frigate extends Ship
{
	function __construct(array $kwargs)
	{
		parent::__construct($kwargs);
		$this->setType('Fregate');
		$this->setWidth(4);
		$this->setHeight(4);
		$this->setShell(5);
		$this->setPower(10);
		$this->setManeuverability(4);
		$this->setShield(0);
		$this->setSpeed(10);

		if (array_key_exists('faction', $kwargs))
		{
			if ($kwargs['faction'] == "Human")
				$this->_img = "images/human_1.png";
			else if ($kwargs['faction'] == "Alien")
				$this->_img = "images/alien_1.png";
			else if ($kwargs['faction'] == "Chaos")
				$this->_img = "images/chao_1.png";

		}
	}
}

?>
