<?php

	require_once 'db.php';

	$id = htmlspecialchars($_POST["poll"]);
	$name = htmlspecialchars($_POST["name"]);
	$text = preg_replace("/\s(?=\s)/", " ", htmlspecialchars($_POST["text"]));
	$date = date("Y-m-d H:i:s");

	//prapare comment data
	$comment = array(
		"poll" => $id,
		"name" => $name,
		"text" => $text,
		"date" => $date
	);

	$database->action(function($database) use ($comment, $id, $date) {
		//write data to comments table
		$database->insert("comments", $comment);

		//update change date in polls table
		$database->update("polls", array("changed" => $date), array("poll" => $id));
	});

	$email = $database->get("polls", "email", ["poll" => $id]);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$title = $database->get("polls", "title", ["poll" => $id]);
		$subject = SPR_COMMENT_EMAIL . " " . $title;
		$from = "Sprudel <" . SPR_COMMENT_FROM_EMAILADDRESS . ">";
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$actual_link = str_replace("comment.php", "poll.php?poll=" . $id, $actual_link);
		$mailtext = SPR_COMMENT_EMAILTEXT . " " . $name . ":\r\n\r\n";
		$mailtext .= $text . "\r\n\r\n";
		$mailtext .= SPR_COMMENT_EMAILLINK . ": " . $actual_link;

		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=utf-8";
		$headers[] = "From: {$from}";
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();

		mail($email, $subject, $mailtext, implode("\r\n", $headers));
	}

	//redirect to poll
	header("Location: poll.php?poll=" . $id);
	exit();

?>
