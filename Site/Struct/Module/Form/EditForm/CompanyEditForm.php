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
                $sCompanyEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//
                
                $sCompanyEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Company</h3><br><h4>".$aDataRow['COMP_DATA_TITLE']."</h4></div>
                            <div><label><p>Name*</p><input name='Name' type='text' placeholder='Company Name' value='".$aDataRow['COMP_DATA_TITLE']."' required></label></div>
                            <div><label><p>creation date*</p><input name='Date' type='date' value='".$aDataRow['COMP_DATA_DATE']."' required></label></div>
                            <div><label><p>County</p> ".RenderCountySelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COU_ID'])."</label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['COMP_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' name='CompIndex' value='".$aDataRow['COMP_ID']."' required>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."'><div><p>Cancel</p></div></a>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['COMPANY']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                        </div>
                    </form>
                </div>";

                print($sCompanyEditFormHTML);

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