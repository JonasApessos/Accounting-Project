<?php
//-------------<FUNCTION>-------------//
function HTMLJobPITEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['JobPITIndex']) && !empty($_POST['JobPITIndex']))
    {
        $iJobPITIndex = (int) $_POST['JobPITIndex'];

        if($iJobPITIndex > 0)
        {
            $rResult = JobPITSpecificRetriever($InrConn, $InrLogHandle, $iJobPITIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //Input Row - payment
                printf("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Payment</h3></div>
                            <div><label>Payment<input type='number' name='PIT' value='%s'></label></div>
                            <div><label>Date*<input type='date' name='Date' value='%s' required></label></div>
                        </div>",
                $aDataRow['JOB_PIT_PAYMENT'],
                $aDataRow['JOB_PIT_DATE']);

                //Input Row - access list
                print("<div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['JOB_PIT_ACCESS']);
                print("</label></div>");

                printf("
                        <div>
                            <input type='hidden' name='JobPITIndex' value='%d'>
                            <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&SubModule=%d&ProEdit'>
                        </div>
                    </form>
                </div>",
                $aDataRow['JOB_PIT_ID'],
                $GLOBALS['MENU']['JOB']['INDEX'],
                $GLOBALS['MENU']['JOB']['INDEX'],
                $GLOBALS['MODULE']['EXTEND'],
                $GLOBALS['MODULE']['EDIT']);

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