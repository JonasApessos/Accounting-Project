<?php
function CompanyGeneralRetriever()
{
	$DBConn = new DBConnManager($_SESSION['ServerName'], $_SESSION['DBUserName'], $_SESSION['DBPassWord']);

	$DBQuery = "SELECT *
	FROM VIEW_COMPANY_GENERAL
	WHERE COMP_AVAIL = 2
	AND VIEW_COMPANY_GENERAL.COMP_ACCESS > ".($_SESSION['Access_ID'] - 1).";";

	$DBConn->ExecQuery($DBQuery, FALSE);

	$Result = $DBConn->GetResult();

	if(!$DBConn->HasError())
	{
		if($DBConn->HasWarning())
			printf("warning detected: " . $DBConn->GetWarning());
	}
	else
		printf("Error: " . $DBConn->GetError());

	$DBConn->closeConn();

	unset($DBConn);
	unset($DBQuery);

	return $Result;
}

function CompanyFormRetriever()
{
	$DBConn = new DBConnManager($_SESSION['ServerName'], $_SESSION['DBUserName'], $_SESSION['DBPassWord']);

	$DBQuery = "SELECT VIEW_COMPANY.COMP_ID, VIEW_COMPANY_DATA.COMP_Title
	FROM VIEW_COMPANY_DATA, VIEW_COMPANY
	WHERE VIEW_COMPANY.COMP_AVAIL = 2
	AND VIEW_COMPANY.COMP_DATA_ID = VIEW_COMPANY_DATA.COMP_ID
	AND VIEW_COMPANY.COMP_ACCESS > ".($_SESSION['Access_ID'] - 1).";";

	$DBConn->ExecQuery($DBQuery, FALSE);

	$Result = $DBConn->GetResult();

	if(!$DBConn->HasError())
	{
		if($DBConn->HasWarning())
			printf("warning detected: " . $DBConn->GetWarning());
	}
	else
		printf("Error: " . $DBConn->GetError());

	$DBConn->CloseConn();

	unset($DBConn);
	unset($DBQuery);

	return $Result;

}

?>
