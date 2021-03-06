<?php

	// FOR DEVELOPMENT: UN-COMMENT TO PRINT ERRORS AND WARNINGS
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);


	if(!isset($_GET["poll"]) || $_GET["poll"] == "")
		header("Location: 404.php");

	require_once 'db.php';

	$db = new DB();
	$poll = $db->getPoll(htmlspecialchars($_GET["poll"]));

	//poll doesn't exist: 404
	if(!$poll) header("Location: 404.php");

	//set admin id if given in request
	$adminId = "NA";
	if(isset($_GET["adm"]) && !empty($_GET["adm"]))
		$adminId = htmlspecialchars($_GET["adm"]);

	include "poll.view.php";
?>