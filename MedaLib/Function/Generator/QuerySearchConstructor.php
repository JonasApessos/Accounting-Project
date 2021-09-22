<?php
function SearchQueryConstructor(string &$OutsSearchQuery) : void
{
	$OutsSearchQuery = "%" . $OutsSearchQuery . "%";
}
?>