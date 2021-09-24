<?php
$rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "EmployeePositionProcess", __FILE__);

//This is the connection to the database using the MedaLib classes.
$rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function EmpPosAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the add form then execute the process to at those data in the database.
	if(isset($_GET['ProAdd']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddEmployeePosition", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLEmployeePositionAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
}

function EmpPosEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//If the form was completed from the Edit form then execute the process and Edit those data in the database.
	if(isset($_GET['ProEdit']))
	{
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditEmployeePosition", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

		header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']), $http_response_header=200);
	}
	else
		ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLEmployeePositionEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function EmpPosDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Execute the process and edit the show flag data in the database.
	ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelEmployeePosition", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

	header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']), $http_response_header=200);
}

function EmpPosOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
	//Determine what module has to load from the button that was clicked.(the buttons are - Add, Edit or Delete)
    //WARNING: while add does not require a post method from the server, the Edit and Delete process require POST method to work.
	switch($_GET['Module'])
	{
		case $GLOBALS['MODULE']['ADD']:
			EmpPosAddStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['EDIT']:
			EmpPosEditStructSolver($InrConn, $InrLogHandle);
			break;

		case $GLOBALS['MODULE']['DELETE']:
			EmpPosDeleteStructSolver($InrConn, $InrLogHandle);
			break;

		default:
			header("Location:.");
			break;
	}
}


//If the module is not set then CompanyOverview from menu was selected, then load the overview.
if(!isset($_GET['Module']))
	ProQueryFunctionCallback($rConn, $rProcessLogHandle, "HTMLEmployeePositionOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
else
	EmpPosOverviewStructSolver($rConn, $rProcessLogHandle);

$rProcessLogHandle->WriteToFileAndClear();
?>