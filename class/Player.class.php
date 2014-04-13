<?php

class Player
{
	protected $_name = 'noname';
	protected $_ships = array();

	function __construct(array $kwargs)
	{
		if (array_key_exists('name', $kwargs))
			$this->setName($kwargs['name']);
	}

	function __toString()
	{
		return $this->getName();
	}

	public function addShip(Ship $ship)
	{
		$this->_ships[$ship->getName()] = $ship;
	}

	static public function doc()
	{
		if (file_exists(get_class($this).'.doc.txt'))
			return file_get_contents(get_class($this).'.doc.txt');
		else
			return "Doc not found.\n";
	}

/************************************************
*                    getters                    *
************************************************/

	public function getName()
	{
		return $this->_name;
	}

	public function getShips()
	{
		return $this->_ships;
	}

/************************************************
*                    setters                    *
************************************************/

	public function setName($value)
	{
		$this->_name = $value;
	}

	public function setShips(array $value)
	{
		$this->_ships = $value;
	}
}

?>