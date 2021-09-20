<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");

function HTMLJobPITOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	if(isset($_POST['JobIndex']) && !empty($_POST['JobIndex']) && is_numeric($_POST['JobIndex']))
	{
		$iJobIndex = (int) $_POST['JobIndex'];

		$rResult = 0;

		if(!$rResult = JobPITRetriever($InrConn, $InrLogHandle, $iJobIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']))
			$InrLogHandle->AddLogMessage("Failed to get result from Job transtaction Retriever" , __FILE__, __FUNCTION__, __LINE__);
		else
		{
			HTMLJobPITDataBlock($rResult, $InrLogHandle, $IniUserAccess, $iJobIndex);

			$rResult->free();
		}
	}
	else
		$InrLogHandle->AddLogMessage("ID does not meet requirement range", __FILE__, __FUNCTION__, __LINE__);
}

function HTMLJobPITDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniJobIndex) : void
{
	//The toolbar for the buttons (tools)
	printf("
	<div class='content-tool-bar'>
		<form method='POST'>
			<input type='hidden' name='JobIndex' value='%d' required>
			<input class='input-left' type='submit' value='ADD' formaction='.?MenuIndex=%d&Module=%d&SubModule=%s'>
		</form>
	</div>",
	$IniJobIndex,
	$GLOBALS['MENU']['JOB']['INDEX'],
	$GLOBALS['MODULE']['EXTEND'],
	$GLOBALS['MODULE']['ADD']);

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{	
		if(((int) $aDataRow['JOB_PIT_ACCESS']) >= $IniUserAccess)
		{
			//DATA BLOCK
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div><h5>Transaction</h5></div>
					<div>
						<div><b><p>Payment</p></b></div>
						<div style='color:rgba(0,150,0,1)'><p>+%f</p></div>
					</div>
					<div>
						<div><b><p>Date</p></b></div>
						<div><p>%s</p></div>
					</div>
					<div>
						<input type='hidden' name='JobPITIndex' value='%d'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d&SubModule=%s'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d&SubModule=%s'>
					</div>
				</form>
			</div>",
			$aDataRow['JOB_PIT_PAYMENT'],
			$aDataRow['JOB_PIT_DATE'],
			$aDataRow['JOB_PIT_ID'],
			$GLOBALS['MENU']['JOB']['INDEX'],
			$GLOBALS['MODULE']['EXTEND'],
			$GLOBALS['MODULE']['DELETE'],
			$GLOBALS['MENU']['JOB']['INDEX'],
			$GLOBALS['MODULE']['EXTEND'],
			$GLOBALS['MODULE']['EDIT']);
		}
	}
}

function HTMLJobOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
	$sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

	$rJobListResult = 0;

	if(!$rJobListResult = JobOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
		$InrLogHandle->AddLogMessage("Failed to get result from Job transtaction Retriever" , __FILE__, __FUNCTION__, __LINE__);
	else
	{
		HTMLJobOverviewDataBlock($InrConn, $rJobListResult, $InrLogHandle, $IniUserAccess);

		$rJobListResult->free();
	}
}

