<?php

	if(!isset($_GET["poll"]) || $_GET["poll"] == "")
		header("Location: 404.php");

	require_once 'util.php';
	require_once 'db.php';

	$id = htmlspecialchars($_GET["poll"]);
	$poll = $database->get("polls", "*", ["poll" => $id]);
	$persons = transformPollEntries($database->select("entries", "*", ["poll" => $id]));
	$dates = transformPollDates($database->select("dates", "*", ["poll" => $id]));

	$admid = "NA";
	if(isset($_GET["adm"]) && !empty($_GET['adm']))
		$admid = htmlspecialchars($_GET["adm"]);

	$dbadmid = $poll["polladm"];

	for ($i=0; $i < sizeof($dates); $i++) {
		//set confirmation count values
		$dates[$i]["yes"] = 0;
		$dates[$i]["maybe"] = 0;
		$dates[$i]["no"] = 0;
	}

	if(!$poll)
		header("Location: 404.php");

	include "header.php";

	if (strcmp($dbadmid, $admid) == 0) {
		echo "<div class='content-right'>";
		echo "<img id='btnDeletePoll' src='img/icon-delete-poll.png' alt='delete'/>";
		echo "</div>";
	}
?>


<!-- POLL TABLE -->
<table class="schedule">

	<!-- TABLE HEADER / DATES -->
	<tr>
		<td class="schedule-blank"></td>
		<?php
			foreach ($dates as $date) {
				//echo "<td class='schedule-header'><div class='schedule-header-date'>";
				//echo $date["date"];
				//echo "</div></td>";

				echo "<td class='schedule-header'><div class='rotated-text'><div class='rotated-text__inner'>";
				echo $date["date"];
				echo "</div></div></td>";
			}
		?>
	</tr>


	<!-- EXISTING ENTRIES -->
	<?php
		foreach ($persons as $pName => $pDates) {

			echo "<tr class='valign-middle'>";
			echo "<td class='schedule-names'>" . $pName . "</td>";

			for ($i=0; $i < sizeof($dates); $i++) {
				$value = "maybe";
				switch ($pDates[$dates[$i]["date"]]) {
				    case 0: $value = "no"; break;
				    case 1: $value = "yes"; break;
				    case 2: $value = "maybe"; break;
				}

				echo "<td class='schedule-entry schedule-entry-" . $value . "'>";
				//echo "<img src='img/icon-" . $value . ".png' alt=''/>";

				echo "</td>";

				//count result
				if ($value == "yes"){
					$dates[$i]["yes"]++;
				} elseif ($value == "maybe"){
					$dates[$i]["maybe"]++;
				} else {
					$dates[$i]["no"]++;
				}
			}

			if (strcmp($dbadmid, $admid) == 0){
				echo "<td class='schedule-delete' data-poll='$id' data-name='$pName' poll-admid='$admid'>";
			}

			echo "</tr>";
		}
	?>


	<!-- NEW ENTRY -->
	<tr class="schedule-new valign-middle">
		<form action="entry.php" method="post">
			<input type="hidden" name="poll" value="<?php echo $id ?>"/>
			<td class="schedule-name-input">
				<input type="text" id='name-input' name="name" maxlength="32" placeholder="<?php echo SPR_POLL_NAME ?>" required="true" />
			</td>
			<?php
				foreach ($dates as $date) {
					echo "<td class='new-entry-box new-entry-choice-maybe'>";
					echo "<input class='entry-value' type='hidden' name='values[]' value='2'/>";
					echo "<input class='entry-date' type='hidden' name='dates[]' value='" . $date["date"] . "'/>";
					echo "</td>";
				}
			?>
			<td class="schedule-submit">
				<input type="submit" value="<?php echo SPR_ENTRY_SAVE ?>" class="save" />
			</td>
		</form>
	</tr>

	<!-- RESULTS -->
	<tr class="schedule-results valign-middle">
		<td>
			<?php echo SPR_RESULTS ?>
		</td>
		<?php
			foreach ($dates as $date) {
				echo "<td class='results-cell'>";
				echo "<span class='r-yes'>" . $date["yes"] . "</span><br/>";
				echo "<span class='r-maybe'>" . $date["maybe"] . "</span><br/>";
				echo "<span class='r-no'>" . $date["no"] . "</span>";
				echo "</td>";
			}
		?>
	</tr>

</table>
<br>



