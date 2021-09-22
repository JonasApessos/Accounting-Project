<?php
$rErrorProcFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a+");

$rErrorProcLogHandle = new ME_CLogHandle($rErrorProcFileHandle, "LoginProcess", __FILE__);

$rConn = new ME_CDBConnManager($rErrorProcLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function HTMLHeader(ME_CLogHandle &$InrLogHandle)
{
	$sHeaderTitle = "";

	if(isset($_GET['MenuIndex']))
	{
		switch($_GET['MenuIndex'])
		{
			case $GLOBALS['MENU']['HOME']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['HOME']['TITLE'];
				break;

			case $GLOBALS['MENU']['COMPANY']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['COMPANY']['TITLE'];
				break;

			case $GLOBALS['MENU']['COUNTRY']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['COUNTRY']['TITLE'];
				break;

			case $GLOBALS['MENU']['EMPLOYEE']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['EMPLOYEE']['TITLE'];
				break;

			case $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['EMPLOYEE_POSITION']['TITLE'];
				break;

			case $GLOBALS['MENU']['JOB']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['JOB']['TITLE'];
				break;

			case $GLOBALS['MENU']['SHAREHOLDER']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['SHAREHOLDER']['TITLE'];
				break;

			case $GLOBALS['MENU']['CUSTOMER']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['CUSTOMER']['TITLE'];
				break;

			case $GLOBALS['MENU']['COUNTY']['INDEX']:
				$sHeaderTitle = $GLOBALS['MENU']['COUNTY']['TITLE'];
				break;

			default:
				$sHeaderTitle = $GLOBALS['MENU']['HOME']['TITLE'];
				break;
		}
	}
	else
		$sHeaderTitle = $GLOBALS['MENU']['HOME']['TITLE'];


	//Header Box
	printf("
	<header class='header'>
		<div>
			<div class='header-title'>
				<h1>%s</h1>
			</div>", $sHeaderTitle);

			HTMLHeaderLogin($InrLogHandle);

	print("
		</div>
	</header>");
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
