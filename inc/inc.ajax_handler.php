<?php
$phpFiles = array_diff(scandir("./inc/"), [".", "..", basename(__FILE__)]);
interface iPage {
	public function ConstructPage();
	public function GetId();
	function __construct();
}
foreach ($phpFiles as $key => $value) {
	include( $value);
}