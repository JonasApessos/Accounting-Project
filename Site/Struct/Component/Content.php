
<main class='content'>
<?php
//If $_GET['MenuIndex'] is set
if(isset($_GET["MenuIndex"]))
{
	//Get the index and load the required menu item
	switch($_GET["MenuIndex"])
	{
		case $GLOBALS['MENU']['COMPANY']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleCompanyOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleCompanyOverview.php");
			break;

		case $GLOBALS['MENU']['COUNTRY']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleCountryOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleCountryOverview.php");
			break;

		case $GLOBALS['MENU']['EMPLOYEE']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleEmployeeOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleEmployeeOverview.php");
			break;

		case $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleEmployeePositionOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleEmployeePositionOverview.php");
			break;

		case $GLOBALS['MENU']['JOB']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleJobOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleJobOverview.php");
			break;

		case $GLOBALS['MENU']['SHAREHOLDER']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleShareholderOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleShareholderOverview.php");
			break;

		case $GLOBALS['MENU']['CUSTOMER']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleCustomerOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleCustomerOverview.php");
			break;

		case $GLOBALS['MENU']['COUNTY']['INDEX']:
			require_once("Struct/Module/Overview/HTMLModule/HTMLModuleCountyOverview.php");
			require_once("Struct/Module/Overview/Module/ModuleCountyOverview.php");
			break;

		case $GLOBALS['MENU']['ERROR']['INDEX']:
			require_once("Struct/Module/AccessError.php");
			break;

		default:
			require_once("Struct/Module/Home.php");
	}
}
else
	require_once("Struct/Module/Home.php");
?>

</main>