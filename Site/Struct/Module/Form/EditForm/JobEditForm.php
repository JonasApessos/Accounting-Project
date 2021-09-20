<?php
//-------------<FUNCTION>-------------//
function HTMLJobEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['JobIndex']) && !empty($_POST['JobIndex']))
    {
        $iJobIndex = (int) $_POST['JobIndex'];

        if($iJobIndex > 0)
        {
            $rResult = JobEditSpecificRetriever($InrConn, $InrLogHandle, $iJobIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                printf("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Job</h3><h4>%s</h4></div>
                            <div><label>Name*<input name='Name' type='text' placeholder='Job name' value='%s' required></label></div>
                            <div><label>Price<input name='Price' step='0.01' min='0.0' type='number' placeholder='Job price' value='%s'></label></div>
                            <div><label>Payment in advance<input name='PIA' type='number' step='0.01' min='0.0' placeholder='Job Payment in advance' value='%s'></label></div>
                            <div><label>Expenses<input name='Expenses' type='number' step='0.01' min='0.0' placeholder='Job expensess' value='%s'></label></div>
                            <div><label>Damage<input name='Damage' type='number' step='0.01' min='0.0' placeholder='Job Damage expensess' value='%s'></label></div>
                            <div><label>Date*<input name='Date' type='Date' value='%s' required></label></div>
                        </div>",
                $aDataRow['JOB_DATA_TITLE'],
                $aDataRow['JOB_DATA_TITLE'],
                $aDataRow['JOB_INC_PRICE'],
                $aDataRow['JOB_INC_PIA'],
                abs($aDataRow['JOB_OUT_EXPENSES']),
                abs($aDataRow['JOB_OUT_DAMAGE']),
                $aDataRow['JOB_DATA_DATE']);

                //Input Row - company list
                print("<div><label>Company");
                RenderCompanySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['COMP_ID']);
                print("</label></div>");

                //Input Row - access list
                print("<div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], (int) $aDataRow['JOB_ACCESS']);
                print("</label></div>");

                printf("
                        <div>
                            <input type='hidden' name='JobIndex' value='%s' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProEdit'>
                            <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>",
                $aDataRow['JOB_ID'],
                $GLOBALS['MENU']['JOB']['INDEX'],
                $GLOBALS['MODULE']['EDIT'],
                $GLOBALS['MENU']['JOB']['INDEX']);

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