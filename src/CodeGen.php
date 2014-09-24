<?php namespace ThePaavero\CodeGen;

/**
 * CodeGen
 *
 * Creates certain amount of unique codes with certain amount of characters.
 *
 * @author Pekka S. <nospam@astudios.org>
 * @link   https://github.com/ThePaavero/CodeGen
 */
class CodeGen {

	public $newline;

	private $config;
	private $codes;
	private $append;

	/**
	 * Constructor
	 *
	 * @param array $config Must include all keys as seen in $required_config_keys
	 */
	public function __construct($config)
	{
		$this->codes = [];

		// The following config keys are optional because they have a default
		$this->append = isset($config['append']) ? $config['append'] : false;
		$this->newline = isset($config['newline']) ? $config['newline'] : "\r\n";

		$this->config = $config;

		// These config keys are mandatory because we don't want to guess their
		// intended values.
		$required_config_keys = [
			'amount',
			'codeLength',
			'characters',
			'file'
		];

		// Make sure we have all mandatory config values set
		foreach($required_config_keys as $key)
		{
			if( ! isset($this->config[$key]))
			{
				throw new \Exception('Config value "' . $key . '" not set.', 1);
			}
		}

		// If we're appending to an existing list of codes, pull that list
		// into our codes array in order to avoid duplicates.
		if($this->append === true && file_exists($this->config['file']))
		{
			$this->codes = file($this->config['file']);
		}
	}

	/**
	 * Generate our codes and save them to given file
	 *
	 * @return null
	 */
	public function generateAndSave()
	{
		$this->ensureInitials();

		for($i = 0; $i < $this->config['amount']; $i ++)
		{
			$codes[] = $this->generateCode();
		}

		file_put_contents($this->config['file'], implode($this->newline, $codes) . $this->newline, FILE_APPEND);
	}

	/**
	 * Generate random string
	 *
	 * @return string
	 */
	private function generateCode()
	{
		$code = '';

		for($i = 0; $i < $this->config['codeLength']; $i ++)
		{
			$code .= $this->config['characters'][rand(0, count($this->config['characters'])-1)];
		}

		// Making sure there won't be any duplicates
		if(in_array($code, $this->codes))
		{
			// Keep going until we have only unique codes
			return $this->generateCode();
		}

		$this->codes[] = $code;

		return $code;
	}

	/**
	 * Do a preliminary check
	 *
	 * @return null
	 */
	private function ensureInitials()
	{
		$errors = $this->getInitialErrors();

		if($errors)
		{
			throw new \Exception(implode('<br>', $errors), 1);
		}
	}

	/**
	 * Gather problems into an array
	 *
	 * @return array
	 */
	private function getInitialErrors()
	{
		$errors = [];

		// Make sure our file doesn't exist (unless we're appending)
		if(file_exists($this->config['file']) && ! $this->append)
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
