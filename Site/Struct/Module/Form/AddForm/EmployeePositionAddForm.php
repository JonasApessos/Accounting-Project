<?php
function HTMLEmployeePositionAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New Employee Position</h3></div>
                <div><label>Title*<input type='text' name='Name' placeholder='title position' required></label></div>
            </div>");


    //get rows and render <select> element with data
    print(" <div><label>Access");
    RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //Button Input
    printf("
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>
                <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>",
    $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']);
}
?>
