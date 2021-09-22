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
	$sCountyHTML = "";

	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COUNTY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CountyQueryDataType()");

	//The toolbar for the buttons (tools)
	$sCountyHTML .= "
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['COUNTY']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
			<label>Query</label><input id='QueryInput' type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'>
			<button>submit</button>
		</form>
	</div>";

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		if(((int) $aDataRow['COU_DATA_ACCESS']) >= $IniUserAccess)
		{
			$sCountyHTML .= "
			<div class='data-block'>
				<form method='POST'>
					<div><h5>".$aDataRow['COU_DATA_TITLE']."</h5></div>
					<div>
						<div><b><p>Tax</p></b></div>
						<div><p>".number_format($aDataRow['COU_DATA_TAX'], 2)."%</p></div>
					</div>
					<div>
						<div><b><p>Interest Rate</p></b></div>
						<div><p>".number_format($aDataRow['COU_DATA_IR'], 2)."%</p></div>
					</div>
					<div>
						<input type='hidden' name='CouIndex' value='".$aDataRow['COU_ID']."'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
					</div>
				</form>
			</div>";
		}
		else
			$InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);
	}

	print($sCountyHTML);
}
?>