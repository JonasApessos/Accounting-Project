<?php
 //-------------<FUNCTION>-------------//
function HTMLCustomerEditForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int $IniUserAccess) : void
{
    if(isset($_POST['CustIndex']) && !empty($_POST['CustIndex']))
    {
        $iCustomerIndex = (int) $_POST['CustIndex'];

        if($iCustomerIndex > 0)
        {
            $rResult = CustomerEditFormSpecificRetriever($InrConn, $InrLogHandle, $iCustomerIndex, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);

            if(!empty($rResult) && ($rResult->num_rows == 1)) 
            {
                $sCustomerEditFormHTML = "";

                $aDataRow = $rResult->fetch_assoc();

                //-------------<PHP-HTML>-------------//

                $sCustomerEditFormHTML .= "
                <div class='form'>
                    <form method='POST'>
                        <div>
                            <div id='form-title'><h3>Edit Customer</h3><br><h4>".$aDataRow['CUST_DATA_NAME']."</h4></div>
                            <div><label><p>Name*</p><input type='text' maxlength='64' placeholder='Name' name='Name' value='".$aDataRow['CUST_DATA_NAME']."' required></label></div>
                            <div><label><p>Surname*</p><input type='text' maxlength='64' placeholder='Surname' name='Surname' value='".$aDataRow['CUST_DATA_SURNAME']."' required></label></div>
                            <div><label><p>Phone number*</p><input type='tel' maxlength='16' placeholder='cell phone' name='PhoneNumber' value='".$aDataRow['CUST_DATA_PN']."' required></label></div>
                            <div><label><p>Stable number</p><input type='tel' maxlength='16' placeholder='Stable number(house or bussiness)' name='StableNumber' value='".$aDataRow['CUST_DATA_SN']."'></label></div>
                            <div><label><p>Email</p><input type='email' maxlength='64' placeholder='customer@email.com' name='Email' value='".$aDataRow['CUST_DATA_EMAIL']."'></label></div>
                            <div><label><p>VAT</p><input type='text' maxlength='32' placeholder='GR123456789' name='VAT' value='".$aDataRow['CUST_DATA_VAT']."'></label></div>
                            <div><label><p>Address</p><textarea placeholder='Description' spellcheck='true' rows='5' cols='10' maxlegnth='128' name='Addr' value='".$aDataRow['CUST_DATA_ADDR']."'></textarea></label></div>
                            <div><label><p>Note</p><textarea placeholder='Note' spellcheck='true' rows='5' 'cols='10' maxlegnth='256' name='Note' value='".$aDataRow['CUST_DATA_NOTE']."'></textarea></label></div>
                            <div><label><p>Access</p> ".RenderAccessSelectRowCheck($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'], $aDataRow['CUST_DATA_ACCESS'])."</label></div>
                        </div>
                        <div>
                            <input type='hidden' value='".$aDataRow['CUST_ID']."' name='CustIndex'>
                            <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."&Module=".$GLOBALS['MODULE']['EDIT']."&ProEdit'>
                            <a href='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
                        </div>
                    </form>
                </div>";

                print($sCustomerEditFormHTML);

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
 