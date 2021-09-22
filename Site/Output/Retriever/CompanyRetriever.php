<?php
function CompanySearchConstructor(string &$OutsSearchTypeQuery, string &$InsSearchType, string &$InsSearchQuery) : void
{
	$sVariableFormat = "?";

	switch($InsSearchType)
	{
		case $GLOBALS['COMPANY_SEARCH_TYPE']['COMPANY_TITLE']["NAME"]:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COMP_DATA_TITLE";
			break;
		}

		case $GLOBALS['COMPANY_SEARCH_TYPE']['COUNTY_TITLE']["NAME"]:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COU_DATA_TITLE";
			break;
		}

		case $GLOBALS['COMPANY_SEARCH_TYPE']['COUNTRY_TITLE']["NAME"]:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COUN_DATA_TITLE";
			break;
		}

		case $GLOBALS['COMPANY_SEARCH_TYPE']['COMPANY_DATE']['NAME']:
		{
			$OutsSearchTypeQuery .= "DATE_FORMAT(COMP_DATA_DATE, '%Y %m')";
			$sVariableFormat = "DATE_FORMAT(?, '%Y %m')";
			break;
		}

		case $GLOBALS['COMPANY_SEARCH_TYPE']['COUNTY_TAX']["NAME"]:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COU_DATA_TAX";
			break;
		}

		case $GLOBALS['COMPANY_SEARCH_TYPE']['COUNTY_IR']["NAME"]:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COU_DATA_IR";
			break;
		}

		default:
		{
			SearchQueryConstructor($InsSearchQuery);
			$OutsSearchTypeQuery .= "COMP_DATA_TITLE";
			break;
		}
	}

	$OutsSearchTypeQuery .= " LIKE " . $sVariableFormat;
}

function CompanyRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		COMP_ID,
		COMP_DATA_ID,
		COU_ID,
		COMP_ACCESS
		FROM
		".$InrConn->GetPrefix()."VIEW_COMPANY
		WHERE (COMP_AVAIL = ?)
		AND (COMP_ACCESS >= ?)
		ORDER BY COMP_CDATE;";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("ii", $IniAvail, $IniUserAccess))
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

function CompanyDataRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		COMP_DATA_ID,
		COMP_DATA_TITLE,
		COMP_DATA_DATE,
		COMP_DATA_ACCESS
		FROM
		".$InrConn->GetPrefix()."VIEW_COMPANY_DATA
		WHERE (COMP_DATA_AVAIL = ?)
		AND (COMP_DATA_ACCESS >= ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("ii", $IniAvail, $IniUserAccess))
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

function CompanyGeneralRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rStatement = 0;

		$sQuery = "SELECT
		COMP_ID,
		COMP_ACCESS,
		COMP_AVAIL,
		COU_ID,
		COMP_DATA_ID,
		COMP_DATA_ACCESS,
		COMP_DATA_AVAIL,
		COMP_DATA_TITLE,
		COMP_DATA_DATE,
		COUN_DATA_TITLE,
		COU_DATA_TITLE,
		COU_DATA_TAX,
		COU_DATA_IR,
		COU_DATA_DATE
		FROM
		".$InrConn->GetPrefix()."VIEW_COMPANY_GENERAL
		WHERE (COMP_AVAIL = ?
		AND	COMP_DATA_AVAIL = ?)
		AND	(COMP_ACCESS >= ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniAvail, $IniUserAccess))
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

function CompanyOverviewRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniAvail, string &$InsSearchType="", string &$InsSearchQuery="")
{
	if(CheckAccessRange($IniUserAccess) &&
	CheckRange($IniAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$sSearchConstruction = "";
		$sSearchQuery = ME_SecDataFilter($InsSearchQuery);

		CompanySearchConstructor($sSearchConstruction, $InsSearchType, $sSearchQuery);

		$rStatement = 0;

		$sQuery = "SELECT
		COMP_ID,
		COMP_DATA_ACCESS,
		COMP_DATA_TITLE,
		COMP_DATA_DATE,
		COU_DATA_ACCESS,
		COU_DATA_TITLE,
		COU_DATA_TAX,
		COU_DATA_IR,
		COUN_DATA_ACCESS,
		COUN_DATA_TITLE
		FROM ".$InrConn->GetPrefix()."VIEW_COMPANY_OVERVIEW
		WHERE (COMP_AVAIL = ? 
		AND COMP_DATA_AVAIL = ? 
		AND COU_DATA_AVAIL = ? 
		AND COUN_AVAIL = ?	
		AND	COUN_DATA_AVAIL = ?)
		AND	(COMP_ACCESS >= ?) 
		AND ".$sSearchConstruction.";";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iiiiiis", $IniAvail, $IniAvail, $IniAvail, $IniAvail, $IniAvail, $IniUserAccess, $sSearchQuery))
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

function CompanySelectElemRetriever(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniAvail)
{
	if(CheckAccessRange($IniUserAccess) &&
	($IniAvail > 0 && $IniAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
		$sPrefix = $InrConn->GetPrefix();

		$rStatement = 0;

		$sQuery = "SELECT
		".$sPrefix."VIEW_COMPANY.COMP_ID,
		".$sPrefix."VIEW_COMPANY_DATA.COMP_DATA_TITLE
		FROM
		".$sPrefix."VIEW_COMPANY,
		".$sPrefix."VIEW_COMPANY_DATA
		WHERE
		(".$sPrefix."VIEW_COMPANY.COMP_AVAIL = ?
		AND	".$sPrefix."VIEW_COMPANY_DATA.COMP_DATA_AVAIL = ?)
		AND	(".$sPrefix."VIEW_COMPANY.COMP_DATA_ID = ".$sPrefix."VIEW_COMPANY_DATA.COMP_DATA_ID)
		AND	(".$sPrefix."VIEW_COMPANY.COMP_ACCESS >= ?);";

		if($rStatement = $InrConn->CreateStatement($sQuery))
		{
			//Check if the statement binded the variables, else throw an exception with the error
			if($rStatement->bind_param("iii", $IniAvail, $IniAvail, $IniUserAccess))
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