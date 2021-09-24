<?php
//Render element <select> with the Employee array result from query
function RenderEmployeeSelectRow(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail) : string
{
	if(CheckAccessRange($IniUserAccess) && CheckRange($IniIsAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0))
	{
		$rResult = EmployeeSelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);

		if(!empty($rResult) && ($rResult->num_rows > 0))
		{
			$sEmployeeSelectHTML = "";

			$sEmployeeSelectHTML .= "<select name='Employee'>";
			foreach($rResult->fetch_all((MYSQLI_ASSOC)) as $aDataRow)
				$sEmployeeSelectHTML .= "<option value='".$aDataRow['EMP_ID']."'>".$aDataRow['EMP_DATA_NAME']."</option>";
			$sEmployeeSelectHTML .= "</select>";

			$rResult->free();

			return $sEmployeeSelectHTML;
		}
		else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __FUNCTION__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __FUNCTION__, __LINE__);

	return "";
}

//Render element <select> with the Employee array result from query
function RenderEmployeeSelectRowCheck(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess, int $IniIsAvail, int $IniSelected = 0) : string
{
	if(CheckAccessRange($IniUserAccess) && CheckRange($IniIsAvail, $GLOBALS['AVAILABLE_ARRAY_SIZE'], 0) && ($IniSelected > 0))
	{
		$rResult = EmployeeSelectElemRetriever($InrConn, $InrLogHandle, $IniUserAccess, $IniIsAvail);

		if(!empty($rResult) && ($rResult->num_rows > 0))
		{
			$sEmployeeSelectHTML = "";

			$sEmployeeSelectHTML .= "<select name='Employee'>";
			foreach($rResult->fetch_all(MYSQLI_ASSOC) as $aDataRow)
				$sEmployeeSelectHTML .= "<option value='".$aDataRow['EMP_ID']."' ".($IniSelected == (int) $aDataRow['EMP_ID'] ? "selected" : "").">".$aDataRow['EMP_DATA_NAME']."</option>";
			$sEmployeeSelectHTML .= "</select>";

			$rResult->free();

			return $sEmployeeSelectHTML;
		}
		else
            $InrLogHandle->AddLogMessage("result cannot return empty list", __FILE__, __FUNCTION__, __LINE__);
    }
    else
        $InrLogHandle->AddLogMessage("One or more of the input parameters are out of range", __FILE__, __FUNCTION__, __LINE__);

	return "";
}
?>