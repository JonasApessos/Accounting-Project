<?php
class ME_CFileHandle
{
	//Handle instances
	public static $iHandleNum = 0;

	//File handle ID
	private $iHandleID = 0;

	//Stream source file
	private $rFile = 0;

	//File name
	private $sFileName = "";

	//File path
	private $sFilePath = "";

	//File mode
	private $sFileMode = "";

	//Default values
	private $sDefaultFilePath = "Logs";
	private $sDefaultFileName = "FileHandleError.txt";
	private $sDefaultFileMode = "a+";

	//open file method
	protected function OpenFile() : void
	{
		try
		{
			switch($this->sFileMode)
			{
				case "r":
				case "r+":
				case "a":
					{
						if(file_exists(($this->sFilePath . $this->sFileName)))
						{
							$this->rFile = fopen(($this->sFilePath . $this->sFileName), $this->sFileMode);

							if(empty($this->rFile))
								throw new Exception("Failed to open the file - handle ID:" . strval($this->iHandleID));
						}
						else
							throw new Exception("File does not exists - handle ID:" . strval($this->iHandleID));

						break;
					}

				case "a+":
				case "w":
				case "w+":
				case "x":
					{
						if(is_dir($this->sFilePath))
						{
							$this->rFile = fopen(($this->sFilePath . $this->sFileName), $this->sFileMode);

							

							if(!$this->rFile)
								throw new Exception("Failed to open the file - handle ID:" . strval($this->iHandleID));
						}
						else
							throw new Exception("No directory found - handle ID:" . strval($this->iHandleID));

						break;
					}

				default:
					{
						Throw new Exception("File mode is not correct");
					}

				
			}
		}
		catch(Throwable $tExcept)
		{
			if(!is_dir($this->sDefaultFilePath))
				mkdir($this->sDefaultFilePath);

			$rLogSystemErrorFile = fopen($this->sDefaultFilePath . "/" . $this->sDefaultFileName, $this->sDefaultFileMode);

			if(!empty($rLogSystemErrorFile))
			{
				fwrite($rLogSystemErrorFile, "FileHandleInternalError->File: " . $tExcept->getFile(). " Line: " . $tExcept->getLine() . " Message: " . $tExcept->getMessage() . ", Resource: ".$this->rFile."\n");

				fclose($rLogSystemErrorFile);
			}
		}
	}

	//constructor method
	public function __construct(string $InsFileName, string $InsFilePath, string $InsFileMode)
	{
		$this->sFileName = $InsFileName;
		$this->sFilePath = $InsFilePath . "/";
		$this->sFileMode = $InsFileMode;

		$this->iHandleID = ++ME_CFileHandle::$iHandleNum;

		$this->OpenFile();
	}

	//destruct method
	public function __destruct()
	{
		try
		{
			if(!$this->CloseFile())
				throw new Exception("Failed to close the file");
		}
		catch(Throwable $tExcept)
		{
			if(!is_dir($this->sDefaultFilePath))
				mkdir($this->sDefaultFilePath);

			$rLogSystemErrorFile = fopen($this->sDefaultFilePath . "/" . $this->sDefaultFileName, $this->sDefaultFileMode);

			if(!empty($rLogSystemErrorFile))
			{
				fwrite($rLogSystemErrorFile, "FileHandleInternalError->File: " . $tExcept->getFile(). " Line: " . $tExcept->getLine() . " Message: " . $tExcept->getMessage() . ", Resource: ".$this->rFile."\n");

				fclose($rLogSystemErrorFile);
			}
		}

		ME_CFileHandle::$iHandleNum--;

		unset($this->sFileName, $this->sFilePath, $this->sFileMode, $this->sDefaultFileName, $this->sDefaultFilePath, $this->sDefaultFileMode);
	}

	public function CloseFile() : bool
	{
		if(!empty($this->rFile) && is_resource($this->rFile))
		{
			if(fclose($this->rFile))
				return TRUE;
		}
		else
			return TRUE;

		return FALSE;
	}

	public function Write(string $InsData) : void
	{
		fwrite($this->rFile, $InsData);
	}

	public function Read() : string
	{
		return fread($this->rFile, filesize($this->s));
	}

	public function SetFileName(string $InsFileName) : void
	{
		$this->sFileName = $InsFileName;

		$this->CloseFile();

		$this->OpenFile();
	}

	public function SetFilePath(string $InsFilePath) : void
	{
		$this->sFilePath = $InsFilePath . "/";

		$this->CloseFile();

		$this->OpenFile();
	}

	public function SetFileMode(string $InsFileMode) : void
	{
		$this->sFileMode = $InsFileMode;

		$this->CloseFile();

		$this->OpenFile();
	}

	public function GetFileName() : string
	{
		return $this->sFileName;
	}

	public function GetFilePath() : string
	{
		return $this->sFilePath;
	}

	public function GetFileMode() : string
	{
		return $this->sFileMode;
	}
}
?>