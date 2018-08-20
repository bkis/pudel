<?php

	require_once 'db.php';

	$id = htmlspecialchars($_POST["poll"]);
	$comname = htmlspecialchars($_POST["comname"]);
	$comdate = htmlspecialchars($_POST["comdate"]);
	$admid = htmlspecialchars($_POST["adm"]);

	$dbadmid = $database->get("polls", "polladm", ["poll" => $id]);

	//delete comment
	if (strcmp($dbadmid, $admid) == 0){
		$database->action(function($database) use ($id, $comname, $comdate) {
			$database->delete("comments", [
				"AND" => [
					"poll" => $id,
					"name" => $comname,
					"date" => $comdate
				]
			]);
		});
	}

	//redirect to poll
	header("Location: poll.php?poll=" . $id);
	exit();

?>
