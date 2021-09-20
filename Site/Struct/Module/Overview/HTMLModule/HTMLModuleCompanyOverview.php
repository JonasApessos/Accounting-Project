<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/CompanyRetriever.php");

function HTMLCompanyOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    $sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

    //The variable object that holds the query result
    $rResult = 0;
    
    if(!$rResult = CompanyOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
        $InrLogHandle->AddLogMessage("Failed to get result from Company Retriever" , __FILE__, __FUNCTION__, __LINE__);
    else
    {
        HTMLCompanyDataBlock($rResult, $InrLogHandle, $IniUserAccess);

        $rResult->free();
    }
}


function HTMLCompanyDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{

    $sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COMPANY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CompanyQueryDataType()");

    //The toolbar for the buttons (tools)
    printf("
    <div class='content-tool-bar'>
        <a href='.?MenuIndex=%d&Module=%d'>
            <div class='button-left'><h5>ADD</h5></div>
        </a>
        <form action='.' method='get'>
            <input type='hidden' name='MenuIndex' value='%d'><label>Search by</label>%s
            <label>Query</label><input type='text' id='QueryInput' name='SearchQuery' value='%s'>
            <button>submit</button>
        </form>
    </div>
    ",
    $GLOBALS['MENU']['COMPANY']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['COMPANY']['INDEX'],
    $sHTMLGeneratedSelectStructure,
    (isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

    foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
    {
        if(((int) $aDataRow['COMP_DATA_ACCESS']) >= $IniUserAccess)
        {
            //Data Row
            printf("
            <div class='data-block'>
                <form method='POST'>
                    <div><h5>%s</h5></div>
                    <div>
                        <div><b><p>Creation Date</p></b></div>
                        <div><p>%s</p></div>
                    </div>",
                    $aDataRow['COMP_DATA_TITLE'],
                    $aDataRow['COMP_DATA_DATE']);


            //Data Row - country title
            if((((int) $aDataRow['COUN_DATA_ACCESS']) >= $IniUserAccess))
            {
                printf("
                    <div>
                        <div><b><p>Country</p></b></div>
                        <div><p>%s</p></div>
                    </div>",
                    $aDataRow['COUN_DATA_TITLE']);
            }

            if(((int) $aDataRow['COU_DATA_ACCESS']) >= $IniUserAccess)
            {
                printf("
                    <div>
                        <div><b><p>County</p></b></div>
                        <div><p>%s</p></div>
                    </div>
                    <div>
                        <div><b><p>Tax</p></b></div>
                        <div><p>%s</p></div>
                    </div>
                    <div>
                        <div><b><p>Interest Rate</p></b></div>
                        <div><p>%s</p></div>
                    </div>",
                    $aDataRow['COU_DATA_TITLE'],
                    $aDataRow['COU_DATA_TAX'],
                    $aDataRow['COU_DATA_IR']);
            }

            //Button list for specific Data Row
            printf("
                    <div>
                        <input type='hidden' name='CompIndex' value='%d'>
                        <input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
                        <input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
                    </div>
                </form>
            </div> ",
            $aDataRow['COMP_ID'],
            $GLOBALS['MENU']['COMPANY']['INDEX'],
            $GLOBALS['MODULE']['DELETE'],
            $GLOBALS['MENU']['COMPANY']['INDEX'],
            $GLOBALS['MODULE']['EDIT']);
        }
        else
            $InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);
    }

    printf("
        <div>
            <form action='.' method='get'>
                <input type='button' name='PageIndex' value='%d'><label>page</label>
            </form>
        </div>",
        1);
}
?>