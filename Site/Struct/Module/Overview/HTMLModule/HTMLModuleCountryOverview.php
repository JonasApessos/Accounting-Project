<?php
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
    $sCountryHTML = "";

    $sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COUNTRY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CountryQueryDataType()");

    //The toolbar for the buttons (tools)
    $sCountryHTML .= "
    <div class='content-tool-bar'>
        <a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
            <div class='button-left'><p><b>ADD</b></p></div>
        </a>
        <div>
            <form action='.' method='get'>
                <input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['COUNTRY']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
                <label>Query <input id='QueryInput' type='text' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'></label>
                <button class='button-right'><p><b>Search</b></p></button>
            </form>
        </div>
    </div>";

    foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
    {
        if(((int) $aDataRow['COUN_DATA_ACCESS']) >= $IniUserAccess)
        {
            //Data Row - country title
            $sCountryHTML .= "
            <div class='data-block'>
                <form method='POST'>
                    <div><h5>".$aDataRow['COUN_DATA_TITLE']."</h5></div>
                    <div>
                        <input type='hidden' name='CounIndex' value='".$aDataRow['COUN_ID']."'>
                        <input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
                        <input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
                    </div>
                </form>
            </div>";
        }
        else
            $InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);
    }

    print($sCountryHTML);
}
?>
