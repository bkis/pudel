
<script type="text/javascript">

    $(document).ready(function() {
        // show poll url
        var pollUrl = window.location.protocol + "//" +
                      window.location.hostname +
                      window.location.pathname +
                      "?poll=<?php echo $poll->getId() ?>";
        $("#public-url-field").val(pollUrl);
        $("#admin-url-field").val(pollUrl + "&adm=<?php echo $adminId ?>");
        
        // url clipboard copy feature
        var clipboard = new ClipboardJS(".copy-trigger");
        clipboard.on("success", function(e) {
            $(e.trigger).addClass("copy-success").addClass("copy-success").delay(600).queue(function(){
                $(this).removeClass("copy-success").dequeue();
            });
        });
        clipboard.on("error", function(e) {
            alert("<?php echo SPR_URL_COPY_ERROR ?>");
            $(e.trigger).addClass("copy-fail").delay(2000).queue(function(){
                $(this).removeClass("copy-fail").dequeue();
            });
        });
        
        // delete entry button functionality
        $(".schedule-delete").click(function(){
            if (confirm("<?php echo SPR_REMOVE_CONFIRM ?> '" + $(this).attr("data-name") + "' ?")){
                $.post( "entry.delete.php", { pollId: $(this).attr("data-poll"), name: $(this).attr("data-name"), adm: $(this).attr("data-adminid") } ).done( function() {
                    location.href = location.href;
                });
            }
        });

        // delete date/option button functionality
        $(".date-delete").click(function(){
            if (confirm("<?php echo SPR_REMOVE_CONFIRM ?> '" + $(this).attr("data-date") + "' ?")){
                $.post( "date.delete.php", { pollId: $(this).attr("data-poll"), date: $(this).attr("data-date"), adm: $(this).attr("data-adminid") } ).done( function() {
                    location.href = location.href;
                });
            }
        });
        
        // delete poll button functionality
        $("#ctrl-delete-poll").click(function(){
            if (confirm("<?php echo SPR_DELETE_POLL_CONFIRM ?>")){
                $.post( "poll.delete.php", { pollId: $(this).attr("data-poll"), adm: $(this).attr("data-adminid") } ).done( function() {
                    location.href = "index.php";
                });
            }
        });
        
        // iterate options on click (ugly, but works for now)
        $(".new-entry-box").click(function(){
            console.log("yes")
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
        
        // mini-view toggler
        $("#ctrl-mini-view").click(function(){
            if ($("#ctrl-mini-view").attr("data-miniview") == "off"){
                $("table.schedule").addClass("mini");
                $("#ctrl-mini-view").attr("data-miniview", "on");
                $("#ctrl-mini-view").text("<?php echo SPR_POLL_CONTROL_NORMAL_VIEW ?>");
            } else {
                $("table.schedule").removeClass("mini");
                $("#ctrl-mini-view").attr("data-miniview", "off");
                $("#ctrl-mini-view").text("<?php echo SPR_POLL_CONTROL_MINI_VIEW ?>");
            }
        });
        
    });

</script>