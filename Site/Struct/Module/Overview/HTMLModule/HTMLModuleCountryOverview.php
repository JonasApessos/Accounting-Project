<?php
require_once("../MedaLib/Function/SQL/SQLStatementExec.php");
require_once("../MedaLib/Function/Generator/HTMLSelectStructure.php");
require_once("Output/Retriever/CountryRetriever.php");

function HTMLCountryOverview(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    $sSearchQuery = (isset($_GET['SearchQuery'])) ? htmlspecialchars($_GET['SearchQuery']) : "";
    $sSearchType = (isset($_GET['SearchType'])) ? htmlspecialchars($_GET['SearchType']) : "";

    $rCounListResult = 0;

    if(!$rCounListResult = CountryOverviewRetriever($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $sSearchType, $sSearchQuery))
        $InrLogHandle->AddLogMessage("Failed to get result from Company Retriever" , __FILE__, __FUNCTION__, __LINE__);
    else
    {		
        HTMLCountryOverviewDataBlock($rCounListResult, $InrLogHandle, $IniUserAccess);

        $rCounListResult->free();
    }
}

function HTMLCountryOverviewDataBlock(mysqli_result &$InrResult, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    $sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COUNTRY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CountryQueryDataType()");

    //The toolbar for the buttons (tools)
    printf("
    <div class='content-tool-bar'>
        <a href='.?MenuIndex=%d&Module=%d'>
            <div class='button-left'><h5>ADD</h5></div>
        </a>
        <form action='.' method='get'>
            <input type='hidden' name='MenuIndex' value='%d'><label>Search by%s</label>
            <label>Query <input id='QueryInput' type='text' name='SearchQuery' value='%s'></label>
            <button>submit</button>
        </form>
    </div>",
    $GLOBALS['MENU']['COUNTRY']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['COUNTRY']['INDEX'],
    $sHTMLGeneratedSelectStructure,
    (isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "");

    foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
    {
        if(((int) $aDataRow['COUN_DATA_ACCESS']) >= $IniUserAccess)
        {
            //Data Row - country title
            printf("
            <div class='data-block'>
                <form method='POST'>
                    <div>
                        <div><h5>%s</h5></div>
                    </div>
                    <div>
                        <input type='hidden' name='CounIndex' value='%d'>
                        <input type='submit' value='Delete' formaction='.?MenuIndex=%d&Module=%d'>
                        <input type='submit' value='Edit' formaction='.?MenuIndex=%d&Module=%d'>
                    </div>
                </form>
            </div>",
            $aDataRow['COUN_DATA_TITLE'],
            $aDataRow['COUN_ID'],
            $GLOBALS['MENU']['COUNTRY']['INDEX'],
            $GLOBALS['MODULE']['DELETE'],
            $GLOBALS['MENU']['COUNTRY']['INDEX'],
            $GLOBALS['MODULE']['EDIT']);
        }
        else
            $InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);
    }
}
?>
