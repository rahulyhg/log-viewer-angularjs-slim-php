<?php
use PHPUnit\Framework\TestCase;

class FileCheckerTest extends TestCase {
	protected function setUp() {
		$this->file_not_exist = '/home/user/i_dont_exist.txt';
		$this->dummy_file = 'test.txt';
		$this->blank_file = 'blank_file.txt';
		touch($this->dummy_file);
		touch($this->blank_file);
		$this->file = 'newfile.txt';
		$myfile = fopen($this->file, "w") or die("Unable to open file!");
		$txt = "Mickey Mouse\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	protected function tearDown() {
		unlink($this->dummy_file);
		unlink($this->blank_file);
		unlink($this->file);
	}

	/**
	* @expectedException Exception
	*/
    public function testFileConstructorIsEmpty() {
        $f = new FileChecker();
    }

	public function testFileBasename() {
		$f = new FileChecker('/home/user/test.txt');
		$expected_basename = 'test.txt';
		$this->assertEquals($expected_basename, $f->getBasename());
	}
	
	public function testFileDirname() {
		$f = new FileChecker('/home/user/test.txt');
		$expected_dirname = '/home/user';
		$this->assertEquals($expected_dirname, $f->getDirname());
	}

	/**
	* @expectedException Exception
	*/
    public function testMaxSizeConstructorIsNotValidInteger() {
		$f = new FileChecker($this->dummy_file, 'not_a_valid_integer');
    }
	
	/**
	* @expectedException Exception
	*/
    public function testMaxSizeConstructorIsNotPositiveInteger() {
		$f = new FileChecker($this->dummy_file, '-10');
    }

	public function testFileDoesNotExists() {
		$f = new FileChecker($this->file_not_exist);
		$this->assertFalse($f->fileExists());
	}

	/**
	* @expectedException Exception
	*/
	public function testFileDoesNotExistsThrowError() {
		$f = new FileChecker($this->file_not_exist);
		$f->fileExists(array('throw_error' => 1));
	}

	public function testFileDoesExistParamNotArray() {
		$f = new FileChecker($this->file_not_exist);
		$this->assertFalse($f->fileExists('i_am_not_an_array'));
	}

	public function testFileDoesExistParamDoesntHaveThrowErrorKey() {
		$f = new FileChecker($this->file_not_exist);
		$this->assertFalse($f->fileExists(array('not_throw_error' => 1)));
	}

	public function testFileExist() {
		$f = new FileChecker($this->dummy_file);
		$this->assertTrue($f->fileExists());
	}

	public function testFileBlank() {
		$f = new FileChecker($this->blank_file);
		$this->assertTrue($f->isFileBlank());
	}

	public function testFileIsNotBlank() {
		$f = new FileChecker($this->file);
		$this->assertFalse($f->isFileBlank());
	}

	public function testFileMimeType() {
		$f = new FileChecker($this->file);
		$expectedResult = 'text/plain';
		$this->assertEquals($expectedResult, $f->getMimeType());
	}

	public function testGetFileSize() {
		$f = new FileChecker($this->file);
		$expectedResult = 13;
		$this->assertEquals($expectedResult, $f->getFileSize());
	}

	public function testFileLimitNotExceeded() {
		$f = new FileChecker($this->file);
		$this->assertFalse($f->fileLimitExceeded());
	}
	
	public function testFileLimitExceeded() {
		$max_file_size = '10';
		$f = new FileChecker($this->file, $max_file_size);
		$this->assertTrue($f->fileLimitExceeded());
	}
} 

?>
