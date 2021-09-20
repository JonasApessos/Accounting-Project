<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/CustomerRetriever.php");

function HTMLCustomerOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	$rCustListResult = 0;

	if(!$rCustListResult = CustomerOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from Customer Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{		
		HTMLCustomerOverviewDataBlock($rCustListResult, $InrLogHandle, $IniUserAccess);

		$rCustListResult->free();
	}
}

function HTMLCustomerOverviewDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['CUSTOMER_SEARCH_TYPE'], $sSearchTypeSelected);

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
	$GLOBALS['MENU']['CUSTOMER']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['CUSTOMER']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult as $aDataRow)
	{
		if(((int) $aDataRow['CUST_DATA_ACCESS']) >= $IniUserAccess)
		{
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div>
						<div><h5>%s %s</h5></div>
					<div>
						<div><b><p>Email</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Phone number</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Stable number</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>VAT</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Address</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Note</p></b></div>
						<div><p>%s</p></div></div>
					</div>
					<div>
						<input type='hidden' name='CustIndex' value='%s'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
					</div>
				</form>
			</div>",
			$aDataRow['CUST_DATA_NAME'],
			$aDataRow['CUST_DATA_SURNAME'],
			(empty($aDataRow['CUST_DATA_EMAIL']) ? "None" : $aDataRow['CUST_DATA_EMAIL']),
			(empty($aDataRow['CUST_DATA_PN']) ? "None" : $aDataRow['CUST_DATA_PN']),
			(empty($aDataRow['CUST_DATA_SN']) ? "None" : $aDataRow['CUST_DATA_SN']),
			(empty($aDataRow['CUST_DATA_VAT']) ? "None" : $aDataRow['CUST_DATA_VAT']),
			(empty($aDataRow['CUST_DATA_ADDR']) ? "None" : $aDataRow['CUST_DATA_ADDR']),
			(empty($aDataRow['CUST_DATA_NOTE']) ? "None" : $aDataRow['CUST_DATA_NOTE']),
			$aDataRow['CUST_ID'],
			$GLOBALS['MENU']['CUSTOMER']['INDEX'],
			$GLOBALS['MODULE']['DELETE'],
			$GLOBALS['MENU']['CUSTOMER']['INDEX'],
			$GLOBALS['MODULE']['EDIT']);
		}
	}
}
?>
