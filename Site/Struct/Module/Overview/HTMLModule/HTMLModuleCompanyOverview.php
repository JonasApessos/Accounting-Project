<?php
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
    $sCompHtml = "";

    $sSearchSelectStructName = "SearchType";
    $sHTMLGeneratedSelectStructure = "";
    $sSearchTypeSelected = isset($_GET[$sSearchSelectStructName]) ? $_GET[$sSearchSelectStructName] : "";

    HTMLGenerateSelectStructure($sHTMLGeneratedSelectStructure, $sSearchSelectStructName, $GLOBALS['COMPANY_SEARCH_TYPE'], $sSearchTypeSelected, "QueryDataType", "onchange", "CompanyQueryDataType()");

    //The toolbar for the buttons (tools)
    $sCompHtml .= "
    <div class='content-tool-bar'>
        <a href='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."'>
            <div class='button-left'><p><b>ADD</b></p></div>
        </a>
        <div>
            <form action='.' method='get'>
                <input type='hidden' name='MenuIndex' value='".$GLOBALS['MENU']['COMPANY']['INDEX']."'><label>Search by ".$sHTMLGeneratedSelectStructure."</label>
                <label>Query <input type='text' id='QueryInput' name='SearchQuery' value='".((isset($_GET['SearchQuery'])) ? $_GET['SearchQuery'] : "")."'></label>
                <button class='button-right'><p><b>Search</b></p></button>
            </form>
        </div>
    </div>";

    foreach($InrResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
    {
        if(((int) $aDataRow['COMP_DATA_ACCESS']) >= $IniUserAccess)
        {
            //Data Row
            $sCompHtml .= "
            <div class='data-block'>
                <form method='POST'>
                    <div><h5>".$aDataRow['COMP_DATA_TITLE']."</h5></div>
                    <div>
                        <div><b><p>Creation Date</p></b></div>
                        <div><p>".date("d/m/Y", strtotime($aDataRow['COMP_DATA_DATE']))."</p></div>
                    </div>";


            //Data Row - country title
            if((((int) $aDataRow['COUN_DATA_ACCESS']) >= $IniUserAccess))
            {
                $sCompHtml .= "
                    <div>
                        <div><b><p>Country</p></b></div>
                        <div><p>".$aDataRow['COUN_DATA_TITLE']."</p></div>
                    </div>";
            }

            if(((int) $aDataRow['COU_DATA_ACCESS']) >= $IniUserAccess)
            {
                $sCompHtml .= "
                    <div>
                        <div><b><p>County</p></b></div>
                        <div><p>".date("d/m/Y", strtotime($aDataRow['COU_DATA_TITLE']))."</p></div>
                    </div>
                    <div>
                        <div><b><p>Tax</p></b></div>
                        <div><p>".number_format($aDataRow['COU_DATA_TAX'], 2)."%</p></div>
                    </div>
                    <div>
                        <div><b><p>Interest Rate</p></b></div>
                        <div><p>".number_format($aDataRow['COU_DATA_IR'], 2)."%</p></div>
                    </div>";
            }

            //Button list for specific Data Row
            $sCompHtml .= "
                    <div>
                        <input type='hidden' name='CompIndex' value='".$aDataRow['COMP_ID']."'>
                        <input type='submit' value='Delete' formaction='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."&Module=".$GLOBALS['MODULE']['DELETE']."'>
                        <input type='submit' value='Edit' formaction='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."'>
                    </div>
                </form>
            </div> ";
        }
        else
            $InrLogHandle->AddLogMessage("Access was denied, not enought privilege to retrieve data from query", __FILE__, __FUNCTION__, __LINE__);

        
    }

    $sCompHtml .= "
        <div>
            <form action='.' method='get'>
                <input type='button' name='PageIndex' value='1'><label>page</label>
            </form>
        </div>";

    print($sCompHtml);
}
?>