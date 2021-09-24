<?php
//-------------<FUNCTION>-------------//
function HTMLShareholderEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['ShareIndex']) && !empty($_POST['ShareIndex']))
    {
        $iShareholderIndex = (int) $_POST['ShareIndex'];

        if($iShareholderIndex > 0)
        {
            $rResult = ShareholderSpecificRetriever($InrConn, $InrLogHandle, $iShareholderIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $sShareholderEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //Title
                $sShareholderEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Shareholder</h3></div>
                            <div><label><p>Employee</p> ".RenderEmployeeSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['EMP_ID'])."</label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['SHARE_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' value='".$aDataRow['SHARE_ID']."' name='ShareIndex' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                print($sShareholderEditFormHTML);

                $rResult->free();
            }
            else
                $InrLogHandle->AddLogMessage("Query did not return any row", __FILE__, __FUNCTION__, __LINE__);
        }
        else
            $InrLogHandle->AddLogMessage("POST data could not be converted to required format", __FILE__, __FUNCTION__, __LINE__);
	}
	else
        $InrLogHandle->AddLogMessage("Some POST data are not initialized", __FILE__, __FUNCTION__, __LINE__);
}
?>