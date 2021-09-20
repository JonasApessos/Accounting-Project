<?php
function HTMLJobAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New Job</h3></div>
                <div><label>Name*<input name='Name' type='text' placeholder='Job name' required></label></div>
                <div><label>Price<input name='Price' step='0.01' min='0.0' type='number' placeholder='Job price'></label></div>
                <div><label>Payment in advance<input name='PIA' type='number' step='0.01' min='0.0' placeholder='Job Payment in advance'></label></div>
                <div><label>Expenses<input name='Expenses' type='number' step='-0.01' min='0.0' placeholder='Job expensess'></label></div>
                <div><label>Damage<input name='Damage' type='number' step='-0.01' min='0.0' placeholder='Job Damage expensess'></label></div>
                <div><label>Date*<input name='Date' type='Date' required></label></div>
            </div>");

    //Input Row - company list
    print(" <div><label>Company");
    RenderCompanySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //Input Row - access list
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
    $GLOBALS['MENU']['JOB']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['JOB']['INDEX']);
}
?>
