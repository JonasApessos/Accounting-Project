<?php
//-------------<FUNCTION>-------------//
function HTMLShareholderAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
  	//-------------<PHP-HTML>-------------//
	print("
	<div class='form'>
		<form method='POST'>
			<div>
				<div id='FormTitle'><h3>New Shareholder</h3></div>
			</div>");

	//Input Row
	print("<div><label>Employee");
	RenderEmployeeSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
	print("</label></div>");

	//Input Row
	print("<div><label>Access");
	RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW']);
	print("</label></div>");

	printf("
			<div>
				<input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>
				<a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>
			</div>
		</form>
	</div>",
	$GLOBALS['MENU']['SHAREHOLDER']['INDEX'],
	$GLOBALS['MODULE']['ADD'],
	$GLOBALS['MENU']['SHAREHOLDER']['INDEX']);
}
?>