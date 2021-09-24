<?php
function HTMLEmployeePositionAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sEmployeePositionAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sEmployeePositionAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Employee Position</h3></div>
                <div><label><p>Title*</p><input type='text' name='Name' placeholder='title position' required></label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";

    //Button Input
    print($sEmployeePositionAddFormHTML);
}
?>