function HTMLJobOverviewDataBlock(ME_CDBConnManager &$InrConn, mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
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
	$GLOBALS['MENU']['JOB']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['JOB']['INDEX'],
	$sHTMLGeneratedSelectStructure,
	(isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aJobRow)
	{
		if(((int) $aJobRow['JOB_DATA_ACCESS']) >= $IniUserAccess)
		{
			$iJobIndex = (int) $aJobRow['JOB_ID'];

			$bIsJobIncOutSameAccess = (BOOL) $aJobRow['JOB_INC_ACCESS'] == $aJobRow['JOB_OUT_ACCESS'];

			print("");

			//Title
			printf("
			<div class='data-block'>
				<form method='POST'>
					<div><h5>%s</h5></div>", $aJobRow['JOB_DATA_TITLE']);

			if(((int) $aJobRow['COMP_DATA_ACCESS']) >= $IniUserAccess)
			{
				//Data Row
				printf("
					<div>
						<div><b><p>Company</p></b></div>
						<div><p>%s</p></div>
					</div>", $aJobRow['COMP_DATA_TITLE']);
			}

			//Data Row
			printf("
					<div>
						<div><b><p>Job Date</p></b></div>
						<div><p>%s</p></div>
					</div>", $aJobRow['JOB_DATA_DATE']);

			if(((int)($aJobRow['JOB_INC_ACCESS'])) >= $IniUserAccess)
			{
				//Data Row
				printf("
					<div>
						<div><b><p>Price</p></b></div>
						<div><p>%s %s</p></div>
					</div>
					<div>
						<div><b><p>Payment in advance</p></b></div>
						<div style='color:rgba(0,230,0,1)'><p>+%s %s</p></div>
					</div>",
				$aJobRow['JOB_INC_PRICE'],
				$GLOBALS['CURRENCY_SYMBOL'],
				$aJobRow['JOB_INC_PIA'],
				$GLOBALS['CURRENCY_SYMBOL']);
			}

			if(((int) $aJobRow['JOB_OUT_ACCESS']) >= $IniUserAccess)
			{
				//Data Row
				printf("
					<div>
						<div><b><p>Expences</p></b></div>
						<div style='color:rgba(230,0,0,1)'><p>%s %s</p></div>
					</div>
					<div>
						<div><b><p>Damage</p></b></div>
						<div style='color:rgba(230,0,0,1)'><p>%s %s</p></div>
					</div>",
				$aJobRow['JOB_OUT_EXPENSES'],
				$GLOBALS['CURRENCY_SYMBOL'],
				$aJobRow['JOB_OUT_DAMAGE'],
				$GLOBALS['CURRENCY_SYMBOL']);
			}

			if($bIsJobIncOutSameAccess)
			{
				$fJobSum = HTMLJobPITTransSum($InrConn, $InrLogHandle, $IniUserAccess, $iJobIndex);

				$fJobSum += (float) (((float) $aJobRow['JOB_INC_PIA']) + (-abs((float)$aJobRow['JOB_OUT_EXPENSES']) - abs((float)$aJobRow['JOB_OUT_DAMAGE'])));

				//Data Row
				print("
					<div>
						<div><b><p>Sumary</p></b></div>");

				if($fJobSum < 0)
					print("<div style='color:rgba(230,0,0,1)'>");
				elseif($fJobSum > 0)
					print("<div style='color:rgba(0,230,0,1)'>");
				else
					print("<div style='color:rgba(230,230,0,1)'>");

				printf("
						<p>%1.2f %s</p></div>
					</div>",
				$fJobSum,
				$GLOBALS['CURRENCY_SYMBOL']);
			}

			//Button list for specific Data Row
			printf("
					<div>
						<input type='hidden' name='JobIndex' value='%d'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>",
			$aJobRow['JOB_ID'],
			$GLOBALS['MENU']['JOB']['INDEX'],
			$GLOBALS['MODULE']['DELETE']);

			if(($bIsJobIncOutSameAccess))
				printf("<input id='JobPIT' type='submit' value='Payments' formaction='.?MenuIndex=%s&Module=%s'>", $GLOBALS['MENU']['JOB']['INDEX'], $GLOBALS['MODULE']['EXTEND']);

			printf("
						<input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
					</div>
				</form>
			</div>",
			$GLOBALS['MENU']['JOB']['INDEX'],
			$GLOBALS['MODULE']['EDIT']);
		}
	}
}


function HTMLJobPITTransSum(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniJobIndex) : float
{
	$fPITSum = 0.0;

	$rResult = JobPITByJobIDSpecificRetriever($InrConn, $InrLogHandle, $IniJobIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

	if(!empty($rResult) && ($rResult->num_rows == 1))
	{
		$aDataRow = $rResult->fetch_array(MYSQLI_ASSOC);

		$fPITSum = (float) $aDataRow['JOB_PIT_SUM'];

		$rResult->free();
	}
	else
		$InrLogHandle->AddLogMessage("No data retrieved", __FILE__, __FUNCTION__, __LINE__);

	return round($fPITSum, $GLOBALS['CURRENCY_DECIMAL_PRECISION']);
}
?>
