<?php
//-------------<FUNCTION>-------------//
function HTMLEmployeeEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['EmpIndex']) && !empty($_POST['EmpIndex']))
    {
        $iEmployeeIndex = (int) $_POST['EmpIndex'];
        
        if($iEmployeeIndex > 0)
        {
            $rResult = EmployeeEditFormSpecificRetriever($InrConn, $InrLogHandle, $iEmployeeIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['Show']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//
                print("<div class='Form'><form method='POST'><div>");

                //Title
                printf("<div id='FormTitle'><h3>Edit Employee</h3><br><h4>%s %s</h4></div>", $aDataRow['EMP_DATA_NAME'], $aDataRow['EMP_DATA_SURNAME']);

                //Input Row - name
                printf("<div><label>Name*<input type='text' name='Name' placeholder='Employee Name' value='%s' required></label></div>", $aDataRow['EMP_DATA_NAME']);

                //Input Row - surname
                printf("<div><label>Surname*<input type='text' name='Surname' placeholder='Employee Surname' value='%s' required></label></div>", $aDataRow['EMP_DATA_SURNAME']);

                //Input Row - email
                printf("<div><label>Email*<input type='email' name='Email' placeholder='Employee Email' value='%s' required></label></div>", $aDataRow['EMP_DATA_EMAIL']);

                //Input Row - salary
                printf("<div><label>Salary<input type='number' name='Salary' min='0.00' step='0.01' value='%s' placeholder='Employee Salary'></label></div>", $aDataRow['EMP_DATA_SALARY']);

                //Input Row - birth date
                printf("<div><label>Birth Date*<input type='date' name='BDay' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' value='%s' required></label></div>", $aDataRow['EMP_DATA_BDAY']);

                //Input Row - phone number
                printf("<div><label>Phone Number*<input type='tel' max='16' name='PN' value='%s' required></label></div>", $aDataRow['EMP_DATA_PN']);

                //Input Row - stable number
                printf("<div><label>Stable Number<input type='tel' max='16' name='SN' value='%s'></label></div>", $aDataRow['EMP_DATA_SN']);

                //get rows and render <select> element with data
                print("<div><label>Company");
                RenderCompanySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['Show'], $aDataRow['COMP_ID']);
                print("</label></div>");

                //get rows and render <select> element with data
                print("<div><label>Position");
                RenderEmployeePosSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['Show'], $aDataRow['EMP_POS_ID']);
                print("</label></div>");

                //get rows and render <select> element with data
                print("<div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['Show'], $aDataRow['EMP_ACCESS']);
                print("</label></div></div>");

                printf("<div><input type='hidden' name='EmployeeIndex' value='%s'>", $aDataRow['EMP_ID']);
                printf("<input type='submit' value='Save' formaction='.?MenuIndex=%s&Module=%s&ProEdit'>", $GLOBALS['MENU_INDEX']['Employee'], $GLOBALS['MODULE']['Edit']);
                printf("<a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a></div>", $GLOBALS['MENU_INDEX']['Employee']);

                print("</div></form>");

                $rResult->free();
            }
            else
                $InrLogHandle->AddLogMessage("empty or too many rows returned, expected 1 result", __FILE__, __FUNCTION__, __LINE__);
        }
        else
            $InrLogHandle->AddLogMessage("ID expected to be greater than 0, instead value was lesser", __FILE__, __FUNCTION__, __LINE__);
	}
	else
        $InrLogHandle->AddLogMessage("ID was not set or returned empty", __FILE__, __FUNCTION__, __LINE__);
}
?>