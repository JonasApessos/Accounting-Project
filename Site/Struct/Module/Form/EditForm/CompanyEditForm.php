<?php 
function HTMLCompanyEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['CompIndex']) && !empty($_POST['CompIndex']))
    {
        $iCompanyIndex = (int) $_POST['CompIndex'];

        if($iCompanyIndex > 0)
        {
            $rResult = CompanyEditFormSpecificRetriever($InrConn, $InrLogHandle, $iCompanyIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//
                
                printf("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Company</h3><br><h4>%s</h4></div>
                            <div><label>Name*<input name='Name' type='text' placeholder='Company Name' value='%s' required></label></div>
                            <div><label>creation date*<input name='Date' type='date' value='%s' required></label></div>
                        </div>",
                $aDataRow['COMP_DATA_TITLE'],
                $aDataRow['COMP_DATA_TITLE'],
                $aDataRow['COMP_DATA_DATE']);

                //get rows and render <select> element with data
                print("<div><label>County");
                RenderCountySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COU_ID']);
                print("</label></div>");

                //get rows and render <select> element with data
                print("<div><label>Access Type");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COMP_ACCESS']);
                print("</label></div>");

                //Input Buttons
                printf("
                        <div>
                            <input type='hidden' name='CompIndex' value='%s' required>
                            <a href='.?MenuIndex=%s'><div><p>Cancel</p></div></a>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%s&Module=%s&ProEdit'>
                        </div>
                    </form>
                </div>",
                $aDataRow['COMP_ID'],
                $GLOBALS['MENU']['COMPANY']['INDEX'],
                $GLOBALS['MENU']['COMPANY']['INDEX'],
                $GLOBALS['MODULE']['EDIT']);

                $rResult->free();
            }
            else
                $InrLogHandle->AddLogMessage("empty or too many rows returned, expected single result", __FILE__, __FUNCTION__, __LINE__);
        }
        else
            $InrLogHandle->AddLogMessage("ID expected to be greater than 0, instead value was lesser", __FILE__, __FUNCTION__, __LINE__);
	}
	else
        $InrLogHandle->AddLogMessage("ID was not set or returned empty", __FILE__, __FUNCTION__, __LINE__);
}
?>