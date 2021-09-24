<?php
//-------------<FUNCTION>-------------//
function HTMLJobEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['JobIndex']) && !empty($_POST['JobIndex']))
    {
        $iJobIndex = (int) $_POST['JobIndex'];

        if($iJobIndex > 0)
        {
            $rResult = JobEditSpecificRetriever($InrConn, $InrLogHandle, $iJobIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $sJobEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                $sJobEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Job</h3><h4>".$aDataRow['JOB_DATA_TITLE']."</h4></div>
                            <div><label><p>Name*</p><input name='Name' type='text' placeholder='Job name' value='".$aDataRow['JOB_DATA_TITLE']."' required></label></div>
                            <div><label><p>Price</p><input name='Price' step='0.01' min='0.0' type='number' placeholder='Job price' value='".$aDataRow['JOB_INC_PRICE']."'></label></div>
                            <div><label><p>Payment in advance</p><input name='PIA' type='number' step='0.01' min='0.0' placeholder='Job Payment in advance' value='".$aDataRow['JOB_INC_PIA']."'></label></div>
                            <div><label><p>Expenses</p><input name='Expenses' type='number' step='0.01' min='0.0' placeholder='Job expensess' value='".abs($aDataRow['JOB_OUT_EXPENSES'])."'></label></div>
                            <div><label><p>Damage</p><input name='Damage' type='number' step='0.01' min='0.0' placeholder='Job Damage expensess' value='".abs($aDataRow['JOB_OUT_DAMAGE'])."'></label></div>
                            <div><label><p>Date*</p><input name='Date' type='Date' value='".$aDataRow['JOB_DATA_DATE']."' required></label></div>
                            <div><label><p>Company</p> ".RenderCompanySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['COMP_ID'])."</label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['JOB_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='JobIndex' value='".$aDataRow['JOB_ID']."' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                print($sJobEditFormHTML);

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