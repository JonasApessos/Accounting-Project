<?php
 //Render element <select> with the Country array result from query
function RenderCountrySelectRow(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail) : string
{
    if(CheckAccessRange($IniUserAccess) && ($IniIsAvail > 0 && $IniIsAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE'])) 
    {
        $rResult = CountrySelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);

        if(!empty($rResult) && ($rResult->num_rows > 0))
        {
            $sCountrySelectHTML = "";
            
            $sCountrySelectHTML .= "<select name='Country'>";
            foreach($rResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
                $sCountrySelectHTML .= "<option value='".$aDataRow['COUN_ID']."'>".$aDataRow['COUN_DATA_TITLE']."</option>";
            $sCountrySelectHTML .= "</select>";

            $rResult->free();

            return $sCountrySelectHTML;
        }
        else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __FUNCTION__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __FUNCTION__, __LINE__);

    return "";
}

 //Render element <select> with the Country array result from query
function RenderCountrySelectRowCheck(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail, int $IniSelected = 0) : string
{
    if(($IniUserAccess > 0) && ($IniIsAvail > 0 && $IniIsAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']) && ($IniSelected > 0)) 
    {
        $rResult = CountrySelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);

        if(!empty($rResult) && ($rResult->num_rows > 0))
        {
            $sCountrySelectHTML = "";

            $sCountrySelectHTML .= "<select name='Country'>";
            foreach($rResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
                $sCountrySelectHTML .= "<option value='".$aDataRow['COUN_ID']."' ".($IniSelected == (int) $aDataRow['COUN_ID'] ? "selected" : "").">".$aDataRow['COUN_DATA_TITLE']."</option>";
            $sCountrySelectHTML .= "</select>";

            $rResult->free();

            return $sCountrySelectHTML;
        }
        else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __FUNCTION__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __FUNCTION__, __LINE__);

    return "";
}
?>