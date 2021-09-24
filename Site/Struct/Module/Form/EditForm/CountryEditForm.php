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
                $sCountryEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                $sCountryEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Country</h3><br><h4>".$aDataRow['COUN_DATA_TITLE']."</h4></div>
                            <div><label><p>Name*</p><input type='text' placeholder='Country name' name='Name' value='".$aDataRow['COUN_DATA_TITLE']."' required></label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COUN_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='CounIndex' value='".$aDataRow['COUN_ID']."' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTRY']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                print($sCountryEditFormHTML);

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