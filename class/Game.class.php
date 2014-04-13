<?php

require_once('Board.class.php');
require_once('Player.class.php');
require_once('ships/Ship.class.php');
require_once('ships/Frigate.class.php');
require_once('weapons/Weapon.class.php');
require_once('weapons/NavalSpear.class.php');

class Game
{
	const DFLT_BOARD_WIDTH = 150;
	const DFLT_BOARD_HEIGHT = 100;

	private $_board;
	private $_grid = array();
	private $_players = array();
	private $_current_player;

	function __construct(array $kwargs)
	{
		$w = (array_key_exists('width', $kwargs) ? $kwargs['width'] : self::DFLT_BOARD_WIDTH);
		$h = (array_key_exists('height', $kwargs) ? $kwargs['height'] : self::DFLT_BOARD_HEIGHT);
		$this->setBoard(new Board(array('game' => $this, 'width' => $w, 'height' => $h)));
	}

	function __toString()
	{
		$str = $this->getBoard()."\n";
		foreach ($this->getPlayers() as $player)
		{
			$str .= sprintf("Le joueur '%s' possede les vaisseaux suivants :\n", $player);
			foreach ($player->getShips() as $ship)
			{
				$str .= sprintf("\t(%3d;%3d) '%s' du type '%s', armee de : \n",
					$ship->getPosX(), $ship->getPosY(), $ship, $ship->getType());
				$str .= sprintf("\t\t- %s\n", $ship->getWeapon()->getName());
			}
		}
		return $str;
	}

	public function init()
	{
		if (self::dice(1, 2) == 1)
			$this->setCurrentPlayer($this->getPlayers()['Timmy']);
		else
			$this->setCurrentPlayer($this->getPlayers()['Hodor']);
	}

	public function endTurn()
	{
		if ($this->getCurrentPlayer() == $this->getPlayers()[0])
			$this->setCurrentPlayer($this->getPlayers()[1]);
		else
			$this->setCurrentPlayer($this->getPlayers()[1]);
	}

	public function run()
	{
		// traitement du formulaire, realisation des action

		// update grid and display it
		$this->updateGrid();
		$this->getBoard()->display($this->getGrid());
	}

	static public function dice($n, $type)
	{
		$r = 0;
		for ($i = 0 ; $i < $n ; $i++)
			$r += rand(1, $type);
		return $r;
	}

	public function moveShip(Ship $ship, $move_type, $value = 0, $free_move_type = '')
	{
		if ($move_type == Ship::MOVE_NO &&
			 ($ship->getPreviousMove() == $ship->getManeuverability() || $ship->getPreviousMove() == 0))
		{
			if ($free_move_type != '')
				$ship->rotate($free_move_type);
			$ship->setLeftMove(0);
			$ship->setPreviousMove(0);
			if ($this->isOutBoard($ship))
				$this->destroyShip($ship);
		}
		else if ($move_type == Ship::MOVE_UP)
		{
			if (($value >= $ship->getManeuverability() || !$ship->getPreviousMove()) 
				&& $value <= $ship->getLeftMove())
			{
				for ($i = 0; $i < $value ; $i++)
				{
					$ship->moveUp();;
					if ($this->isOutBoard($ship))
						$this->destroyShip($ship);
					if ($i >= $ship->getManeuverability())
						$ship->setCanTurn(true);
					if (($col_ship = $this->checkCollision($ship)))
						$this->eperonnage($ship, $col_ship);
				}
			}
		}
		else if (($move_type == Ship::MOVE_RIGHT || $move_type == Ship::MOVE_LEFT)
			&& $ship->getCanTurn())
		{
			$ship->rotate($move_type);
			if ($this->isOutBoard($ship))
				$this->destroyShip($ship);
			if (($col_ship = $this->checkCollision($ship)))
				$this->eperonnage($ship, $col_ship);
		}
	}

	private function destroyShip(Ship $to_destroy_ship)
	{
		$player = $this->getCurrentPLayer();
		foreach ($player->getShip() as $key => $ship)
		{
			if ($to_destroy_ship == $ship)
				unset($this->_ship[$key]);
		}
	}

