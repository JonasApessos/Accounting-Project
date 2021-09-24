<?php
require_once("Data/HeaderData/HeaderData.php");
require("Data/ConnData/DBSessionToken.php");

session_start();

require_once("Data/GlobalData.php");
require_once("Data/ConnData/DBConnData.php");
require_once("../MedaLib/Class/Handle/FileHandle.php");
require_once("../MedaLib/Class/Handle/LogHandle.php");
require_once("../MedaLib/Function/Filter/SecurityFilter/SecurityFilter.php");

//Header include
require_once("../MedaLib/Class/Manager/DBConnManager.php");
require_once("../MedaLib/Function/Filter/SecurityFilter/SecurityFormFilter.php");
require_once("Process/ProErrorLog/ProCallbackErrorLog.php");
require_once("Process/ProLogin/ProLogin.php");
require_once("Struct/Module/Form/LoginForm.php");

//Content Include
require_once("Data/HeaderData/HeaderData.php");
require_once("Data/ConnData/DBSessionToken.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf8">
<link rel="icon" href="../images/FaviconPlaceholder.png" type="image/png">
<link rel="stylesheet" href="../css/Device/Desktop/DesktopMediaRule.css">
<link rel="stylesheet" href="../css/Header.css">
<link rel="stylesheet" href="../css/Body.css">
<link rel="stylesheet" href="../css/Content.css">
<link rel="stylesheet" href="../css/Footer.css">
<link rel="stylesheet" href="../css/MainMenu.css">
<link rel="stylesheet" href="../css/DataBlock.css">
<link rel="stylesheet" href="../css/Form.css">

<?php

$sIndexHtml = "";

if(isset($_GET['Login']))
{
    require_once("../MedaLib/Function/Tool/RangeCheck.php");
    require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
    require_once("Output/SpecificRetriever/EmployeeSpecificRetriever.php");

    $rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a+");
    $rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "LoginProcess", __FILE__);

    $rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

    ProLogin($rConn, $rProcessLogHandle);

    $rProcessLogHandle->WriteToFileAndClear();

    unset($rConn, $rProcessFileHandle, $rProcessLogHandle);
}
else if (isset($_GET['Logout']))
{
    $rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a+");
    $rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "LogoutProcess", __FILE__);

    ProLogout($rProcessLogHandle);

    InitSession();
}
else
    InitSession();

