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
	$sShareholderHTML = "";

	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['EMPLOYEE_POSITION_SEARCH_TYPE'], $sSearchTypeSelected);

	//The toolbar for the buttons (tools)
	$sShareholderHTML .= "
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
			<label>Query</label><input type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'>
			<button>submit</button>
		</form>
	</div>";

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		$sShareholderHTML .= "
		<div class='data-block'>
			<form method='POST'>
				<div><h5>".$aDataRow['EMP_DATA_NAME']." ".$aDataRow['EMP_DATA_SURNAME']."</h5></div>
				<div>
					<div><b><p>Salary</p></b></div>
					<div><p>".number_format(round($aDataRow['EMP_DATA_SALARY'], 3), 2)." ".$GLOBALS["CURRENCY_SYMBOL"]."</p></div>
				</div>
				<div>
					<div><b><p>Birth Date</p></b></div>
					<div><p>".date("d/m/Y", strtotime($aDataRow['EMP_DATA_BDAY']))."</p></div>
				</div>
				<div>
					<div><b><p>Email</p></b></div>
					<div><p>".$aDataRow['EMP_DATA_EMAIL']."</p></div>
				</div>
				<div>
					<div><b><p>Title</p></b></div>
					<div><p>".$aDataRow['EMP_POS_TITLE']."</p></div>
				</div>
				<div>
					<input type='hidden' name='ShareIndex' value='".$aDataRow['SHARE_ID']."'>
					<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
					<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
				</div>
			</form>
		</div>";
	}

	print($sShareholderHTML);
}
?>
