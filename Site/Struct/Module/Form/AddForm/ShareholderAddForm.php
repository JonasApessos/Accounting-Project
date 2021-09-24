<?php
//-------------<FUNCTION>-------------//
function HTMLShareholderAddForm(ME_CDBConnManager &$InrConn, ME_CLogHandle &$InrLogHandle, int &$IniUserAccess) : void
{
	$sShareholderAddFormHTML = "";
	
  	//-------------<PHP-HTML>-------------//
	  $sShareholderAddFormHTML .= "
	<div class='form'>
		<form method='POST'>
			<div>
				<div id='form-title'><h3>New Shareholder</h3></div>
				<div><label><p>Employee</p> ".RenderEmployeeSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
				<div><label><p>Access</p> ".RenderAccessSelectRow($InrConn, $InrLogHandle, $IniUserAccess, $GLOBALS['AVAILABLE']['SHOW'])."</label></div>
			</div>
			<div>
				<input type='submit' value='Save' formaction='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."&Module=".$GLOBALS['MODULE']['ADD']."&ProAdd'>
				<a href='.?MenuIndex=".$GLOBALS['MENU']['SHAREHOLDER']['INDEX']."'><div class='Button-Left'><p>Cancel</p></div></a>
			</div>
		</form>
	</div>";

	print($sShareholderAddFormHTML);
}
?>