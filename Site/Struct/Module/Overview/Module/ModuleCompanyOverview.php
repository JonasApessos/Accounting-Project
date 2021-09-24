<?php
$rProcessFileHandle = new ME_CFileHandle($GLOBALS['DEFAULT_LOG_FILE'], $GLOBALS['DEFAULT_LOG_PATH'], "a");

$rProcessLogHandle = new ME_CLogHandle($rProcessFileHandle, "CompanyProcess", __FILE__);

//This is the connection to the database using the MedaLib classes.
$rConn = new ME_CDBConnManager($rProcessLogHandle, $_SESSION['DBName'], $_SESSION['ServerDNS'], $_SESSION['DBUsername'], $_SESSION['DBPassword'], $_SESSION['DBPrefix']);

function CompAddStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
    //If the form was completed from the add form then execute the process and add those data in the database.
    if (isset($_GET['ProAdd'])) 
    {
        ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProAddCompany", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

        header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['COMPANY']['INDEX']), $http_response_header=200);
    }
    else 
        ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLCompanyAddForm", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
}

function CompEditStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
     //If the form was completed from the Edit form then execute the process and Edit those data in the database.            
     if(isset($_GET['ProEdit'])) 
     {
         ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProEditCompany", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

         header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['COMPANY']['INDEX']), $http_response_header=200);
     } 
     else 
         ProQueryFunctionCallback($InrConn, $InrLogHandle, "HTMLCompanyEditForm", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");
}

function CompDeleteStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
     //Execute the process and edit the show flag data in the database.
     ProQueryFunctionCallback($InrConn, $InrLogHandle, "ProDelCompany", $GLOBALS['ACCESS']['EMPLOYEE'], "POST");

     header("Location:Index.php?MenuIndex=".urlencode($GLOBALS['MENU']['COMPANY']['INDEX']), $http_response_header=200);
}

function CompOverviewStructSolver(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle)
{
    //Determine what module has to load from the button that was clicked.(the buttons are - Add, Edit or Delete)
    //WARNING: while add does not require a post method from the server, the Edit and Delete process require POST method to work.
    switch ($_GET['Module']) 
    {
        case $GLOBALS['MODULE']['ADD']:
        {
            CompAddStructSolver($InrConn, $InrLogHandle);

            break;
        }
        case $GLOBALS['MODULE']['EDIT']:
        {
            CompEditStructSolver($InrConn, $InrLogHandle);
            
            break;
        }
        case $GLOBALS['MODULE']['DELETE']:
        {
            CompDeleteStructSolver($InrConn, $InrLogHandle);

            break;
        }
        default:
        {
            header("Location:.");
            break;
        }
    }
}


//If the module is not set then CompanyOverview from menu was selected, then load the overview.
if(!isset($_GET['Module']))
    ProQueryFunctionCallback($rConn, $rProcessLogHandle, "HTMLCompanyOverview", $GLOBALS['ACCESS']['EMPLOYEE'], "GET");
else
    CompOverviewStructSolver($rConn, $rProcessLogHandle);

$rProcessLogHandle->WriteToFileAndClear();
?>