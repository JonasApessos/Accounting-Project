<?php
//-------------<FUNCTION>-------------//
function HTMLJobPITAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    if(isset($_POST['JobIndex']) && !empty($_POST['JobIndex']))
    {
        $sJobPITAddFormHTML = "";
        $iJobIndex = (int) $_POST['JobIndex'];

        //-------------<PHP-HTML>-------------//
        $sJobPITAddFormHTML .= "
        <div class='form'>
            <form method='POST'>
                <div>
                    <div id='form-title'><h3>New Payment</h3></div>
                    <div><label><p>Payment</p><input type='number' name='PIT'></label></div>
                    <div><label><p>Date*</p><input type='date' name='Date' required></label></div>
                    <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                </div>
                <div>
                    <input type='hidden' name='JobIndex' value='".$iJobIndex."'>
                    <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['EXTEND']."&SubModule=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                    <a href='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a></div>
                </div>
            </form>
        </div>";

        print($sJobPITAddFormHTML);
    }
    else
        $InrLogHandle->AddLogMessage("Required data not found", __FILE__, __FUNCTION__, __LINE__);
}
?>