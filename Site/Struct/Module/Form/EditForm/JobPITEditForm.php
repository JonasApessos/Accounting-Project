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
                $sJobPITEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //Input Row - payment
                $sJobPITEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Payment</h3></div>
                            <div><label><p>Payment</p><input type='number' name='PIT' value='".$aDataRow['JOB_PIT_PAYMENT']."'></label></div>
                            <div><label><p>Date*</p><input type='date' name='Date' value='".$aDataRow['JOB_PIT_DATE']."' required></label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['JOB_PIT_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='JobPITIndex' value='".$aDataRow['JOB_PIT_ID']."'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."&SubModule=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                        </div>
                    </form>
                </div>";

                print($sJobPITEditFormHTML);

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