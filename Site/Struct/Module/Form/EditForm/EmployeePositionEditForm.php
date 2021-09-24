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
                $sEmployeePositionEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                //Title
                $sEmployeePositionEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Employee Position</h3><br><h4>".$aDataRow['EMP_POS_TITLE']."</h4></div>
                            <div><label><p>Title*</p><input type='text' name='Name' placeholder='title position' value='".$aDataRow['EMP_POS_TITLE']."' required></label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['EMP_POS_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' value='".$aDataRow['EMP_POS_ID']."' name='EmpPosIndex'>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['EMPLOYEE_POSITION']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                //Button Input
                print($sEmployeePositionEditFormHTML);

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