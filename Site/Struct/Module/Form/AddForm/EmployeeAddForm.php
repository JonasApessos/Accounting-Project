<?php
function HTMLEmployeeAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New Employee</h3></div>
                <div><label>Name*<input type='text' name='Name' placeholder='Employee Name' required></label></div>
                <div><label>Surname*<input type='text' name='Surname' placeholder='Employee Surname' required></label></div>
                <div><label>Temporary Password*<input type='password' placeholder='Employee Temporary Password' name='Pass' required></label></div>
                <div><label>Email*<input type='email' name='Email' placeholder='Employee Email' required></label></div>
                <div><label>Salary<input type='number' name='Salary' min='0.00' step='0.01' placeholder='Employee Salary'></label></div>
                <div><label>Birth Date*<input type='date' name='BDay' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' required></label></div>
                <div><div><h5>Phone Number*</h5></div><div><input type='tel' max='16' name='PN' required></div></div>
                <div><label>Stable Number<input type='tel' max='16' name='SN'></label></div>
            </div>");

    //get rows and render <select> element with data
    print(" <div><label>Company");
    RenderCompanySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    //get rows and render <select> element with data
    print(" <div><label>Position");
    RenderEmployeePosSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
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
    $GLOBALS['MENU']['EMPLOYEE']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['EMPLOYEE']['INDEX']);
}
?>
