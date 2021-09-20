<?php
//-------------<FUNCTION>-------------//
function HTMLEmployeePositionEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['EmpPosIndex']) && !empty($_POST['EmpPosIndex']))
    {
        $iEmployeePositionIndex = (int) $_POST['EmpPosIndex'];

        if($iEmployeePositionIndex > 0)
        {
            $rResult = EmployeePositionSpecificRetriever($InrConn, $InrLogHandle, $iEmployeePositionIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                //Title
                printf("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Employee Position</h3><br><h4>%s</h4></div>
                            <div><label>Title*<input type='text' name='Name' placeholder='title position' value='%s' required></label></div>
                        </div>",
                $aDataRow['EMP_POS_TITLE'],
                $aDataRow['EMP_POS_TITLE']);

                //get rows and render <select> element with data
                print(" <div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['EMP_POS_ACCESS']);
                print(" </label></div>");

                //Button Input
                printf("
                        <div>
                            <input type='hidden' value='%s' name='EmpPosIndex'>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%s&Module=%s&ProEdit'>
                            <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>",
                $aDataRow['EMP_POS_ID'],
                $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX'],
                $GLOBALS['MODULE']['EDIT'],
                $GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']);

                $rResult->free();
            }
            else
                $InrLogHandle->AddLogMessage("Query did not return any row", __FILE__, __FUNCTION__, __LINE__);
        }
        else
            $InrLogHandle->AddLogMessage("POST data could not be converted to required format", __FILE__, __FUNCTION__, __LINE__);
	}
	else
        $InrLogHandle->AddLogMessage("Some POST data are not initialized", __FILE__, __FUNCTION__, __LINE__);
}
?>