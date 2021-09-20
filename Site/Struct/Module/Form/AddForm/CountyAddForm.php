<?php
function HTMLCountyAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New County</h3></div>
                <div><label>Name*<input type='text' placeholder='County name' name='Name' required></label></div>
                <div><label>Tax<input type='number' placeholder='County Tax' name='Tax' step='0.01' min='0.00' max='100.00'></label></div>
                <div><label>Interest Rate<input type='number' placeholder='County Interest Rate' name='IR' step='0.01' min='0.00' max='100.00'></label></div>
            </div>");

    //get rows and render <select> element with data
    print(" <div><label>Country");
    RenderCountrySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //get rows and render <select> element with data
    print(" <div><label>Access");
    RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    printf("
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>
                <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>",
    $GLOBALS['MENU']['COUNTY']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['COUNTY']['INDEX']);
}
?>
