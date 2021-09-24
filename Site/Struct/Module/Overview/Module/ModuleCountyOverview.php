<?php
$rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "CountyProcess", __FILE__);

//This is the connection to the database using the MedaLib classes.
$rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function CouAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the add form then execute the process to at those data in the database.
	if(isset($_GET['ProAdd']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddCounty", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['COUNTY']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLCountyAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
}

function CouEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the Edit form then execute the process and Edit those data in the database.
	if(isset($_GET['ProEdit']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditCounty", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['COUNTY']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLCountyEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function CouDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Execute the process and edit the show flag data in the database.
	ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelCounty", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

	header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['COUNTY']['INDEX']), $http_response_header=200);
}

function CouOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Determine what module has to load from the button that was clicked.(the buttons are - Add, Edit or Delete)
    //WARNING: while add does not require a post method from the server, the Edit and Delete process require POST method to work.
	switch($_GET['Module'])
	{
		case $GLOBALS['MODULE']['ADD']:
		{
			CouAddStructSolver($InrConn, $InrLogHandle);

			break;
		}
		case $GLOBALS['MODULE']['EDIT']:
		{
			CouEditStructSolver($InrConn, $InrLogHandle);

			break;
		}
		case $GLOBALS['MODULE']['DELETE']:
		{
			CouDeleteStructSolver($InrConn, $InrLogHandle);

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
	ProQueryFunctionCallback($rConn, $rProcessLogHandle, "HTMLCountyOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
else
	CouOverviewStructSolver($rConn, $rProcessLogHandle);

$rProcessLogHandle->WriteToFileAndClear();
?>