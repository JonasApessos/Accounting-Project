<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");

function HTMLShareholderOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess)
{
	$rResult = 0;

	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	if(!$rResult = ShareholderOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from shareholder list Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{
		HTMLShareholderDataBlock($rResult, $InrLogHandle, $IniUserAccess);

		$rResult->free();
	}
	
}

function HTMLShareholderDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
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
	$GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		printf("
		<div class='data-block'>
			<form method='POST'>
				<div><h5>%s %s</h5></div>
				<div>
					<div><b><p>Salary</p></b></div>
					<div><p>%f</p></div>
				</div>
				<div>
					<div><b><p>Birth Date</p></b></div>
					<div><p>%s</p></div>
				</div>
				<div>
					<div><b><p>Email</p></b></div>
					<div><p>%s</p></div>
				</div>
				<div>
					<div><b><p>Title</p></b></div>
					<div><p>%s</p></div>
				</div>
				<div>
					<input type='hidden' name='ShareIndex' value='%d'>
					<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
					<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
				</div>
			</form>
		</div>",
		$aDataRow['EMP_DATA_NAME'],
		$aDataRow['EMP_DATA_SURNAME'],
		$aDataRow['EMP_DATA_SALARY'],
		$aDataRow['EMP_DATA_BDAY'],
		$aDataRow['EMP_DATA_EMAIL'],
		$aDataRow['EMP_POS_TITLE'],
		$aDataRow['SHARE_ID'],
		$GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
		$GLOBALS['MODULE']['DELETE'],
		$GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
		$GLOBALS['MODULE']['EDIT']);
	}
}
?>
