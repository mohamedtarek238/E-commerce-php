<?php
	include 'connect.php';
	// To get to the tracks easily and quickly
	$tp1 	= 'includes/temps/';
	$css 	= 'layout/css/';
	$js  	= 'layout/js/';
	$lan 	= 'includes/languages/';
	$func 	= 'includes/functions/';

	include $func 	. 'function.php';
	include $lan 	. 'english.php';
	include $tp1 	. 'header.php';

	if(!isset($noNavbar)) {include $tp1 . 'nav.php';}
