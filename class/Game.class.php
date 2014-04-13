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
	const PHASE_SHIP_SELECT = 'PHASE_SHIP_SELECT';
	const PHASE_COMMAND = 'PHASE_COMMAND';
	const PHASE_MOVE = 'PHASE_MOVE';
	const PHASE_SHOOT = 'PHASE_SHOOT';

	private $_board;
	private $_grid = array();
	private $_players = array();
	private $_current_player;
	private $_opp_player;
	private $_active_ship = null;
	private $_phase = self::PHASE_SHIP_SELECT;
	private $_error = array();

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
		{
			$this->setCurrentPlayer($this->getPlayers()[0]);
			$this->setOppPlayer($this->getPlayers()[1]);
		}
		else
		{
			$this->setCurrentPlayer($this->getPlayers()[1]);
			$this->setOppPlayer($this->getPlayers()[0]);
		}
	}

	public function endTurn()
	{
		if ($this->getCurrentPlayer() == $this->getPlayers()[0])
		{
			$this->setCurrentPlayer($this->getPlayers()[1]);
			$this->setOppPlayer($this->getPlayers()[0]);
		}
		else
		{
			$this->setCurrentPlayer($this->getPlayers()[0]);
			$this->setOppPlayer($this->getPlayers()[1]);
		}
		$this->getActiveShip()->setBonusShield(0);
		$this->getActiveShip()->setBonusWeapon(0);
		$this->getActiveShip()->setBonusSpeed(0);
		$this->setPhase(self::PHASE_SHIP_SELECT);
		$this->setActiveShip();
	}

	public function run()
	{
		if (isset($_POST['activate_ship']))
		{
			$ship = $this->getShipByName($_POST['ship_name']);
			if ($ship)
			{
				$ship->activate();
				$this->setActiveShip($ship);
				$this->setPhase(self::PHASE_COMMAND);
			}
		}
		else if (isset($_POST['command_phase']))
		{
			$bshield = intval($_POST['shield_bonus']);
			$battack = intval($_POST['attack_bonus']);
			$bspeed = intval($_POST['speed_bonus']);
			if ($bshield < 0 || $battack < 0 || $bspeed < 0)
			{
				$this->addError('Booster ces caract c\'est plus fort que de les baisser...');
			}
			if ($bshield + $battack + $bspeed > $this->getActiveShip()->getPower())
			{
				$this->addError('Bien essayer... Mais vous n\'avez que '.$this->getActiveShip()->getPower().' de puissances.');
			}
			if (!$this->getError())
			{
				$this->getActiveShip()->setBonusShield($bshield);
				$this->getActiveShip()->setBonusSpeed($bspeed);
				$this->getActiveShip()->setBonusWeapon($battack);
				$this->getActiveShip()->setLeftMove($this->getActiveShip()->getSpeed() + $bspeed);
				$this->setPhase(self::PHASE_MOVE);
			}
		}
		else if (isset($_POST['move_phase_turn']))
		{
			if (isset($_POST['turn']) && $_POST['turn'] == 'turn_left')
				$this->moveShip($this->getActiveShip(), Ship::MOVE_LEFT);
			else if (isset($_POST['turn']) && $_POST['turn'] == 'turn_right')
				$this->moveShip($this->getActiveShip(), Ship::MOVE_RIGHT);
			$this->getActiveShip()->setCanTurn(false);
			if ($this->getActiveShip()->getLeftMove() == 0 && !$this->getActiveShip()->getCanTurn())
				$this->setPhase(self::PHASE_SHOOT);
		}
		else if (isset($_POST['move_phase_advance']))
		{
			$advance = intval($_POST['advance']);
			if ($advance == 0)
			{
				$this->getActiveShip()->setLeftMove(0);
				$this->setPhase(self::PHASE_SHOOT);
			}
			if ($advance < 0)
				$this->addError('Et non.. Pas de marche arriere...');
			if ($advance > $this->getActiveShip()->getLeftMove())
				$this->addError('Exces de vitesse, tu t\'es fait flashe !');
			$this->moveShip($this->getActiveShip(), Ship::MOVE_UP, $advance);
			if ($this->getActiveShip()->getLeftMove() == 0 && !$this->getActiveShip()->getCanTurn())
				$this->setPhase(self::PHASE_SHOOT);
		}
		else if (isset($_POST['shoot_phase']))
		{
			if ($_POST['shoot_phase'] == 'yes')
				shoot($this->getActiveShip(), $_POST['target_ship']);
			$this->endTurn();
		}
		$this->updateGrid();
	}

	static public function dice($n, $type)
	{
		$r = 0;
		for ($i = 0 ; $i < $n ; $i++)
			$r += rand(1, $type);
		return $r;
	}

	public function moveShip(Ship $ship, $move_type, $value = 0)
	{
		if ($move_type == Ship::MOVE_NO &&
			 ($ship->getPreviousMove() == $ship->getManeuverability() || $ship->getPreviousMove() == 0))
		{
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
		$player = $this->getCurrentPlayer();
		foreach ($player->getShips() as $key => $ship)
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
			if ($target->getShell() <= 0)
				$this->destroyShip($target);
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
				if ($ship->getPosX() + $i > $this->getBoard()->getWidth()
					 ||	$ship->getPosX() + $i < 0
					 || $ship->getPosY() + $j > $this->getBoard()->getHeight()
					 ||	$ship->getPosY() + $j < 0)
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
		foreach ($this->getPlayers() as $player)
		{
			foreach ($player->getShips() as $ship)
			{
				if ($checked_ship->getName() != $ship->getName())
				{
					for ($i = 0 ; $i < $ship->getWidth() ; $i++)
					{
						for ($j = 0 ; $j < $ship->getHeight() ; $j++)
						{
							if ($checked_ship->isShipCoordinate($ship->getPosX() + $i, $ship->getPosY() + $j))
								return $ship;
						}
					}
				}
			}
		}
		return null;
	}

	private function getShipByName($name)
	{
		foreach ($this->getPlayers() as $player)
		{
			foreach ($player->getShips() as $ship)
			{
				if ($name == $ship->getName())
					return $ship;
			}
		}
		return null;
	}

	public function addPlayer(Player $player)
	{
		$this->_players[] = $player;
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
						if ($ship->getOrientation() == 'ORIENTATION_NORTH')
						{
							if ($ship->getPosY() >= $i && $ship->getPosY() - $ship->getWidth() < $i
							&& $ship->getPosX() == $j)
								$grid[$i][$j] = true;
						}
						else if ($ship->getOrientation() == 'ORIENTATION_SOUTH')
						{
							if ($ship->getPosY() <= $i && $ship->getPosY() + $ship->getWidth() > $i
							&& $ship->getPosX() == $j)
								$grid[$i][$j] = true;
						}
						else if ($ship->getOrientation() == 'ORIENTATION_WEST')
						{
							if ($ship->getPosX() >= $j && $ship->getPosX() - $ship->getWidth() < $j
							&& $ship->getPosY() == $i)
								$grid[$i][$j] = true;
						}
						else if ($ship->getOrientation() == 'ORIENTATION_EAST')
						{
							if ($ship->getPosX() <= $j && $ship->getPosX() + $ship->getWidth() > $j
							&& $ship->getPosY() == $i)
								$grid[$i][$j] = true;
						}
					}
				}
			}
		}
		$this->setGrid($grid);
	}

/*	public function updateGrid()
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
*/
	static public function doc()
	{
		if (file_exists(get_class($this).'.doc.txt'))
			return file_get_contents(get_class($this).'.doc.txt');
		else
			return "Doc not found.\n";
	}

	private function addError($error)
	{
		$this->_error[] = $error;
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

	public function setActiveShip(Ship $ship = null)
	{
		$this->_active_ship= $ship;
	}

	public function setPhase($phase)
	{
		$this->_phase= $phase;
	}

	public function setError(array $error)
	{
		$this->_error = $error;
	}

	public function setOppPlayer($p)
	{
		$this->_opp_player = $p;
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

	public function getCurrentPlayer()
	{
		return $this->_current_player;
	}

	public function getOppPlayer()
	{
		return $this->_opp_player;
	}

	public function getActiveShip()
	{
		return $this->_active_ship;
	}

	public function getPhase()
	{
		return $this->_phase;
	}

	public function getError()
	{
		return $this->_error;
	}
}

?>