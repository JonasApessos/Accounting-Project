<?php
//-------------<FUNCTION>-------------//
function HTMLJobPITAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    if(isset($_POST['JobIndex']) && !empty($_POST['JobIndex']))
    {
        $iJobIndex = (int) $_POST['JobIndex'];

        //-------------<PHP-HTML>-------------//
        print("
        <div class='form'>
            <form method='POST'>
                <div>
                    <div id='FormTitle'><h3>New Payment</h3></div>
                    <div><label>Payment<input type='number' name='PIT'></label></div>
                    <div><label>Date*<input type='date' name='Date' required></label></div>
                </div>");

        //Input Row - access list
        print("<div><label>Access");
        RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
        print("</label></div>");

        printf("
                <div>
                    <input type='hidden' name='JobIndex' value='%d'>
                    <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&SubModule=%d&ProAdd'>
                    <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a></div>
                </div>
            </form>
        </div>",
        $iJobIndex,
        $GLOBALS['MENU']['JOB']['INDEX'],
        $GLOBALS['MODULE']['EXTEND'],
        $GLOBALS['MODULE']['ADD'],
        $GLOBALS['MENU']['JOB']['INDEX']);
    }
}
?>