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
                $aDataRow = $rResult->fetch_assoc();

                print("");

                //Title
                print("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Shareholder</h3></div>
                        </div>");

                //Input Row - employee list
                print("<div><label>Employee");
                RenderEmployeeSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['EMP_ID']);
                print("</label></div>");

                //Input Row - access list
                print("<div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['SHARE_ACCESS']);
                print("</label></div>");

                printf("
                        <div>
                            <input type='hidden' value='%s' name='ShareIndex' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProEdit'>
                            <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>",
                $aDataRow['SHARE_ID'],
                $GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
                $GLOBALS['MODULE']['EDIT'],
                $GLOBALS['MENU']['SHAREHOLDER']['INDEX']);

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