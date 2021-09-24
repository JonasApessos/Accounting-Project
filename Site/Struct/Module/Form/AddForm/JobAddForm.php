<?php
function HTMLJobAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sJobAddFormHTMl = "";

    //-------------<PHP-HTML>-------------//
    $sJobAddFormHTMl .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Job</h3></div>
                <div><label><p>Name*</p><input name='Name' type='text' placeholder='Job name' required></label></div>
                <div><label><p>Price</p><input name='Price' step='0.01' min='0.0' type='number' placeholder='Job price'></label></div>
                <div><label><p>Payment in advance</p><input name='PIA' type='number' step='0.01' min='0.0' placeholder='Job Payment in advance'></label></div>
                <div><label><p>Expenses</p><input name='Expenses' type='number' step='-0.01' min='0.0' placeholder='Job expensess'></label></div>
                <div><label><p>Damage</p><input name='Damage' type='number' step='-0.01' min='0.0' placeholder='Job Damage expensess'></label></div>
                <div><label><p>Date*</p><input name='Date' type='Date' required></label></div>
                <div><label><p>Company</p>".RenderCompanySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                <div><label><p>Access</p>".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['JOB']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";

    print($sJobAddFormHTMl);
}
?>
