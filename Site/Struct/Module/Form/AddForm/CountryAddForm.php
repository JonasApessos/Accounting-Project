<?php
function HTMLCountryAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sCountryAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sCountryAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Country</h3></div>
                <div><label><p>Name*</p><input type='text' placeholder='Country name' name='Name' required></label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";

    print($sCountryAddFormHTML);
}
?>
