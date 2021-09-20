<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/EmployeeRetriever.php");

function HTMLEmployeePositionOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	$rEmpPosListResult = 0;

	if(!$rEmpPosListResult = EmployeePositionOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from Customer Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{
		HTMLEmployeePositionOverviewDataBlock($rEmpPosListResult, $InrLogHandle, $IniUserAccess);

		$rEmpPosListResult->free();
	}
}

function HTMLEmployeePositionOverviewDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['EMPLOYEE_POSITION_SEARCH_TYPE'], $sSearchTypeSelected);

	//The toolbar for the buttons (tools)
	printf("
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=%d&Module=%d'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='%d'><label>Search by%s</label>
			<label>Query</label><input type='text' name='SearchQuery' value='%s'>
			<button>submit</button>
		</form>
	</div>",
	$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		if(((int) $aDataRow['EMP_POS_ACCESS'] >= $IniUserAccess))
		{
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div><h5>%s</h5></div>
					<div>
						<input type='hidden' name='EmpPosIndex' value='%d'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
					</div>
				</form>
			</div>",
			$aDataRow['EMP_POS_TITLE'],
			$aDataRow['EMP_POS_ID'],
			$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
			$GLOBALS['MODULE']['DELETE'],
			$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
			$GLOBALS['MODULE']['EDIT']);
		}
	}
}
?>