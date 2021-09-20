<?php
 //-------------<FUNCTION>-------------//
function HTMLCountryEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['CounIndex']) && !empty($_POST['CounIndex']))
    {
        $iCountryIndex = (int) $_POST['CounIndex'];

        if($iCountryIndex > 0)
        {
            $rResult = CountryEditFormSpecificRetriever($InrConn, $InrLogHandle, $iCountryIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1))
            {
                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                printf("
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='FormTitle'><h3>Edit Country</h3><br><h4>%s</h4></div>
                            <div><label>Name*<input type='text' placeholder='Country name' name='Name' value='%s' required></label></div>
                        </div>",
                $aDataRow['COUN_DATA_TITLE'],
                $aDataRow['COUN_DATA_TITLE']);

                //get rows and render <select> element with data
                print(" <div><label>Access");
                RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COUN_ACCESS']);
                print(" </label></div>");

                printf("
                        <div>
                            <input type='hidden' name='CounIndex' value='%s' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=%s&Module=%s&ProEdit'>
                            <a href='.?MenuIndex=%s'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>",
                $aDataRow['COUN_ID'],
                $GLOBALS['MENU']['COUNTRY']['INDEX'],
                $GLOBALS['MODULE']['EDIT'],
                $GLOBALS['MENU']['COUNTRY']['INDEX']);

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