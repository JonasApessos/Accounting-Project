<?php
function HTMLEmployeeAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    $sEmployeeAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sEmployeeAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Employee</h3></div>
                <div><label><p>Name*</p><input type='text' name='Name' placeholder='Employee Name' required></label></div>
                <div><label><p>Surname*</p><input type='text' name='Surname' placeholder='Employee Surname' required></label></div>
                <div><label><p>Temporary Password*</p><input type='password' placeholder='Employee Temporary Password' name='Pass' required></label></div>
                <div><label><p>Email*</p><input type='email' name='Email' placeholder='Employee Email' required></label></div>
                <div><label><p>Salary</p><input type='number' name='Salary' min='0.00' step='0.01' placeholder='Employee Salary'></label></div>
                <div><label><p>Birth Date*</p><input type='date' name='BDay' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' required></label></div>
                <div><label><p>Phone Number*</p><input type='tel' max='16' name='PN' required></label></div>
                <div><label><p>Stable Number</p><input type='tel' max='16' name='SN'></label></div>
                <div><label><p>Company</p> ".RenderCompanySelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                <div><label><p>Position</p> ".RenderEmployeePosSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";

    print($sEmployeeAddFormHTML);
}
?>
