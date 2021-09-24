<?php
function HTMLJobAssigmentAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    require_once("Struct/Element/Function/Select/DBSelectRender.php");

    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Job Assigment</h3></div>
                <div><label><p>Name</p><input name='Name' type='text' placeholder='Job name' required></label></div>
                <div><label><p>Price</p><input name='Price' type='number' placeholder='Job price' required></label></div>
                <div><label><p>Payment in advance</p><input name='PIA' type='number' placeholder='Job Payment in advance'></label></div>
                <div><label><p>Expenses</p><input name='Expenses' type='number' placeholder='Job expensess'></label></div>
                <div><label><p>Damage</p><input name='Damage' type='number' placeholder='Job Damage expensess'></label></div>
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
                <input type='submit' value='Save' formaction='.?MenuIndex=%d&%d&ProAdd'>
                <a href='.?MenuIndex=%d'><div class='Button-Left'><h5>Cancel</h5></div></a>
            </div>
        </form>
    </div>",
    $GLOBALS['MENU']['JobAssigment']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['JobAssigment']['INDEX']);
}
?>
