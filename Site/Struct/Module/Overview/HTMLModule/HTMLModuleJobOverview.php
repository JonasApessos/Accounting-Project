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
	$sJobPITHTML = "";

	//The toolbar for the buttons (tools)
	$sJobPITHTML .= "
	<div class='content-tool-bar'>
		<form method='POST'>
			<input type='hidden' name='JobIndex' value='".$IniJobIndex."' required>
			<input class='input-left' type='submit' value='ADD' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."&SubModule=".$GLOBALS['MODULE']['ADD']."'>
		</form>
	</div>";

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
	{	
		if(((int) $aDataRow['JOB_PIT_ACCESS']) >= $IniUserAccess)
		{
			//DATA BLOCK
			$sJobPITHTML .= "
			<div class='data-block'>
				<form method='POST'>
					<div><h5>Transaction</h5></div>
					<div>
						<div><b><p>Payment</p></b></div>
						<div style='color:rgba(0,150,0,1)'><p>".$aDataRow['JOB_PIT_PAYMENT']."</p></div>
					</div>
					<div>
						<div><b><p>Date</p></b></div>
						<div><p>".$aDataRow['JOB_PIT_DATE']."</p></div>
					</div>
					<div>
						<input type='hidden' name='JobPITIndex' value='".$aDataRow['JOB_PIT_ID']."'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."&SubModule=".$GLOBALS['MODULE']['DELETE']."'>
						<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."&SubModule=".$GLOBALS['MODULE']['EDIT']."'>
					</div>
				</form>
			</div>";
		}
	}

	print($sJobPITHTML);
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
	$sJobHTML = "";
	$sColorPIA = "";
	$sColorExpenses = "";
	$sColorDamage = "";
	$sColorSum = "";

	$sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['EMPLOYEE_POSITION_SEARCH_TYPE'], $sSearchTypeSelected);

	//The toolbar for the buttons (tools)
	$sJobHTML .= "
	<div class='content-tool-bar'>
		<a href='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
			<div class='button-left'><h5>ADD</h5></div>
		</a>
		<form action='.' method='get'>
			<input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['JOB']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
			<label>Query</label><input type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'>
			<button>submit</button>
		</form>
	</div>";

	foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aJobRow)
	{
		if(((int) $aJobRow['JOB_DATA_ACCESS']) >= $IniUserAccess)
		{
			$iJobIndex = (int) $aJobRow['JOB_ID'];

			$bIsJobIncOutSameAccess = (BOOL) $aJobRow['JOB_INC_ACCESS'] == $aJobRow['JOB_OUT_ACCESS'];

			//Title
			$sJobHTML .= "
			<div class='data-block'>
				<form method='POST'>
					<div><h5>".$aJobRow['JOB_DATA_TITLE']."</h5></div>";

			if(((int) $aJobRow['COMP_DATA_ACCESS']) >= $IniUserAccess)
			{
				//Data Row
				$sJobHTML .= "
					<div>
						<div><b><p>Company</p></b></div>
						<div><p>".$aJobRow['COMP_DATA_TITLE']."</p></div>
					</div>";
			}

			//Data Row
			$sJobHTML .= "
					<div>
						<div><b><p>Job Date</p></b></div>
						<div><p>".date("d/m/Y", strtotime($aJobRow['JOB_DATA_DATE']))."</p></div>
					</div>";

			if(((int)($aJobRow['JOB_INC_ACCESS'])) >= $IniUserAccess)
			{
				if($aJobRow['JOB_INC_PIA'] > 0)
					$sColorPIA = 'positive';
				else if($aJobRow['JOB_INC_PIA'] < 0)
					$sColorPIA = 'negative';

				//Data Row
				$sJobHTML .= "
					<div>
						<div><b><p>Price</p></b></div>
						<div><p>".number_format($aJobRow['JOB_INC_PRICE'], 2)." ".$GLOBALS['CURRENCY_SYMBOL']."</p></div>
					</div>
					<div>
						<div><b><p>Payment in advance</p></b></div>
						<div class='".$sColorPIA."'><p>+".number_format($aJobRow['JOB_INC_PIA'], 2)." ".$GLOBALS['CURRENCY_SYMBOL']."</p></div>
					</div>";
			}

			if(((int) $aJobRow['JOB_OUT_ACCESS']) >= $IniUserAccess)
			{
				if($aJobRow['JOB_OUT_EXPENSES'] > 0)
					$sColorExpenses = "positive";
				else if($aJobRow['JOB_OUT_EXPENSES'] < 0)
					$sColorExpenses = "negative";

				if($aJobRow['JOB_OUT_DAMAGE'] > 0)
					$sColorDamage = "positive";
				else if($aJobRow['JOB_OUT_DAMAGE'] < 0)
					$sColorDamage = "negative";

				//Data Row
				$sJobHTML .= "
					<div>
						<div><b><p>Expences</p></b></div>
						<div class='".$sColorExpenses."'><p>".number_format($aJobRow['JOB_OUT_EXPENSES'], 2)." ".$GLOBALS['CURRENCY_SYMBOL']."</p></div>
					</div>
					<div>
						<div><b><p>Damage</p></b></div>
						<div class='".$sColorDamage."'><p>".number_format($aJobRow['JOB_OUT_DAMAGE'], 2)." ".$GLOBALS['CURRENCY_SYMBOL']."</p></div>
					</div>";
			}

			if($bIsJobIncOutSameAccess)
			{
				$fJobSum = HTMLJobPITTransSum($InrConn, $InrLogHandle, $IniUserAccess, $iJobIndex);

				$fJobSum += (float) (((float) $aJobRow['JOB_INC_PIA']) + (-abs((float)$aJobRow['JOB_OUT_EXPENSES']) - abs((float)$aJobRow['JOB_OUT_DAMAGE'])));

				if($fJobSum > 0)
					$sColorSum = 'positive';
				else if($fJobSum < 0)
					$sColorSum = 'negative';

				//Data Row
				$sJobHTML .= "
					<div>
						<div>
							<b><p>Sumary</p></b>
						</div>
						<div class='".$sColorSum."'>
							<p>".number_format(round($fJobSum, 3), 2)." ".$GLOBALS['CURRENCY_SYMBOL']."</p>
						</div>
					</div>";
			}

			//Button list for specific Data Row
			$sJobHTML .= "
					<div>
						<input type='hidden' name='JobIndex' value='".$aJobRow['JOB_ID']."'>
						<input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>";

			if(($bIsJobIncOutSameAccess))
				$sJobHTML .= "<input id='JobPIT' type='submit' value='Payments' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."'>";

			$sJobHTML .= "
						<input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
					</div>
				</form>
			</div>";
		}
	}

	print($sJobHTML);
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

	return round($fPITSum, $GLOBALS['CURRENCY_DECIMAL_PRECISION']);
}
?>
