<?php
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
	$sCustomerHTML = "";

	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['CUSTOMER_SEARCH_TYPE'], $sSearchTypeSelected);

	//The toolbar for the buttons (tools)
	$sCustomerHTML .= "
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
			<div class='button-left'><p><b>ADD</b></p></div>
		</a>
		<div>
			<form action='.' method='get'>
				<input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['CUSTOMER']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
				<label>Query</label><input type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'>
				<button class='button-right'><p><b>Search</b></p></button>
			</form>
		</div>
	</div>";

	foreach($InrResult as $aDataRow)
	{
		if(((int) $aDataRow['CUST_DATA_ACCESS']) >= $IniUserAccess)
		{
			$sCustomerHTML .= "
			<div class='data-block'>
				<form method='POST'>
					<div><h5>".$aDataRow['CUST_DATA_NAME']." ".$aDataRow['CUST_DATA_SURNAME']."</h5></div>
					<div>
						<div><b><p>Email</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_EMAIL']) ? "None" : $aDataRow['CUST_DATA_EMAIL'])."</p></div>
					</div>
					<div>
						<div><b><p>Phone number</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_PN']) ? "None" : $aDataRow['CUST_DATA_PN'])."</p></div>
					</div>
					<div>
						<div><b><p>Stable number</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_SN']) ? "None" : $aDataRow['CUST_DATA_SN'])."</p></div>
					</div>
					<div>
						<div><b><p>VAT</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_VAT']) ? "None" : $aDataRow['CUST_DATA_VAT'])."</p></div>
					</div>
					<div>
						<div><b><p>Address</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_ADDR']) ? "None" : $aDataRow['CUST_DATA_ADDR'])."</p></div>
					</div>
					<div>
						<div><b><p>Note</p></b></div>
						<div><p>".(empty($aDataRow['CUST_DATA_NOTE']) ? "None" : $aDataRow['CUST_DATA_NOTE'])."</p></div>
					</div>
					<div>
						<input type='hidden' name='CustIndex' value='".$aDataRow['CUST_ID']."'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
					</div>
				</form>
			</div>";
		}
	}

	print($sCustomerHTML);
}
?>
