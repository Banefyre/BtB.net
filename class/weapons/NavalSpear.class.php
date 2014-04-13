<?php

class NavalSpear extends Weapon
{
	function __construct()
	{
		$this->setName('Naval Spear');
		$this->setLoading(0);
		$this->setRangeShortMin(1);
		$this->setRangeShortMax(30);
		$this->setRangeMiddleMin(31);
		$this->setRangeMiddleMax(60);
		$this->setRangeLongMin(61);
		$this->setRangeLongMax(90);
	}

	public function shoot(Ship $ship, Ship $target)
	{
		if ($ship->getOrientation() == Ship::ORIENTATION_EAST)
		{
			$i = $ship->getX() + $ship->getWidth() + $ship->getRangeShortMin();
			$range = $ship->getX() + $ship->getWidth() + $this->getRangeShortMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_SHORT;
			}
			$i = $ship->getX() + $ship->getWidth() + $ship->getRangeMiddleMin();
			$range = $ship->getX() + $ship->getWidth() + $this->getRangeMiddleMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_MIDDLE;
			}
			$i = $ship->getX() + $ship->getWidth() + $ship->getRangeLongMin();
			$range = $ship->getX() + $ship->getWidth() + $this->getRangeLongMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_LONG;
			}
			return Weapon::HIT_MISS;
		}
		else if ($ship->getOrientation() == Ship::ORIENTATION_WEST)
		{
			$i = $ship->getX() - $ship->getWidth() - $ship->getRangeShortMin();
			$range = $ship->getX() - $ship->getWidth() - $this->getRangeShortMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_SHORT;
			}
			$i = $ship->getX() - $ship->getWidth() - $ship->getRangeMiddleMin();
			$range = $ship->getX() - $ship->getWidth() - $this->getRangeMiddleMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_MIDDLE;
			}
			$i = $ship->getX() - $ship->getWidth() - $ship->getRangeLongMin();
			$range = $ship->getX() - $ship->getWidth() - $this->getRangeLongMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($i, $ship->getY()))
					return Weapon::HIT_LONG;
			}
			return Weapon::HIT_MISS;
		}
		else if ($ship->getOrientation() == Ship::ORIENTATION_SOUTH)
		{
			$i = $ship->getY() + $ship->getHeight() + $ship->getRangeShortMin();
			$range = $ship->getY() + $ship->getHeight() + $ship->getRangeShortMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_SHORT;
			}
			$i = $ship->getY() + $ship->getHeight() + $ship->getRangeMiddleMin();
			$range = $ship->getY() + $ship->getHeight() + $ship->getRangeMiddleMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_MIDDLE;
			}
			$i = $ship->getY() + $ship->getHeight() + $ship->getRangeLongMin();
			$range = $ship->getY() + $ship->getHeight() + $ship->getRangeLongMax();
			for ($i ; $i <= $range ; $i++)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_LONG;
			}
			return Weapon::HIT_MISS;
		}
		else if ($ship->getOrientation() == Ship::ORIENTATION_WEST)
		{
			$i = $ship->getY() - $ship->getWidth() - $ship->getRangeShortMin();
			$range = $ship->getY() - $ship->getWidth() - $this->getRangeShortMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_SHORT;
			}
			$i = $ship->getY() - $ship->getWidth() - $ship->getRangeMiddleMin();
			$range = $ship->getY() - $ship->getWidth() - $this->getRangeMiddleMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_MIDDLE;
			}
			$i = $ship->getY() - $ship->getWidth() - $ship->getRangeLongMin();
			$range = $ship->getY() - $ship->getWidth() - $this->getRangeLongMax();
			for ($i ; $i <= $range ; $i--)
			{
				if ($target->isShipCoordinate($ship->getX(), $i))
					return Weapon::HIT_LONG;
			}
			return Weapon::HIT_MISS;
		}
		return Weapon::HIT_MISS;
	}
}

?>