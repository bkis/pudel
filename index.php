<?php include "header.php" ?>


<div class="center-box">

	<h1><?php echo SPR_NEW_FORM_HEADING ?></h1>

	<form id="form-new-poll" action="poll.new.php" method="post">
		<ul class="form">
		    <li>
		        <label><?php echo SPR_NEW_FORM_TITLE ?> <span class="required">*</span></label>
				<input
				type="text"
				name="title"
				class="field-long"
				required="true"
				id="titleInput"
				maxlength="256"
				placeholder="<?php echo SPR_NEW_FORM_TITLE_PLACEHOLDER ?>" />
		    </li>
		    <li>
		        <label><?php echo SPR_NEW_FORM_DETAILS ?> </label>
				<textarea
					name="details"
					class="field-long field-textarea"
					maxlength="512"
					placeholder="<?php echo SPR_NEW_FORM_DETAILS_PLACEHOLDER ?>"></textarea>
		    </li>
		    <li>
		        <label><?php echo SPR_NEW_FORM_OPTIONS ?> <span class="required">*</span></label>
				<input
					type="text" name="dates[]" maxlength="32"
					class="dateInput field-long datepicker-here"
					required="true" placeholder="<?php echo SPR_NEW_FORM_OPTIONS_PLACEHOLDER ?>"
					style="margin-bottom: 8px;" />
		    </li>
		    <li>
				<div style="text-align: right">
					<button type="button" id="btnMore"> </button>
					<button type="button" id="btnLess" disabled> </button>
				</div>
			</li>
			<?php if (SPR_ADMIN_LINKS == 1) { ?>
				<li>
					<label><?php echo SPR_NEW_FORM_ADMIN ?></label>
					<input type='checkbox' name='adminLink' value='true' id='adminInput' checked />
					<span style="font-size: 90%;"><?php echo SPR_NEW_FORM_ADMIN_CHECKBOX ?></span>
				</li>
			<?php } ?>
			<li>
				<br/><span class="pale"><?php echo preg_replace("/\bn\b/", SPR_DELETE_AFTER, SPR_LIFESPAN) ?></span>
			</li>
		    <li class="content-right">
		        <input type="submit" value="<?php echo SPR_NEW_FORM_SUBMIT ?>" />
		    </li>
		</ul>
	</form>

</div>

<!-- INDEX PAGE JS -->
<?php include "index.js.php" ?>

<!-- PAGE FOOTER -->
<?php include "footer.php" ?>
