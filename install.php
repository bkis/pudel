<?php

	require_once 'db.php';

	// INIT MYSQL DATABASE

	// create table "polls"
	$query = "CREATE TABLE `polls` (
			`poll` varchar(32) NOT NULL,
			`polladm` varchar(32) NOT NULL,
			`title` text NOT NULL,
			`details` text NOT NULL,
			`locked` tinyint(1) NOT NULL,
			`email` varchar(32) NOT NULL,
			`changed` date NOT NULL,
			PRIMARY KEY (`poll`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$success = $database->query($query);


	// create table "entries"
	$query = "CREATE TABLE `entries` (
			`poll` varchar(32) NOT NULL,
			`date` varchar(32) NOT NULL,
			`name` varchar(32) NOT NULL,
			`value` tinyint(4) NOT NULL,
			KEY `poll` (`poll`,`name`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$success = $database->query($query);


	// create table "dates"
	$query = "CREATE TABLE `dates` (
			`poll` varchar(32) NOT NULL,
			`date` varchar(32) NOT NULL,
			`sort` tinyint(4) NOT NULL,
			KEY `poll` (`poll`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$success = $database->query($query);

	// create table "comments"
	$query = "CREATE TABLE `comments` (
			`poll` varchar(32) NOT NULL,
			`text` varchar(512) NOT NULL,
			`name` varchar(32) NOT NULL,
			`date` varchar(32) NOT NULL,
			KEY `poll` (`poll`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$success = $database->query($query);


	include "header.php";

?>


<div class="centerBox">
	<br>
	<?php
		if ($success){
			echo "<span class='success'>Database initialized successfully.</span><br>";
			echo "You should now try your new Sprudel installation and if everything works, delete install.php from the server!<br><br>";
			echo "<a href='index.php'>Click here try out your Sprudel installation.</a>";
		} else {
			echo "<span class='fail'>Database couldn't be initialized.</span><br>";
			echo "Please check your setup in config.php and make shure you create the database before you run install.php!";
		}
	?>
</div>


<?php include "footer.php" ?>
