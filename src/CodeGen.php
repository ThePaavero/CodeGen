<?php namespace ThePaavero\CodeGen;

class CodeGen {

	private $config;
	private $codes;

	public function __construct($config)
	{
		$this->codes = [];
		$this->config = $config;

		$required_config_keys = [
			'amount',
			'codeLength',
			'characters',
			'file'
		];

		foreach($required_config_keys as $key)
		{
			if( ! isset($this->config[$key]))
			{
				throw new \Exception('Config value "' . $key . '" not set.', 1);

			}
		}
	}

	public function generateAndSave()
	{
		$this->ensureInitials();

		for($i = 0; $i < $this->config['amount']; $i ++)
		{
			$codes[] = $this->generateCode();
		}

		file_put_contents($this->config['file'], implode("\r\n", $codes));
	}

	private function generateCode()
	{
		$code = '';

		for($i = 0; $i < $this->config['codeLength']; $i ++)
		{
			$code .= $this->config['characters'][rand(0, count($this->config['characters'])-1)];
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
			throw new \Exception(implode('<br>', $errors), 1);
		}
	}

	private function getInitialErrors()
	{
		$errors = [];

		// Make sure our file doesn't exist
		if(file_exists($this->config['file']))
		{
			$errors[] = 'File exists';
		}

		// Create our file
		if( ! touch($this->config['file']))
		{
			$errors[] = 'Could not create file';
		}

		// Make sure we can write to our file
		if( ! is_writable($this->config['file']))
		{
			$errors[] = 'Cannot write to file';
		}

		return empty($errors) ? false : $errors;
	}

}