//Flow root
if(isset($_GET['MenuIndex']))
{
    require_once("../MedaLib/Class/Manager/DBConnManager.php");
    require_once("../MedaLib/Function/Filter/DataFilter/MultyCheckDataTypeFilter/MultyCheckDataEmptyType.php");
    require_once("../MedaLib/Function/Filter/DataFilter/MultyCheckDataTypeFilter/MultyCheckDataNumericType.php");
    require_once("../MedaLib/Function/Filter/SecurityFilter/SecurityFilter.php");
    require_once("../MedaLib/Function/Filter/SecurityFilter/SecurityFormFilter.php");
    require_once("../MedaLib/Function/Generator/QuerySearchConstructor.php");
    require_once("../MedaLib/Function/Tool/RangeCheck.php");
    require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
    require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
    require_once("Struct/Element/Function/Select/SelectAccessRowRender.php");
    require_once("Output/Retriever/AccessRetriever.php");

    require_once("Function/AccessLevelCheck.php");
    require_once("Process/ProErrorLog/ProCallbackErrorLog.php");

    switch($_GET['MenuIndex'])
    {
        //Access Error
        case $GLOBALS['MENU']['ERROR']["INDEX"]:
            break;

        //Company
        case $GLOBALS['MENU']['HOME']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['HOME']['TITLE']."</title>
                <script src='../js/IncomeReport.js'></script>
                <script src='../js/Canvas.js'></script>";

                break;
            }

        //Company
        case $GLOBALS['MENU']['COMPANY']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['COMPANY']['TITLE']."</title>";

                /*This is to minimize the search and load time as well as the allocation and definition of functions,
                variables that are not needed for the rest of the script to work.*/
                require_once("Output/Retriever/CompanyRetriever.php");

                require_once("Output/Retriever/CountyRetriever.php");
                require_once("Struct/Element/Function/Select/SelectCountyRowRender.php");

                //Company Add process
                require_once("Struct/Module/Form/AddForm/CompanyAddForm.php");
                require_once("Input/Parser/AddParser/CompanyAddParser.php");
                require_once("Process/ProAdd/ProAddCompany.php");

                //Company Edit process
                require_once("Output/SpecificRetriever/CompanySpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/CompanyEditForm.php");
                require_once("Input/Parser/EditParser/CompanyEditParser.php");
                require_once("Process/ProEdit/ProEditCompany.php");

                //Company Delete process
                require_once("Input/Parser/VisibilityParser/CompanyVisParser.php");
                require_once("Process/ProDel/ProDelCompany.php");
                
                break;
            }

        //Country
        case $GLOBALS['MENU']['COUNTRY']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['COUNTRY']['TITLE']."</title>";

                require_once("Output/Retriever/CountryRetriever.php");

                //Country Add process
                require_once("Struct/Module/Form/AddForm/CountryAddForm.php");
                require_once("Input/Parser/AddParser/CountryAddParser.php");
                require_once("Process/ProAdd/ProAddCountry.php");

                //Country Edit process
                require_once("Output/SpecificRetriever/CountrySpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/CountryEditForm.php");
                require_once("Input/Parser/EditParser/CountryEditParser.php");
                require_once("Process/ProEdit/ProEditCountry.php");

                //Country Delete process
                require_once("Input/Parser/VisibilityParser/CountryVisParser.php");
                require_once("Process/ProDel/ProDelCountry.php");

                break;
            }

        //Employee
        case $GLOBALS['MENU']['EMPLOYEE']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['EMPLOYEE']['TITLE']."</title>";

                require_once("Output/Retriever/EmployeeRetriever.php");

                require_once("Output/Retriever/CompanyRetriever.php");
                require_once("Struct/Element/Function/Select/SelectCompanyRowRender.php");
                require_once("Struct/Element/Function/Select/SelectEmployeePositionRowRender.php");

                //Employee Add process
                require_once("Struct/Module/Form/AddForm/EmployeeAddForm.php");
                require_once("Input/Parser/AddParser/EmployeeAddParser.php");
                require_once("Process/ProAdd/ProAddEmployee.php");

                //Employee Edit process
                require_once("Output/SpecificRetriever/EmployeeSpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/EmployeeEditForm.php");
                require_once("Input/Parser/EditParser/EmployeeEditParser.php");
                require_once("Process/ProEdit/ProEditEmployee.php");

                //Employee Delete process
                require_once("Input/Parser/VisibilityParser/EmployeeVisParser.php");
                require_once("Process/ProDel/ProDelEmployee.php");

                break;
            }

        //Employee Position
        case $GLOBALS['MENU']['EMPLOYEE_POSITION']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['EMPLOYEE_POSITION']['TITLE']."</title>";

                require_once("Output/Retriever/EmployeeRetriever.php");

                //EmployeePosition Add process
                require_once("Struct/Module/Form/AddForm/EmployeePositionAddForm.php");
                require_once("Input/Parser/AddParser/EmployeePositionAddParser.php");
                require_once("Process/ProAdd/ProAddEmployeePosition.php");

                //EmployeePosition Edit process
                require_once("Output/SpecificRetriever/EmployeeSpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/EmployeePositionEditForm.php");
                require_once("Input/Parser/EditParser/EmployeePositionEditParser.php");
                require_once("process/ProEdit/ProEditEmployeePosition.php");

                //EmployeePosition Delete process
                require_once("Input/Parser/VisibilityParser/EmployeePositionVisParser.php");
                require_once("Process/ProDel/ProDelEmployeePosition.php");

                break;
            }

        //Job
        case $GLOBALS['MENU']['JOB']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['JOB']['TITLE']."</title>";

                require_once("Output/Retriever/JobRetriever.php");

                require_once("Output/Retriever/CompanyRetriever.php");
                require_once("Struct/Element/Function/Select/SelectCompanyRowRender.php");

                //JobPIT Add process
                require_once("Struct/Module/Form/AddForm/JobPITAddForm.php");
                require_once("Input/Parser/AddParser/JobPitAddParser.php");
                require_once("Process/ProAdd/ProAddJobPIT.php");

                //JobPIT Edit process
                require_once("Output/SpecificRetriever/JobSpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/JobPITEditForm.php");
                require_once("Input/Parser/EditParser/JobPITEditParser.php");
                require_once("Process/ProEdit/ProEditJobPIT.php");

                //JobPIT Delete process
                require_once("Input/Parser/VisibilityParser/JobPITVisParser.php");
                require_once("Process/ProDel/ProDelJobPIT.php");

                //Job Add process
                require_once("Struct/Module/Form/AddForm/JobAddForm.php");
                require_once("Input/Parser/AddParser/JobAddParser.php");
                require_once("Process/ProAdd/ProAddJob.php");            
                
                //Job Edit process
                require_once("Struct/Module/Form/EditForm/JobEditForm.php");
                require_once("Input/Parser/EditParser/JobEditParser.php");
                require_once("Process/ProEdit/ProEditJob.php");

                //Job Delete process
                require_once("Input/Parser/VisibilityParser/JobVisParser.php");
                require_once("Process/ProDel/ProDelJob.php");

                break;
            }

        //Shareholder
        case $GLOBALS['MENU']['SHAREHOLDER']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['SHAREHOLDER']['TITLE']."</title>";

                require_once("Output/Retriever/ShareholderRetriever.php");
                require_once("Output/Retriever/EmployeeRetriever.php");
                require_once("Struct/Element/Function/Select/SelectEmployeeRowRender.php");

                //Shareholder Add process
                require_once("Struct/Module/Form/AddForm/ShareholderAddForm.php");
                require_once("Input/Parser/AddParser/ShareholderAddParser.php");
                require_once("Process/ProAdd/ProAddShareholder.php");
                
                //Shareholder Edit process
                require_once("Output/SpecificRetriever/ShareholderSpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/ShareholderEditForm.php");
                require_once("Input/Parser/EditParser/ShareholderEditParser.php");
                require_once("Process/ProEdit/ProEditShareholder.php");

                //Shareholder Delete process
                require_once("Input/Parser/VisibilityParser/ShareholderVisParser.php");
                require_once("Process/ProDel/ProDelShareholder.php");  

                break;
            }

        //Customer
        case $GLOBALS['MENU']['CUSTOMER']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['CUSTOMER']['TITLE']."</title>";

                require_once("Output/Retriever/CustomerRetriever.php");

                //Customer Add process
                require_once("Struct/Module/Form/AddForm/CustomerAddForm.php");
                require_once("Input/Parser/AddParser/CustomerAddParser.php");
                require_once("Process/ProAdd/ProAddCustomer.php");

                //Customer Edit process
                require_once("Output/SpecificRetriever/CustomerSpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/CustomerEditForm.php");
                require_once("Input/parser/EditParser/CustomerEditParser.php");
                require_once("Process/ProEdit/ProEditCustomer.php");

                //Customer Delete process
                require_once("Input/Parser/VisibilityParser/CustomerVisParser.php");
                require_once("Process/ProDel/ProDelCustomer.php");

                break;
            }

        //County
        case $GLOBALS['MENU']['COUNTY']["INDEX"]:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['COUNTY']['TITLE']."</title>";

                require_once("Output/Retriever/CountyRetriever.php");
                require_once("Output/Retriever/CountryRetriever.php");
                require_once("Struct/Element/Function/Select/SelectCountryRowRender.php");

                //County Add process
                require_once("Struct/Module/Form/AddForm/CountyAddForm.php");
                require_once("Input/Parser/AddParser/CountyAddParser.php");
                require_once("Process/ProAdd/ProAddCounty.php");

                //County Edit process
                require_once("Output/SpecificRetriever/CountySpecificRetriever.php");
                require_once("Struct/Module/Form/EditForm/CountyEditForm.php");
                require_once("Input/Parser/EditParser/CountyEditParser.php");
                require_once("Process/ProEdit/ProEditCounty.php");

                //County Delete process
                require_once("Input/Parser/VisibilityParser/CountyVisParser.php");
                require_once("Process/ProDel/ProDelCounty.php");

                break;
            }

        default:
            {
                $sIndexHtml = "<title>".$GLOBALS['MENU']['HOME']['TITLE']."</title>
                <script src='../js/IncomeReport.js'></script>
                <script src='../js/Canvas.js'></script>";
                break;
            }
    }
}
else
{
    $sIndexHtml = "<title>".$GLOBALS['MENU']['HOME']['TITLE']."</title>
    <script src='../js/IncomeReport.js'></script>
    <script src='../js/Canvas.js'></script>";
}

print($sIndexHtml);

?>

<script src='../js/Main.js'></script>
<script src='../js/MenuDisplay.js'></script>
<script src="../js/QueryDataTypeControl.js"></script>

</head>

<body onload="Main()">

<?php
//Main Menu
require_once("Struct/Component/MainMenu.php");
?>

<div class="wrapper">

<?php
//Header content
require_once("Struct/Component/Header.php");

//Body content
require_once("Struct/Component/Content.php");

//Footer content
require_once("Struct/Component/Footer.php");
?>
</div>

</body>
</html>