<?php
//-------------<FUNCTION>-------------//
function HTMLCountyAddForm(ME_CDBConnManager &$InDBConn, int &$IniUserAccessLevelIndex) : void
{
	require_once("Output/Retriever/AccessRetriever.php");
	require_once("Output/Retriever/CountryRetriever.php");
	require_once("Struct/Element/Function/Select/SelectAccessRowRender.php");
	require_once("Struct/Element/Function/Select/SelectCountryRowRender.php");

  //-------------<PHP-HTML>-------------//
  print("<div class='Form'>");

  print("<form method='POST'>");
  print("<div>");

  //Title
  print("<div id='FormTitle'>");
  print("<h3>New County</h3>");
  print("</div>");

  //Input Row
  print("<div>");
  print("<div>");
  print("<h5>Name</h5>");
  print("</div>");

  print("<div>");
  print("<input type='text' placeholder='County name' name='Name' required>");
  print("</div>");
  print("</div>");

	//Input Row
  print("<div>");
  print("<div>");
  print("<h5>Tax</h5>");
  print("</div>");

  print("<div>");
  print("<input type='number' placeholder='County Tax' name='Tax' step='0.01' min='0.00' max='100.00'>");
  print("</div>");
  print("</div>");

  //Input Row
  print("<div>");
  print("<div>");
  print("<h5>Interest Rate</h5>");
  print("</div>");

  print("<div>");
  print("<input type='number' placeholder='County Interest Rate' name='IR' step='0.01' min='0.00' max='100.00'>");
  print("</div>");
  print("</div>");

  //Input Row
  print("<div>");
  print("<div>");
  print("<h5>Date</h5>");
  print("</div>");

  print("<div>");
  print("<input type='Date' placeholder='County modification date' name='Date' required>");
  print("</div>");
  print("</div>");

  //get rows and render <select> element with data
  print("<div>");
  print("<div>");
  print("<h5>Country</h5>");
  print("</div>");

  print("<div>");
  RenderCountrySelectRow($InDBConn, $IniUserAccessLevelIndex, $_ENV['Available']['Show']);
  print("</div>");
  print("</div>");

  //get rows and render <select> element with data
  print("<div>");
  print("<div>");
  print("<h5>Access</h5>");
  print("</div>");

  print("<div>");
  RenderAccessSelectRow($InDBConn, $IniUserAccessLevelIndex, $_ENV['Available']['Show']);
  print("</div>");
  print("</div>");

  print("</div>");

  print("<div>");
  printf("<input type='submit' value='Save' formaction='.?MenuIndex=%d&Module=%d&ProAdd'>", $_GET['MenuIndex'], $_GET['Module']);
  printf("<a href='.?MenuIndex=%d'><div class='Button-Left'><p>Cancel</p></div></a>", $_GET['MenuIndex']['County']);
  print("</div>");

  print("</form>");

  print("</div>");
}
?>
