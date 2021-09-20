<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/CountyRetriever.php");

function HTMLCountyOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	$rCouListResult = 0;

	if(!$rCouListResult = CountyOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from County Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{
		HTMLCountryOverviewDataBlock($rCouListResult, $InrLogHandle, $IniUserAccess);

		$rCouListResult->free();
	}
}

function HTMLCountryOverviewDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COUNTY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CountyQueryDataType()");

	//The toolbar for the buttons (tools)
	printf("
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=%d&Module=%d'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='%d'><label>Search by%s</label>
			<label>Query</label><input id='QueryInput' type='text' name='SearchQuery' value='%s'>
			<button>submit</button>
		</form>
	</div>",
	$GLOBALS['MENU']['COUNTY']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['COUNTY']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		if(((int) $aDataRow['COU_DATA_ACCESS']) >= $IniUserAccess)
		{
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div><h5>%s</h5></div>
					<div>
						<div><b><p>Tax</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Interest Rate</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<input type='hidden' name='CouIndex' value='%d'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
					</div>
				</form>
			</div>",
			$aDataRow['COU_DATA_TITLE'],
			$aDataRow['COU_DATA_TAX'],
			$aDataRow['COU_DATA_IR'],
			$aDataRow['COU_ID'],
			$GLOBALS['MENU']['COUNTY']['INDEX'],
			$GLOBALS['MODULE']['DELETE'],
			$GLOBALS['MENU']['COUNTY']['INDEX'],
			$GLOBALS['MODULE']['EDIT']);
		}
		else
			$InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);
	}
}
?>