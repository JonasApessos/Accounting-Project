<?php
function HTMLCountyAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sCountyAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sCountyAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New County</h3></div>
                <div><label><p>Name*</p><input type='text' placeholder='County name' name='Name' required></label></div>
                <div><label><p>Tax</p><input type='number' placeholder='County Tax' name='Tax' step='0.01' min='0.00' max='100.00'></label></div>
                <div><label><p>Interest Rate</p><input type='number' placeholder='County Interest Rate' name='IR' step='0.01' min='0.00' max='100.00'></label></div>
                <div><label><p>Country</p> ".RenderCountrySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";


    print($sCountyAddFormHTML);
}
?>
