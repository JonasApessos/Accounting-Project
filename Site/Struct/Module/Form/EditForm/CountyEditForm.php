<?php
 //-------------<FUNCTION>-------------//
function HTMLCountyEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, $IniUserAccess) : void
{
    if(isset($_POST['CouIndex']) && !empty($_POST['CouIndex']))
    {
        $iCountyIndex = (int) $_POST['CouIndex'];

        if($iCountyIndex > 0)
        {
            $rResult = CountyEditFormSpecificRetriever($InrConn, $InrLogHandle, $iCountyIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1)) 
            {
                $sCountyEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                $sCountyEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>New County</h3><br><h4>".$aDataRow['COU_DATA_TITLE']."</h4></div>
                            <div><label><p>Name*</p><input type='text' placeholder='County name' name='Name' value='".$aDataRow['COU_DATA_TITLE']."' required></label></div>
                            <div><label><p>Tax</p><input type='number' placeholder='County Tax' name='Tax' value='".$aDataRow['COU_DATA_TAX']."' step='0.01' min='0.00' max='100.00'></label></div>
                            <div><label><p>Interest Rate</p><input type='number' placeholder='County Interest Rate' name='IR' value='".$aDataRow['COU_DATA_IR']."' step='0.01' min='0.00' max='100.00'></label></div>
                            <div><label><p>Country</p> ".RenderCountrySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COUN_ID'])."</label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COU_DATA_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='CountyIndex' value='".$aDataRow['COU_ID']."' required>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['COUNTY']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                print($sCountyEditFormHTML);

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
 