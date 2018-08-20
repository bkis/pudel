<?php

	require_once 'db.php';

	$id = htmlspecialchars($_POST["poll"]);
	$admid = htmlspecialchars($_POST["adm"]);

	$dbadmid = $database->get("polls", "polladm", ["poll" => $id]);
	$islocked = $database->get("polls", "locked", ["poll" => $id]);

	//delete comment
	if (strcmp($dbadmid, $admid) == 0 and strcmp($dbadmid, "NA") !== 0){
		$database->action(function($database) use ($id, $islocked) {
			if ($islocked == 1) {
			  $database->update("polls", ["locked" => 0], ["poll" => $id]);
			} else {
				$database->update("polls", ["locked" => 1], ["poll" => $id]);
			}
		});
	}

	//redirect to poll
	header("Location: poll.php?poll=" . $id);
	exit();

?>
