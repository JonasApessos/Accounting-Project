<?php
function HTMLCustomerAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
    //-------------<PHP-HTML>-------------//
    print("
    <div class='form'>
        <form method='POST'>
            <div>
                <div id='FormTitle'><h3>New Customer</h3></div>
                <div><label>Name*<input type='text' maxlength='64' placeholder='Name' name='Name' required></label></div>
                <div><label>Surname*<input type='text' maxlength='64' placeholder='Surname' name='Surname' required></label></div>
                <div><label>Phone number*<input type='tel' maxlength='16' placeholder='cell phone' name='PhoneNumber' required></label></div>
                <div><label>Stable number<input type='tel' maxlength='16' placeholder='Stable number(house or bussiness)' name='StableNumber'></label></div>
                <div><label>Email<input type='email' maxlength='64' placeholder='customer@email.com' name='Email'></label></div>
                <div><label>VAT<input type='text' maxlength='32' placeholder='GR123456789' name='VAT'></label></div>
                <div><label>Address<textarea placeholder='Description' spellcheck='true' rows='5' cols='10' maxlegnth='128' name='Addr'></textarea></label></div>
                <div><label>Note<textarea placeholder='Note' spellcheck='true' rows='5' 'cols='10' maxlegnth='256' name='Note'></textarea></label></div>
            </div>");

    //get rows and render <select> element with data
    print(" <div><label>Access");
    RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
    print(" </label></div>");

    printf("
            <div>
                <input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>
                <a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
            </div>
        </form>
    </div>",
    $GLOBALS['MENU']['CUSTOMER']['INDEX'],
    $GLOBALS['MODULE']['ADD'],
    $GLOBALS['MENU']['CUSTOMER']['INDEX']);
}
?>
