<?php
//This class is for unit testing purposes only. Basically it has the same code in FileChecker.php

final class FileChecker {
	protected $basename;
	protected $dirname;
	public $file;
	public $max_file_size = 4096; //Default value

    public function __construct($file = null, $max_file_size = null) {
		$this->setFile($file);
		$this->setMaxFileSize($max_file_size);
    }

	protected function setFile($file) {
		if(empty($file)) {
			throw new Exception("Ensure 'file' parameter is defined and not empty");
		}
		$this->file = $file;
	}

	public function getBasename() {
		return $this->basename = basename($this->file);
	}

	public function getDirname() {
		return $this->dirname = dirname($this->file);
	}

	protected function setMaxFileSize($max_file_size) {
		if(empty($max_file_size)) {
			return;
		}
		if(!is_numeric($max_file_size)) {
			throw new InvalidArgumentException("Ensure 'max_file_size' parameter is a valid integer");
		}

		$mfz = (int)$max_file_size;
		if ($mfz < 1) {
			throw new InvalidArgumentException("Ensure 'max_file_size' parameter is a positive integer");
		}
		$this->max_file_size = $mfz;
	}

	public function fileExists($options = null) {
		if (!file_exists($this->file)) {
			if(is_array($options)) {
				if (array_key_exists('throw_error', $options)) {
					if($options['throw_error']) {
						throw new InvalidArgumentException("File: $this->file doesn't exists!");
					}
				} 
			} 
			return false;
		}
		return true;
	}
	
	public function getFileSize() {
		$this->fileExists(array("throw_error" => 1));
		return filesize($this->file);
	}

	public function isFileBlank() {
		if ($this->getFileSize() == 0) {
			return true;
		}
		return false;
	}
	
	public function getMimeType() {
		$this->fileExists(array("throw_error" => 1));
		return mime_content_type( $this->file );
	}

	public function fileLimitExceeded() {
		if ($this->getFileSize() > $this->max_file_size) {
			return true;
		}
		return false;
	}
	
}

?>
