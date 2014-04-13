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
