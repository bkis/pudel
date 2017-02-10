<?php
	if (isset($_POST["title"]) && strlen($_POST["title"]) > 0
		&& isset($_POST["dates"])){
		
		require_once 'db.php';

		$title = htmlspecialchars($_POST["title"]);
		$details = htmlspecialchars($_POST["details"]);
		$dates = array_values(array_unique($_POST["dates"]));
		$id = hash("md4", time() . $title);

		//write data to polls table
		$database->action(function($database) use ($id, $title, $details) {
			$database->insert("polls", [
				"poll" => $id,
				"title" => $title,
				"details" => $details,
				"changed" => date("Y-m-d H:i:s")
			]);
		});

		//prepare dates
		$datesArr = array();
		for ($i=0; $i < sizeof($dates); $i++) { 
			array_push($datesArr, array("poll" => $id, "date" => $dates[$i], "sort" => $i));
		}

		//write data to dates table
		$database->action(function($database) use ($datesArr) {
			$database->insert("dates", $datesArr);
		});

		//redirect to poll
		header("Location: poll.php?poll=" . $id);
		exit();
	}

	$currDate = date("Y-m-d");
	$btnDateHTML = "<input type='text' name='dates[]' maxlength='32' class='dateInput field-with-btn'
		data-toggle='datepicker' required='true' style='margin-top: 4px;' /><button class='btn-in-field'>D</button>";
	include "header.php";
?>


<div class="centerBox">
	<form action="index.php" method="post">
		<ul class="sprudelform">
		    <li>
		        <label><?php echo SPR_NEW_FORM_TITLE ?> <span class="required">*</span></label>
		        <input type="text" name="title" class="field-long" required="true" id="titleInput" placeholder="<?php echo SPR_NEW_FORM_TITLE_PLACEHOLDER ?>" />
		    </li>
		    <li>
		        <label><?php echo SPR_NEW_FORM_DESCRIPTION ?> </label>
		        <textarea name="details" class="field-long field-textarea" placeholder="<?php echo SPR_NEW_FORM_DETAILS_PLACEHOLDER ?>"></textarea>
		    </li>
		    <li>
		        <label><?php echo SPR_NEW_FORM_DATES ?> <span class="required">*</span></label>
		        <input type="text" name="dates[]" maxlength="32" class="dateInput field-long" data-toggle="datepicker" required="true" placeholder="<?php echo SPR_NEW_FORM_DATES_PLACEHOLDER ?>" style="margin-bottom: 5px;" />
		    </li>
		    <li>
		    	<img src="img/icon-more.png" class="btnFormDate" id="btnMore"/>
		    	<img src="img/icon-less-disabled.png" class="btnFormDate" id="btnLess"/>
		    </li>
		    <li class="content-right">
		        <input type="submit" value="<?php echo SPR_NEW_FORM_SUBMIT ?>" />
		    </li>
		</ul>
	</form>
</div>


<script type="text/javascript">

	$(document).ready(function() {

		$("#titleInput").focus();
		$("#btnLess").css("cursor", "default");

		var datepickerOptions = {
			format: '<?php echo SPR_DATEPICKER_FORMAT ?>',
			autoHide: 'true',
			weekStart: 1,
			language: '<?php echo SPR_DATEPICKER_LANG ?>',
			days: ['<?php echo SPR_DATEPICKER_SUNDAY ?>',
				   '<?php echo SPR_DATEPICKER_MONDAY ?>',
				   '<?php echo SPR_DATEPICKER_TUESDAY ?>',
				   '<?php echo SPR_DATEPICKER_WEDNESDAY ?>',
				   '<?php echo SPR_DATEPICKER_THURSDAY ?>',
				   '<?php echo SPR_DATEPICKER_FRIDAY ?>',
				   '<?php echo SPR_DATEPICKER_SATURDAY ?>']
		};

		//init first datepicker
		$(".dateInput").datepicker(datepickerOptions);

		//add new date field
		$("#btnMore").click(function() {
            $(".dateInput").last().after($(".dateInput").last().clone());
            $(".dateInput").last().val($(".dateInput:nth-last-child(2)").val());
            $(".dateInput").last().focus();
            $(".dateInput").last().select();
			$(".dateInput").last().datepicker(datepickerOptions);
			$("#btnLess").attr("src", "img/icon-less.png");
			$("#btnLess").css("cursor", "pointer");
        });

		//remove one date field
        $("#btnLess").click(function() {
        	$(".dateInput").not(':first').last().datepicker('destroy');
            $(".dateInput").not(':first').last().detach();
            $(".dateInput").last().focus();
            $(".dateInput").last().select();
            $(".dateInput").last().datepicker(datepickerOptions);
            if ($(".dateInput").size() == 1){
            	$("#btnLess").attr("src", "img/icon-less-disabled.png");
            	$("#btnLess").css("cursor", "default");
            }
        });

	});

</script>


<?php include "footer.php" ?>