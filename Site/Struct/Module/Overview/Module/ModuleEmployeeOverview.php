<?php
$rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "EmployeeProcess", __FILE__);

//This is the connection to the database using the MedaLib classes.
$rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function EmpAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the add form then execute the process to at those data in the database.
	if(isset($_GET['ProAdd']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddEmployee", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLEmployeeAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
}

function EmpEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the Edit form then execute the process and Edit those data in the database.
	if(isset($_GET['ProEdit']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditEmployee", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLEmployeeEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function EmpDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Execute the process and edit the show flag data in the database.
	ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelEmployee", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

	header("Location:.?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE']['INDEX']), $http_response_header=200);

}

function EmpOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Determine what module has to load from the button that was clicked.(the buttons are - Add, Edit or Delete)
    //WARNING: while add does not require a post method from the server, the Edit and Delete process require POST method to work.
	switch($_GET['Module'])
	{
		case $GLOBALS['MODULE']['ADD']:
			EmpAddStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['EDIT']:
			EmpEditStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['DELETE']:
			EmpDeleteStructSolver($InrConn, $InrLogHandle);
			break;

		default:
			header("Location:.");
			break;
	}
}

//If the module is not set then CompanyOverview from menu was selected, then load the overview.
if(!isset($_GET['Module']))
	ProQueryFunctionCallback($rConn, $rProcessLogHandle, "HTMLEmployeeOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
else
	EmpOverviewStructSolver($rConn, $rProcessLogHandle);

$rProcessLogHandle->WriteToFileAndClear();
?>