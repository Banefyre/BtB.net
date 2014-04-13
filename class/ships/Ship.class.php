<?php

abstract class Ship
{
	const ORIENTATION_WEST = 'ORIENTATION_WEST';
	const ORIENTATION_SOUTH = 'ORIENTATION_SOUTH';
	const ORIENTATION_NORTH = 'ORIENTATION_NORTH';
	const ORIENTATION_EAST = 'ORIENTATION_EAST';
	const MOVE_RIGHT = 'MOVE_RIGHT';
	const MOVE_LEFT = 'MOVE_LEFT';
	const MOVE_UP = 'MOVE_UP';
	const MOVE_NO = 'MOVE_NO';

	protected $_name = 'noname';
	protected $_type = '';
	protected $_width = 1;
	protected $_height = 1;
	protected $_shell = 0;
	protected $_power = 0;
	protected $_speed = 0;
	protected $_maneuverability = 0;
	protected $_shield = 0;
	protected $_weapons;
	protected $_pos_x = 0;
	protected $_pos_y = 0;
	protected $_orientation = '';
	protected $_bonus_speed = 0;
	protected $_bonus_shield = 0;
	protected $_bonus_weapon;
	protected $_previous_move = 0;
	protected $_left_move = 0;
	protected $_can_turn = false;

	function __construct(array $kwargs)
	{
		if (array_key_exists('name', $kwargs))
			$this->setName($kwargs['name']);
		if (array_key_exists('weapons', $kwargs))
		{
			foreach ($kwargs['weapons'] as $weapon)
				$this->addWeapon($weapon);
		}
	}

	function __toString()
	{
		return $this->getName();
	}

	public function takeDamage($value)
	{
		$reduce_dommage = $value - ($this->getShield() + $this->getBonusShield());
		if ($reduce_dommage > 0)
			$this->setShell($this->getShell() - $reduce_dommage);
	}

	public function isShipCoordinate($x, $y)
	{
		for ($i = 0 ; $i < $this->getWidth() ; $i++)
		{
			for ($j = 0 ; $j < $this->getHeight() ; $j++)
			{
				if ($this->getX() + $i == $x &&	$this->getY() + $j == $y)
					return true;
			}
		}
		return false;
	}

	public function addWeapon(Weapon $weapon)
	{
		$this->_weapons[$weapon->getName()] = $weapon;
	}

	public function activate()
	{
		$this->setLeftMove($this->getSpeed());
		if (!$this->getPreviousMove)
			$this->setCanTurn(true);

	}

	public function moveUp()
	{
		if ($this->getOrientation() == self::SOUTH)
			$this->setY($this->getY() + 1);
		else if ($this->getOrientation() == self::WEST)
			$this->setX($this->getX() - 1);
		else if ($this->getOrientation() == self::NORTH)
			$this->setY($this->getY() - 1);
		else if ($this->getOrientation() == self::EAST)
			$this->setX($this->getX() + 1);
		$this->setLeftMove($this->getLeftMove() - 1);
		$this->setPreviousMove($this->getPreviousMove() + 1);
	}

	public function rotate($way)
	{
		if ($way == self::MOVE_RIGHT)
		{
			if ($this->getOrientation() == self::SOUTH)
				$this->setOrientation(self::WEST);
			else if ($this->getOrientation() == self::WEST)
				$this->setOrientation(self::NORTH);
			else if ($this->getOrientation() == self::NORTH)
				$this->setOrientation(self::EAST);
			else if ($this->getOrientation() == self::EAST)
				$this->setOrientation(self::SOUTH);
		}
		else if ($way == self::MOVE_LEFT)
		{
			if ($this->getOrientation() == self::SOUTH)
				$this->setOrientation(self::EAST);
			else if ($this->getOrientation() == self::EAST)
				$this->setOrientation(self::NORTH);
			else if ($this->getOrientation() == self::NORTH)
				$this->setOrientation(self::WEST);
			else if ($this->getOrientation() == self::WEST)
				$this->setOrientation(self::SOUTH);
		}
		$this->setCanTurn(false);
		return true;
	}

	public function setPos($x, $y, $orientation = '')
	{
		$this->setPosX($x);
		$this->setPosY($y);
		if ($orientation != '')
			$this->setOrientation($orientation);
	}

	public function isStationary()
	{
		return $this->getPreviousMove();
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

	public function getType()
	{
		return $this->_type;
	}

	public function getWidth()
	{
		return $this->_width;
	}

	public function getHeight()
	{
		return $this->_height;
	}

	public function getShell()
	{
		return $this->_shell;
	}

	public function getPower()
	{
		return $this->_power;
	}

	public function getSpeed()
	{
		return $this->_speed;
	}

	public function getManeuverability()
	{
		return $this->_maneuverability;
	}

	public function getShield()
	{
		return $this->_shield;
	}

	public function getWeapons()
	{
		return $this->_weapons;
	}

	public function getPosX()
	{
		return $this->_pos_x;
	}

	public function getPosY()
	{
		return $this->_pos_y;
	}

	public function getOrientation()
	{
		return $this->_orientation;
	}

	public function getBonusShield()
	{
		return $this->_bonus_shield;
	}

	public function getBonusWeapon()
	{
		return $this->_bonus_weapon;
	}

	public function getBonusSpeed()
	{
		return $this->_bonus_speed;
	}

	public function getPreviousMove()
	{
		return $this->_previous_move;
	}

	public function getLeftMove()
	{
		return $this->_left_move;
	}

	public function getCanTurn()
	{
		return $this->_can_turn;
	}

/************************************************
*                    setters                    *
************************************************/

	public function setName($value)
	{
		$this->_name = $value;
	}

	public function setType($value)
	{
		$this->_type = $value;
	}

	public function setWidth($value)
	{
		$this->_width = $value;
	}

	public function setHeight($value)
	{
		$this->_height = $value;
	}

	public function setShell($value)
	{
		$this->_shell = $value;
	}

	public function setPower($value)
	{
		$this->_power = $value;
	}

	public function setSpeed($value)
	{
		$this->_speed = $value;
	}

	public function setManeuverability($value)
	{
		$this->_maneuverability = $value;
	}

	public function setShield($value)
	{
		$this->_shield = $value;
	}

	public function setWeapons($value)
	{
		$this->_weapons = $value;
	}

	public function setPosX($value)
	{
		$this->_pos_x = $value;
	}

	public function setPosY($value)
	{
		$this->_pos_y = $value;
	}

	public function setOrientation($value)
	{
		$this->_orientation = $value;
	}

	public function setBonusWeapon($value)
	{
		$this->_bonus_weapon = $value;
	}

	public function setBonusShield($value)
	{
		$this->_bonus_shield = $value;
	}

	public function setBonusSpeed($value)
	{
		$this->_bonus_speed = $value;
	}

	public function setPreviousMove($value)
	{
		$this->_previous_move = $value;
	}

	public function setLeftMove($value)
	{
		$this->_left_move = $value;
	}

	public function setCanTurn($value)
	{
		$this->_can_turn = $value;
	}
}

?>