<?php
//-------------<FUNCTION>-------------//
function HTMLEmployeeEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['EmpIndex']) && !empty($_POST['EmpIndex']))
    {
        $iEmployeeIndex = (int) $_POST['EmpIndex'];
        
        if($iEmployeeIndex > 0)
        {
            $rResult = EmployeeEditFormSpecificRetriever($InrConn, $InrLogHandle, $iEmployeeIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $sEmployeeEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                $sEmployeeEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Employee</h3><br><h4>".$aDataRow['EMP_DATA_NAME']." ".$aDataRow['EMP_DATA_SURNAME']."</h4></div>
                            <div><label><p>Name*</p><input type='text' name='Name' placeholder='Employee Name' value='".$aDataRow['EMP_DATA_NAME']."' required></label></div>
                            <div><label><p>Surname*</p><input type='text' name='Surname' placeholder='Employee Surname' value='".$aDataRow['EMP_DATA_SURNAME']."' required></label></div>
                            <div><label><p>Email*</p><input type='email' name='Email' placeholder='Employee Email' value='".$aDataRow['EMP_DATA_EMAIL']."' required></label></div>
                            <div><label><p>Salary</p><input type='number' name='Salary' min='0.00' step='0.01' value='".$aDataRow['EMP_DATA_SALARY']."' placeholder='Employee Salary'></label></div>
                            <div><label><p>Birth Date*</p><input type='date' name='BDay' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' value='".$aDataRow['EMP_DATA_BDAY']."' required></label></div>
                            <div><label><p>Phone Number*</p><input type='tel' max='16' name='PN' value='".$aDataRow['EMP_DATA_PN']."' required></label></div>
                            <div><label><p>Stable Number</p><input type='tel' max='16' name='SN' value='".$aDataRow['EMP_DATA_SN']."'></label></div>
                            <div><label><p>Company</p> ".RenderCompanySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COMP_ID'])."</label></div>
                            <div><label><p>Position</p> ".RenderEmployeePosSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['EMP_POS_ID'])."</label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['EMP_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='EmployeeIndex' value='".$aDataRow['EMP_ID']."'>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </div>
                </form>";

                print($sEmployeeEditFormHTML);

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