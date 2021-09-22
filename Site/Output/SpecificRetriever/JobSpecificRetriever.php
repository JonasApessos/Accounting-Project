<?php
function JobSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	($IniJobIndex > 0) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		JOB_ID,
		JOB_DATA_ID,
		JOB_INC_ID,
		JOB_OUT_ID,
		COMP_ID,
		JOB_ACCESS
		FROM ".$InrConn->GetPrefix()."VIEW_JOB
		WHERE (JOB_AVAIL = ?)
		AND (JOB_ACCESS >= ?)
		AND (JOB_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniUserAccess, $IniJobIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobDataSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobDataIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	($IniJobDataIndex > 0) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		JOB_DATA_ID,
		JOB_DATA_TITLE,
		JOB_DATA_DATE,
		JOB_DATA_ACCESS
		FROM ".$InrConn->GetPrefix()."VIEW_JOB_DATA
		WHERE (JOB_DATA_AVAIL = ?)
		AND (JOB_DATA_ACCESS >= ?)
		AND (JOB_DATA_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniUserAccess, $IniJobDataIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobIncomeSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobIncomeIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	($IniJobIncomeIndex > 0) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		JOB_INC_ID,
		JOB_INC_PRICE,
		JOB_INC_PIA,
		JOB_INC_ACCESS
		FROM ".$InrConn->GetPrefix()."VIEW_JOB_INCOME
		WHERE (JOB_INC_AVAIL = ?)
		AND (JOB_INC_ACCESS >= ?)
		AND (JOB_INC_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniUserAccess, $IniJobIncomeIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobOutcomeSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobOutcomeIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	($IniJobOutcomeIndex > 0) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		JOB_OUT_ID,
		JOB_OUT_EXPENSES,
		JOB_OUT_DAMAGE,
		JOB_OUT_ACCESS
		FROM ".$InrConn->GetPrefix()."VIEW_JOB_OUTCOME
		WHERE (JOB_OUT_AVAIL = ?)
		AND (JOB_OUT_ACCESS >= ?)
		AND (JOB_OUT_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniUserAccess, $IniJobOutcomeIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

//WARNIGN:To be removed in future versions
function JobGeneralSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) && ($IniJobIndex > 0) && ($IniAvail > 0 && $IniAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
        $sQuery = "";
		$sPrefix = $InrConn->GetPrefix();

		$rStatement = 0;

		$sQuery = "SELECT
		JOB_ID,
		JOB_ACCESS,
		JOB_DATA_ID,
		JOB_DATA_TITLE,
		JOB_DATA_DATE,
		JOB_INC_ID,
		JOB_INC_PRICE,
		JOB_INC_PIA,
		JOB_OUT_ID,
		JOB_OUT_EXPENSES,
		JOB_OUT_DAMAGE,
		COMP_ID,
		COMP_DATA_TITLE,
		COMP_DATA_DATE
		FROM
		".$sPrefix."VIEW_JOB_GENERAL
		WHERE
		(".$sPrefix."VIEW_JOB_GENERAL.JOB_AVAIL = ?
		AND
		".$sPrefix."VIEW_JOB_GENERAL.JOB_INC_AVAIL = ?
		AND
		".$sPrefix."VIEW_JOB_GENERAL.JOB_OUT_AVAIL = ?
		AND
		".$sPrefix."VIEW_JOB_GENERAL.COMP_AVAIL = ?
		AND
		".$sPrefix."VIEW_JOB_GENERAL.COMP_DATA_AVAIL = ?
		AND
        ".$sPrefix."VIEW_JOB_GENERAL.JOB_ACCESS >= ?
        AND
        ".$sPrefix."VIEW_JOB_GENERAL.JOB_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iiiiiii", $IniAvail, $IniAvail, $IniAvail, $IniAvail, $IniAvail, $IniUserAccess, $IniJobIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobEditSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) && ($IniJobIndex > 0) && ($IniAvail > 0 && $IniAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
        $sQuery = "";
		$sPrefix = $InrConn->GetPrefix();

		$rStatement = 0;

		$sQuery = "SELECT
		".$sPrefix."VIEW_JOB.JOB_ID,
		".$sPrefix."VIEW_JOB.JOB_ACCESS,
		".$sPrefix."VIEW_JOB.COMP_ID,
		".$sPrefix."VIEW_JOB_DATA.JOB_DATA_TITLE,
		".$sPrefix."VIEW_JOB_DATA.JOB_DATA_DATE,
		".$sPrefix."VIEW_JOB_INCOME.JOB_INC_PRICE,
		".$sPrefix."VIEW_JOB_INCOME.JOB_INC_PIA,
		".$sPrefix."VIEW_JOB_OUTCOME.JOB_OUT_EXPENSES,
		".$sPrefix."VIEW_JOB_OUTCOME.JOB_OUT_DAMAGE
		FROM
		".$sPrefix."VIEW_JOB,
		".$sPrefix."VIEW_JOB_DATA,
		".$sPrefix."VIEW_JOB_INCOME,
		".$sPrefix."VIEW_JOB_OUTCOME
		WHERE (".$sPrefix."VIEW_JOB.JOB_ID = ?)
		AND (".$sPrefix."VIEW_JOB.JOB_DATA_ID = ".$sPrefix."VIEW_JOB_DATA.JOB_DATA_ID)
		AND (".$sPrefix."VIEW_JOB.JOB_INC_ID = ".$sPrefix."VIEW_JOB_INCOME.JOB_INC_ID)
		AND (".$sPrefix."VIEW_JOB.JOB_OUT_ID = ".$sPrefix."VIEW_JOB_OUTCOME.JOB_OUT_ID);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("i", $IniJobIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobPITSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobPITIndex, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) && ($IniJobPITIndex > 0) && ($IniAvail > 0 && $IniAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
		$sQuery = "";
		$sPrefix = $InrConn->GetPrefix();

		$rStatement = 0;

		$sQuery = "SELECT
		JOB_PIT_ID,
		JOB_PIT_ACCESS,
		JOB_ID,
		JOB_PIT_PAYMENT,
		JOB_PIT_DATE
		FROM
		".$sPrefix."VIEW_JOB_INCOME_TIME
		WHERE
		(".$sPrefix."VIEW_JOB_INCOME_TIME.JOB_PIT_AVAIL = ?
		AND
		".$sPrefix."VIEW_JOB_INCOME_TIME.JOB_PIT_ACCESS >= ?
		AND
		".$sPrefix."VIEW_JOB_INCOME_TIME.JOB_PIT_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniUserAccess, $IniJobPITIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}

function JobPITByJobIDSpecificRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniJobIndex, int $IniUserAccess)
{
	if(CheckAccessRange($IniUserAccess) && ($IniJobIndex > 0))
	{
		$sQuery = "";
		$sPrefix = $InrConn->GetPrefix();

		$rStatement = 0;

		$sQuery = "SELECT
		JOB_ID,
		JOB_PIT_SUM
		FROM
		".$sPrefix."VIEW_JOB_INCOME_TIME_SUM
		WHERE
		(".$sPrefix."VIEW_JOB_INCOME_TIME_SUM.JOB_PIT_ACCESS >= ?
		AND
		".$sPrefix."VIEW_JOB_INCOME_TIME_SUM.JOB_ID = ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("ii", $IniUserAccess, $IniJobIndex))
				return ME_SQLStatementExecAndResult($InrConn, $rStatement, $InrLogHandle);
			else
				$InrLogHandle->AddLogMessage("Error Binding parameters to query", __FILE__, __FUNCTION__, __LINE__);
		}
		else
			$InrLogHandle->AddLogMessage("Error creating statement object", __FILE__, __FUNCTION__, __LINE__);
	}
	else
		$InrLogHandle->AddLogMessage("Input parameters do not meet requirements range", __FILE__, __FUNCTION__, __LINE__);

	return FALSE;
}
?>