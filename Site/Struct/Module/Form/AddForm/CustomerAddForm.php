<?php
function HTMLCustomerAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{

    $sCustomerAddFormHTML = "";

    //-------------<PHP-HTML>-------------//
    $sCustomerAddFormHTML .= "
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='form-title'><h3>New Customer</h3></div>
                <div><label><p>Name*</p><input type='text' maxlength='64' placeholder='Name' name='Name' required></label></div>
                <div><label><p>Surname*</p><input type='text' maxlength='64' placeholder='Surname' name='Surname' required></label></div>
                <div><label><p>Phone number*</p><input type='tel' maxlength='16' placeholder='cell phone' name='PhoneNumber' required></label></div>
                <div><label><p>Stable number</p><input type='tel' maxlength='16' placeholder='Stable number(house or bussiness)' name='StableNumber'></label></div>
                <div><label><p>Email</p><input type='email' maxlength='64' placeholder='customer@email.com' name='Email'></label></div>
                <div><label><p>VAT</p><input type='text' maxlength='32' placeholder='GR123456789' name='VAT'></label></div>
                <div><label><p>Address</p><textarea placeholder='Description' spellcheck='true' rows='5' cols='10' maxlegnth='128' name='Addr'></textarea></label></div>
                <div><label><p>Note</p><textarea placeholder='Note' spellcheck='true' rows='5' 'cols='10' maxlegnth='256' name='Note'></textarea></label></div>
                <div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
            </div>
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
                <a href='.?MenuIndex=".$GLOBALS['MENU']['CUSTOMER']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>";


    print($sCustomerAddFormHTML);
}
?>
