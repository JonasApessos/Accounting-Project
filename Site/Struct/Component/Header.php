<?php
$rErrorProcFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rErrorProcLogHandle = new ME_CLogHandle($rErrorProcFileHandle, "LoginProcess", __FILE__);

$rConn = new ME_CDBConnManager($rErrorProcLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function HTMLHeader(ME_CLogHandle &$InrLogHandle)
{
	//Header Box
	print("
	<div class='header'>
		<div>
			<div class='header-title'>");

	if(isset($_GET['MenuIndex']))
	{
		switch($_GET['MenuIndex'])
		{
			case $GLOBALS['MENU']['COMPANY']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['COMPANY']['TITLE']);
				break;

			case $GLOBALS['MENU']['COUNTRY']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['COUNTRY']['TITLE']);
				break;

			case $GLOBALS['MENU']['EMPLOYEE']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['EMPLOYEE']['TITLE']);
				break;

			case $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['EMPLOYEE_POSITION']['TITLE']);
				break;

			case $GLOBALS['MENU']['JOB']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['JOB']['TITLE']);
				break;

			case $GLOBALS['MENU']['SHAREHOLDER']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['SHAREHOLDER']['TITLE']);
				break;

			case $GLOBALS['MENU']['CUSTOMER']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['CUSTOMER']['TITLE']);
				break;

			case $GLOBALS['MENU']['COUNTY']['INDEX']:
				printf("<h1>%s</h1>", $GLOBALS['MENU']['COUNTY']['TITLE']);
				break;

			default:
				printf("<h1>Home</h1>");
				break;
		}
	}
	else
		printf("<h1>Home</h1>");

	print("	</div>");

	HTMLHeaderLogin($InrLogHandle);

	print("
		</div>
	</div>");
}

function HTMLHeaderLogin(ME_CLogHandle &$InrLogHandle)
{
	//Header check state of user connection and display connected or not in the login box
	if(isset($_SESSION['Login']) && $_SESSION['Login'] == TRUE)
		ProFunctionCallback($InrLogHandle,"HTMLLogedIn", $GLOBALS['ACCESS']['EMPLOYEE'], (!isset($_GET['Login']) ? "GET" : "POST"));
	else
		ProFunctionCallback($InrLogHandle, "HTMLLoginForm", $GLOBALS['ACCESS']['GUEST'], "GET");
}

HTMLHeader($rErrorProcLogHandle);
?>
