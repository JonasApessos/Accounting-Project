<?php
$rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "JobProcess", __FILE__);

//This is the connection to the database using the MedaLib classes.
$rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function JobPITAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the add form then execute the process to at those data in the database.
	if(isset($_GET['ProAdd']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddJobPit", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLJobPitAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function JobPITEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the Edit form then execute the process and Edit those data in the database.
	if(isset($_GET['ProEdit']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditJobPIT", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLJobPITEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function JobPITDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Execute the process and edit the show flag data in the database.
	ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelJobPIT", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

	header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
}

function JobPITOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	switch($_GET['SubModule'])
	{
		case $GLOBALS['MODULE']['ADD']:
			JobPITAddStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['EDIT']:
			JobPITEditStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['DELETE']:
			JobPITDeleteStructSolver($InrConn, $InrLogHandle);
			break;
	}
}

function JobAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the add form then execute the process to at those data in the database.
	if(isset($_GET['ProAdd']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddJob", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLJobAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
}

function JobEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the Edit form then execute the process and Edit those data in the database.
	if(isset($_GET['ProEdit']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditJob", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLJobEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

}

function JobDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Execute the process and edit the show flag data in the database.
	ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelJob", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

	header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['JOB']['INDEX']), $http_response_header=200);
}

function JobOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Determine what module has to load from the button that was clicked.(the buttons are - Add, Edit or Delete)
    //WARNING: while add does not require a post method from the server, the Edit and Delete process require POST method to work.
	switch($_GET['Module'])
	{
		case $GLOBALS['MODULE']['ADD']:
		{
			JobAddStructSolver($InrConn, $InrLogHandle);

			break;
		}
		case $GLOBALS['MODULE']['EDIT']:
		{
			JobEditStructSolver($InrConn, $InrLogHandle);

			break;
		}
		case $GLOBALS['MODULE']['DELETE']:
		{
			JobDeleteStructSolver($InrConn, $InrLogHandle);

			break;
		}
		case $GLOBALS['MODULE']['EXTEND']:
		{
			if(!isset($_GET['SubModule']))
			{
				require_once("Output/Retriever/JobRetriever.php");

				ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLJobPITOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
			}
			else
				JobPITOverviewStructSolver($InrConn, $InrLogHandle);

			break;
		}
		default:
		{
			header("Location:.");

			break;
		}
	}
}

//If the module is not set then CompanyOverview from menu was selected, then load the overview.
if(!isset($_GET['Module']))
	ProQueryFunctionCallback($rConn, $rProcessLogHandle, "HTMLJobOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
else
	JobOverviewStructSolver($rConn, $rProcessLogHandle);

$rProcessLogHandle->WriteToFileAndClear();
?>