	public function shoot(Ship $ship, Ship $target)
	{
		if ($ship->getWeapon()->getLoading() > 0)
		{
			// determiner si ligne de vue
			$hit_range = $ship->getWeapon()->shoot($ship, $target);
			if (hit_range == Weapon::HIT_MISS)
				return;
			else if (hit_range == Weapon::HIT_SHORT)
				$success_value = 4;
			else if (hit_range == Weapon::HIT_MIDDLE)
				$success_value = 5;
			else if (hit_range == Weapon::HIT_MIDDLE)
				$success_value = 6;
			$success = $this->rollShootDice($ship->getWeapon()->getLoading() + $ship->getBonusWeapon(),
						$success_value);
			$target->takeDamage($success);
		}
	}

	private function rollShootDice($n_dice, $hit_value)
	{
		$success = 0;
		for ($i = 0 ; $i < $n_dice ; $i++)
		{
			if (rand(1, 6) >= $hit_value)
				$success++;
		}
		return $success;
	}

	private function isOutBoard(Ship $ship)
	{
		for ($i = 0 ; $i < $ship->getWidth() ; $i++)
		{
			for ($j = 0 ; $j < $ship->getHeight() ; $j++)
			{
				if ($ship->getX() + $i > $this->getBoard()->getWidth()
					 ||	$ship->getX() + $i < 0
					 || $ship->getY() + $j > $this->getBoard()->getHeight()
					 ||	$ship->getY() + $j < 0)
				{
					return true;
				}
			}
		}
		return false;
	}

	private function eperonnage(Ship $active_ship, Ship $col_ship)
	{
		if ($active_ship->getSpeed() + $active_ship->getBonusSpeed()
			 - $active_ship->getLeftMove() > $active_ship->getManeuverability())
		{
			$active_ship->takeDamage($col_ship->getShell());
			$col_ship->takeDamage($active_ship->getShell());
		}
		$active_ship->setLeftMove(0);
		$active_ship->setPreviousMove(0);
	}

	public function checkCollision(Ship $checked_ship)
	{
		foreach ($this>getPlayers() as $player)
		{
			foreach ($player->getShip() as $ship)
			{
				for ($i = 0 ; $i < $ship->getWidth() ; $i++)
				{
					for ($j = 0 ; $j < $ship->getHeight() ; $j++)
					{
						if ($checked_ship->isShipCoordinate($ship->getX() + $i, $ship->getY() + $j))
							return $ship;
					}
				}
			}
		}
		return null;
	}

	public function getShipByName($name)
	{
		foreach ($this>getPlayers() as $player)
		{
			foreach ($player->getShip() as $ship)
			{
				if ($name = $ship->getName())
					return $ship;
			}
		}
		return null;
	}

	public function addPlayer(Player $player)
	{
		$this->_players[$player->getName()] = $player;
	}

	public function updateGrid()
	{
		$grid = array();
		for ($i = 0 ; $i < $this->getBoard()->getHeight() ; $i++)
		{
			$grid[$i] = array();
			for ($j = 0 ; $j < $this->getBoard()->getWidth() ; $j++)
			{
				$grid[$i][$j] = false;
				foreach ($this->getPlayers() as $player)
				{
					foreach ($player->getShips() as $ship)
					{
						if ($ship->getPosX() <= $j && $ship->getPosX() + $ship->getWidth() > $j
							&& $ship->getPosY() == $i)
							$grid[$i][$j] = true;
					}
				}
			}
		}
		$this->setGrid($grid);
	}

	static public function doc()
	{
		if (file_exists(get_class($this).'.doc.txt'))
			return file_get_contents(get_class($this).'.doc.txt');
		else
			return "Doc not found.\n";
	}

/************************************************
*                    setters                    *
************************************************/

	public function setBoard(Board $board)
	{
		$this->_board = $board;
	}

	public function setPlayers(array $players)
	{
		$this->_players = $players;
	}

	public function setGrid(array $grid)
	{
		$this->_grid = $grid;
	}

	public function setCurrentPlayer(Player $player)
	{
		$this->_current_player= $player;
	}

/************************************************
*                    getters                    *
************************************************/

	public function getBoard()
	{
		return $this->_board;
	}

	public function getPlayers()
	{
		return $this->_players;
	}

	public function getGrid()
	{
		return $this->_grid;
	}

	public function getCurrentPLayer()
	{
		return $this->_current_player;
	}
}

?>
