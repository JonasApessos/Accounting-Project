<?php
function HTMLEmployeeOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	$rEmpListResult = 0;

	//Query to return the a list of employees
	if(!$rEmpListResult = EmployeeOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from Customer Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{
		HTMLEmployeeOverviewDataBlock($rEmpListResult, $InrLogHandle, $IniUserAccess);

		$rEmpListResult->free();
	}
}

function HTMLEmployeeOverviewDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sEmployeeHTML = "";

	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['CUSTOMER_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "EmployeeQueryDataType()");
	
	//The toolbar for the buttons (tools)
	$sEmployeeHTML .= "
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
			<div class='button-left'><p><b>ADD</b></p></div>
		</a>
		<div>
			<form action='.' method='get'>
				<input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
				<label>Query <input id='QueryInput' type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'></label>
				<button class='button-right'><p><b>Search</b></p></button>
			</form>
		</div>
	</div>";

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		if(((int) $aDataRow['EMP_DATA_ACCESS']) >= $IniUserAccess)
		{
			$sEmployeeHTML .= "
			<div class='data-block'>
				<form method='POST'>
					<div><h5>".$aDataRow['EMP_DATA_NAME']." ".$aDataRow['EMP_DATA_SURNAME']."</h5></div>
					<div>
						<div><b><p>Email</p></b></div>
						<div><p>".$aDataRow['EMP_DATA_EMAIL']."</p></div>
					</div>
					<div>
						<div><b><p>Salary</p></b></div>
						<div><p>".number_format($aDataRow['EMP_DATA_SALARY'], 2)." ".$GLOBALS["CURRENCY_SYMBOL"]."</p></div>
					</div>";

			//If the user has no access to this layer of data then ghost it
			if(((int) $aDataRow['EMP_POS_ACCESS']) >= $IniUserAccess)
			{
			    //Data Row - employee title
				$sEmployeeHTML .= "
					<div>
						<div><b><p>Title</p></b></div>
						<div><p>".$aDataRow['EMP_POS_TITLE']."</p></div>
					</div>";
			}

			//Data Row - employee birth day
			$sEmployeeHTML .= "
					<div>
						<div><b><p>Birth Day</p></b></div>
						<div><p>".date("d/m/Y", strtotime($aDataRow['EMP_DATA_BDAY']))."</p></div>
					</div>
					<div>
						<div><b><p>Phone Number</p></b></div>
						<div><p>".$aDataRow['EMP_DATA_PN']."</p></div>
					</div>
					<div>
						<div><b><p>Stable Number</p></b></div>
						<div><p>".$aDataRow['EMP_DATA_SN']."</p></div>
					</div>
					<div>
						<input type='hidden' name='EmpIndex' value='".$aDataRow['EMP_ID']."'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
					</div>
				</form>
			</div>";
		}
	}

	print($sEmployeeHTML);
}
?>