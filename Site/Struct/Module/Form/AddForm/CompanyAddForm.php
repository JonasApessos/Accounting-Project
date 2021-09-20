<?php
function HTMLCompanyAddForm(ME_CDBConnManager &$InrConn,ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New Company</h3></div>
                <div><label>Name*<input name='Name' type='text' placeholder='Company Name' required></label></div>
                <div><label>creation date*<input name='Date' type='date' required></label></div>
            </div>");

    //get rows and render <select> element with data
    print(" <div><label>County");
    RenderCountySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //get rows and render <select> element with data
    print(" <div><label>Access Type");
    RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //Input Buttons
    printf("
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>
                <a href='.?MenuIndex=%d'><div><p>Cancel</p></div></a>
            </div>
        </form>
    </div>",
    $GLOBALS['MENU']['COMPANY']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['COMPANY']['INDEX']);
}
?>