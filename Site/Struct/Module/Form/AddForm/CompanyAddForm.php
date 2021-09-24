<?php
function HTMLCompanyAddForm(ME_CDBConnManager &$InrConn,ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sCompanyAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sCompanyAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Company</h3></div>
                <div><label><p>Name*</p><input name='Name' type='text' placeholder='Company Name' required></label></div>
                <div><label><p>creation date*</p><input name='Date' type='date' required></label></div>
                <div><label><p>County</p> ".RenderCountySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."'><div><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";

    print($sCompanyAddFormHTML);
}
?>