<!-- COMMENTS LIST -->
<div class="centerBox">
	<h2><?php echo SPR_COMMENT_HEADING ?></h2><br>
	<?php
		$comments = $database->select("comments", "*", ["poll" => $id]);
		if (sizeof($comments) > 0){
			foreach ($comments as $comment) {
				echo "<div class='comment-container'>";
				echo "<span class='comment-name'>" . $comment["name"] . "</span>";
				echo "<div class='comment-date'>" . $comment["date"];
				if (strcmp($dbadmid, $admid) == 0) {
					$comname = $comment["name"];
					$comdate = $comment["date"];
					echo " | <div class='comment-delete' data-poll='$id' data-comname='$comname' data-comdate='$comdate' poll-admid='$admid'></div>";
				}
				echo "</div>";
				echo "<div class='comment-text'>" . nl2br($comment["text"]) . "</div>";
				echo "</div>";
			}
		} else {
			echo SPR_COMMENT_NONE;
		}

	?>
</div><br>

<!-- COMMENTS FORM -->
<div class="centerBox">
	<form action="comment.php" method="post" class="sprudelform">
		<input type="hidden" name="poll" value="<?php echo $id ?>"/>
		<ul class="sprudelform">
		    <li>
		        <label><?php echo SPR_COMMENT_NAME ?> <span class="required">*</span></label>
		        <input type="text" name="name" maxlength="32" class="field-long" required="true" />
		    </li>
		    <li>
		        <label><?php echo SPR_COMMENT_TEXT ?> <span class="required">*</span></label>
		        <textarea name="text" maxlength="512" class="field-long field-textarea" required="true"></textarea>
		    </li>
		    <li class="content-right">
		        <input type="submit" value="<?php echo SPR_COMMENT_SUBMIT ?>" />
		    </li>
		</ul>
	</form>
</div><br>




<!-- JS -->
<script type="text/javascript">

	$(document).ready(function() {
		//show url
		var pollUrl = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?poll=<?php echo $id ?>";
		$("#urlInfo").text(pollUrl);
		$("#admUrl").text(pollUrl);

		//url clipboard copy feature
		var clipboard = new Clipboard('#btnCopy');
		clipboard.on('success', function(e) {
		    $("#btnCopy").attr("src", "img/icon-copied.png");
		    $("#name-input").focus();
		});
		clipboard.on('error', function(e) {
		    alert("<?php echo SPR_URL_COPY_ERROR ?>");
		    $("#name-input").focus();
		});

		//delete entry button functionality
		$(".schedule-delete").click(function(){
			if (confirm("<?php echo SPR_REMOVE_CONFIRM ?> '" + $(this).attr("data-name") + "' ?")){
				$.post( "delete.php", { poll: $(this).attr("data-poll"), name: $(this).attr("data-name"), adm: $(this).attr("poll-admid") } ).done( function() {
					location.href = location.href;
				});
			}
		});

		//delete poll button functionality
		$("#btnDeletePoll").click(function(){
			if (confirm("<?php echo SPR_DELETE_POLL_CONFIRM ?>")){
				$.post( "delete-poll.php", { poll: "<?php echo $id ?>", adm: "NA" } ).done( function() {
					location.href = "index.php";
				});
			}
		});

		//delete comment button functionality
		$(".comment-delete").click(function(){
			if (confirm("<?php echo SPR_DELETE_COMMENT_CONFIRM ?>")){
				$.post( "delete-comment.php", { poll: $(this).attr("data-poll"), comname: $(this).attr("data-comname"), comdate: $(this).attr("data-comdate"), adm: $(this).attr("poll-admid") } ).done( function() {
					location.href = location.href;
				});
			}
		});

		//cycle throug options
		$(".new-entry-box").click(function(){
			if ($(this).hasClass("new-entry-choice-maybe")){
				$(this).removeClass("new-entry-choice-maybe");
				$(this).addClass("new-entry-choice-yes");
				$(this).children(".entry-value").attr("value", "1");
			} else if ($(this).hasClass("new-entry-choice-yes")){
				$(this).removeClass("new-entry-choice-yes");
				$(this).addClass("new-entry-choice-no");
				$(this).children(".entry-value").attr("value", "0");
			} else if ($(this).hasClass("new-entry-choice-no")) {
				$(this).removeClass("new-entry-choice-no");
				$(this).addClass("new-entry-choice-maybe");
				$(this).children(".entry-value").attr("value", "2");
			}

		});

	});

</script>



<?php include "footer.php" ?>
