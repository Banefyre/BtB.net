<?php

class Board
{
	protected $_width;
	protected $_height;
	protected $_size;

	function __construct(array $kwargs)
	{
		if (array_key_exists('width', $kwargs))
			$this->setWidth($kwargs['width']);
		if (array_key_exists('height', $kwargs))
			$this->setHeight($kwargs['height']);
	}
	
	function __toString()
	{
		return 'Board size : '.$this->getWidth().', '.$this->getHeight();
	}

	public function display(array $grid)
	{
		$this->displayHeader();
		$this->displayBoard($grid);
		$this->displayCommandPanel();
		$this->displayFooter();
	}

	private function displayCommandPanel()
	{
		include('interface/commandPannel.php');
	}

	private function displayBoard(array $grid)
	{
		printf ('<table id="board" >');
		for ($i = 0 ; $i < $this->getHeight() ; $i++)
		{
			printf ('<tr>');
			for ($j = 0 ; $j < $this->getWidth() ; $j++)
			{
				if ($grid[$i][$j])
					printf ('<td style="background-color: red;" ></td>');
				else
					printf ('<td></td>');
			}
			printf ('</tr>');
		}
		printf ('</table>');
	}

	private function displayHeader()
	{
		$t = 'Awesome Starships Battles In The Dark Grim Future Of The Grim Dark 41st Millemium';
		printf ('<!doctype html><html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" >');
		printf ('<script style="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>');
		printf ('<script style="text/javascript" src="js/controller.js"></script>');
		printf ('<link href="css/style.css" rel="stylesheet" type="text/css" >');
		printf ('<title>%s</title></head><body>', $t);
	}

	private function displayFooter()
	{
		printf ('</body><html>');
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

	public function setWidth($value)
	{
		$this->_width = $value;
	}
	
	public function setHeight($value)
	{
		$this->_height = $value;
	}

	public function setGame(Game $value)
	{
		$this->_game = $value;
	}

/************************************************
*                    getters                    *
************************************************/
	
	public function getWidth()
	{
		return $this->_width;
	}
	
	public function getHeight()
	{
		return $this->_height;
	}

	public function getGame()
	{
		return $this->_game;
	}
}

?>
