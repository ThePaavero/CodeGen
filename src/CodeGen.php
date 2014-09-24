<?php namespace ThePaavero\CodeGen;

class CodeGen {

	private $amount;
	private $codeLength;
	private $characters;
	private $file;

	public function __construct()
	{
		$this->codes = [];

		// Defaults
		$this->amount = 200;
		$this->codeLength = 10;
		$this->characters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 1, 2, 3, 4, 5, 6, 7, 9];
		$this->file = 'codes.txt';
	}

	public function setCodeAmount($amount = 100)
	{
		$this->amount = $amount;
	}

	public function setCodeLength($codeLength = 8)
	{
		$this->codeLength = $codeLength;
	}

	public function setCharacters($characters = 100)
	{
		$this->characters = $characters;
	}

	public function setFile($file = 'codes.txt')
	{
		$this->file = $file;
	}

	public function generateAndSave()
	{
		$this->ensureInitials();

		for($i = 0; $i < $this->amount; $i ++)
		{
			$codes[] = $this->generateCode();
		}

		file_put_contents($this->file, implode("\r\n", $codes));
	}

	private function generateCode()
	{
		$code = '';

		for($i = 0; $i < $this->codeLength; $i ++)
		{
			$code .= $this->characters[rand(0, count($this->characters)-1)];
		}

		if(in_array($code, $this->codes))
		{
			// Keep going until we have only unique codes
			return $this->generateCode();
		}

		$this->codes[] = $code;

		return $code;
	}

	private function ensureInitials()
	{
		$errors = $this->getInitialErrors();

		if($errors)
		{
			echo '<h2>Errors:</h2>';
			die(implode('<br>', $errors));
		}
	}

	private function getInitialErrors()
	{
		$errors = [];

		// Make sure our file doesn't exist
		if(file_exists($this->file))
		{
			$errors[] = 'File exists';
		}

		// Create our file
		if( ! touch($this->file))
		{
			$errors[] = 'Could not create file';
		}

		// Make sure we can write to our file
		if( ! is_writable($this->file))
		{
			$errors[] = 'Cannot write to file';
		}

		return empty($errors) ? false : $errors;
	}

}
