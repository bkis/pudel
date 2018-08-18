<?php

	require_once 'db.php';

	if (isset($_POST["poll"]) && !empty($_POST['poll']) && isset($_POST["adm"]) && !empty($_POST['adm'])){
		$id = htmlspecialchars($_POST["poll"]);
		$admid = htmlspecialchars($_POST["adm"]);

		$dbadmid = $database->get("polls", "polladm", ["poll" => $id]);

		//delete entries
		$database->action(function($database) use ($id, $admid, $dbadmid) {
			if (strcmp($dbadmid, $admid) == 0) {
				//delete from polls table
				$database->delete("polls", ["poll" => $id]);

				//delete from entries table
				$database->delete("entries", ["poll" => $id]);

				//delete from dates table
				$database->delete("dates", ["poll" => $id]);

				//delete from comments table
				$database->delete("comments", ["poll" => $id]);
			}

			//removed poll?
			if ($database->has("polls", ["poll" => $id])){
				echo "ERROR: Something went wrong..." . PHP_EOL;
				return false;
			}
		});

		//redirect to poll
		if (strcmp($dbadmid, "NA") == 0) {
			header("Location: index.php");
		} else {
			header("Location: admin/index.php");
		}
		exit();
	}

	//redirect to poll
	header("Location: index.php");
	exit();

?>
