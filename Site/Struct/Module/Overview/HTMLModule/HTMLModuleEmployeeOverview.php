<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/EmployeeRetriever.php");

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
	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['CUSTOMER_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "EmployeeQueryDataType()");
	
	//The toolbar for the buttons (tools)
	printf("
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=%d&Module=%d'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='%d'><label>Search by%s</label>
			<label>Query <input id='QueryInput' type='text' name='SearchQuery' value='%s'></label>
			<button>submit</button>
		</form>
	</div>",
	$GLOBALS['MENU']['EMPLOYEE']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['EMPLOYEE']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{
		if(((int) $aDataRow['EMP_DATA_ACCESS']) >= $IniUserAccess)
		{
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div><h5>%s %s</h5></div>
					<div>
						<div><b><p>Email</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Salary</p></b></div>
						<div><p>%s</p></div>
					</div>",
			$aDataRow['EMP_DATA_NAME'],
			$aDataRow['EMP_DATA_SURNAME'],
			$aDataRow['EMP_DATA_EMAIL'],
			$aDataRow['EMP_DATA_SALARY']);

			//If the user has no access to this layer of data then ghost it
			if(((int) $aDataRow['EMP_POS_ACCESS']) >= $IniUserAccess)
			{
			    //Data Row - employee title
				printf("
					<div>
						<div><b><p>Title</p></b></div>
						<div><p>%s</p></div>
					</div>",
					$aDataRow['EMP_POS_TITLE']);
			}

			//Data Row - employee birth day
			printf("
					<div>
						<div><b><p>Birth Day</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Phone Number</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<div><b><p>Stable Number</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<input type='hidden' name='EmpIndex' value='%d'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
					</div>
				</form>
			</div>",
			$aDataRow['EMP_DATA_BDAY'],
			$aDataRow['EMP_DATA_PN'],
			$aDataRow['EMP_DATA_SN'],
			$aDataRow['EMP_ID'],
			$GLOBALS['MENU']['EMPLOYEE']['INDEX'],
			$GLOBALS['MODULE']['DELETE'],
			$GLOBALS['MENU']['EMPLOYEE']['INDEX'],
			$GLOBALS['MODULE']['EDIT']);

		}
	}
}
?>