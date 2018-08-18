<?php

	require_once 'db.php';

	$id = htmlspecialchars($_POST["poll"]);
	$name = htmlspecialchars($_POST["name"]);
	$admid = htmlspecialchars($_POST["adm"]);

	$dbadmid = $database->get("polls", "polladm", ["poll" => $id]);

	//delete entries
	if (strcmp($dbadmid, $admid) == 0){
		$database->action(function($database) use ($id, $name) {
			$database->delete("entries", [
				"AND" => [
					"poll" => $id,
					"name" => $name
				]
			]);
		});
	}

	//redirect to poll
	header("Location: poll.php?poll=" . $id);
	exit();

?>
