<?php
//Render element <select> with the County array result from query
function RenderCountySelectRow(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail) : string
{
	if(CheckAccessRange($IniUserAccess) && ($IniIsAvail > 0 && $IniIsAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
		$rResult = CountySelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);

		if(!empty($rResult) && ($rResult->num_rows > 0))
		{
			$sCountySelectHTML = "";

			$sCountySelectHTML .= "<select name='County'>";
			foreach($rResult as $aDataRow)
				$sCountySelectHTML .= "<option value='".$aDataRow['COU_ID']."'>".$aDataRow['COU_DATA_TITLE']."</option>";
			$sCountySelectHTML .= "</select>";

			$rResult->free();

			return $sCountySelectHTML;
		}
		else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __METHOD__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __METHOD__, __LINE__);

	return "";
}

//Render element <select> with the County array result from query
function RenderCountySelectRowCheck(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail, int $IniSelected = 0) : string
{
	if(CheckAccessRange($IniUserAccess) && ($IniIsAvail > 0 && $IniIsAvail <= $GLOBALS['AVAILABLE_ARRAY_SIZE']))
	{
		$rResult = CountySelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);
		
		if(!empty($rResult) && ($rResult->num_rows > 0))
		{
			$sCountySelectHTML = "";

			$sCountySelectHTML .= "<select name='County'>";
			foreach ($rResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
				$sCountySelectHTML .= "<option value='".$aDataRow['COU_ID']."' ".($IniSelected == (int) $aDataRow['COU_ID'] ? "selected" : "").">".$aDataRow['COU_DATA_TITLE']."</option>";
			$sCountySelectHTML .= "</select>";

			$rResult->free();

			return $sCountySelectHTML;
		}
		else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __METHOD__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __METHOD__, __LINE__);

	return "";
}
?>