<?php

abstract class Weapon
{
	const HIT_MISS = 'HIT_MISS';
	const HIT_SHORT = 'HIT_SHORT';
	const HIT_MIDDLE = 'HIT_MIDDLE';
	const HIT_LONG = 'HIT_LONG';

	protected $_name = 'noname';
	protected $_loading = 0;
	protected $_range_short_min = 0;
	protected $_range_short_max = 0;
	protected $_range_middle_min = 0;
	protected $_range_middle_max = 0;
	protected $_range_long_min = 0;
	protected $_range_long_max = 0;
	protected $_area_effect;
	
	function __toString()
	{
		return $this->getName();
	}

	abstract function shoot(Ship $ship, Ship $target);


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

	public function getLoading()
	{
		return $this->_loading;
	}

	public function getRangeShortMin()
	{
		return $this->_range_short_min;
	}

	public function getRangeShortMax()
	{
		return $this->_range_short_max;
	}

	public function getRangeMiddleMin()
	{
		return $this->_range_middle_min;
	}

	public function getRangeMiddleMax()
	{
		return $this->_range_middle_max;
	}

	public function getRangeLongMin()
	{
		return $this->_range_long_min;
	}

	public function getRangeLongMax()
	{
		return $this->_range_long_max;
	}

	public function getAreaEffect()
	{
		return $this->_area_effect;
	}

/************************************************
*                    setters                    *
************************************************/

	public function setName($value)
	{
		$this->_name = $value;
	}

	public function setLoading($value)
	{
		$this->_loading = $value;
	}

	public function setRangeShortMin($value)
	{
		$this->_range_short_min = $value;
	}

	public function setRangeShortMax($value)
	{
		$this->_range_short_max = $value;
	}

	public function setRangeMiddleMin($value)
	{
		$this->_range_middle_min = $value;
	}

	public function setRangeMiddleMax($value)
	{
		$this->_range_middle_max = $value;
	}

	public function setRangeLongMin($value)
	{
		$this->_range_long_min = $value;
	}

	public function setRangeLongMax($value)
	{
		$this->_range_long_max = $value;
	}

	public function setAreaEffect($value)
	{
		$this->_area_effect = $value;
	}
}

?>