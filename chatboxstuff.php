<style>
#chatbox {
    text-align:left;
    margin-bottom:10px;
    margin-top:10px;
    padding:10px;
    background:#fff;
    height:270px;
    width:450px;
    border:1px solid #000;
    overflow:auto; }
</style>


<?php
//$fp = fopen("log.html", 'a');
//fwrite($fp, "<div class='msgln'>" . $user_email . " has logged in.<br /></div>");
//fclose($fp);

//echo "<div id='chatbox'>";
//if(file_exists("log.html") && filesize("log.html") > 0)
//{
  //$handle = fopen("log.html", "r");
  //$contents = fread($handle, filesize("log.html"));
  //fclose($handle);

  //echo $contents;

//echo "</div>";
//echo "<form name='message' action=''>";
//echo "<input name='usermsg' type='text' id='usermsg' size='63' />";
//echo "<input name='submitmsg' type='submit' id='submitmsg' value='Send' />";
//echo "</form>";

//$exit_email = $_POST['exit_email'];
//$fp = fopen("log.html", 'a');
//fwrite($fp, "<div class='msgln'>" . $exit_email . " has logged out.<br /></div>");
//fclose($fp);
?>

<!--
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
// jQuery Document
$(document).ready(function()
{
});

//jQuery Document
$(document).ready(function()
{
	//If user wants to end session
	$("#exit").click(function()
  {
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true)
    {
      window.location = 'index.php?logout=true';
    }
	});
});

//If user submits the form
$("#submitmsg").click(function()
{
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});
		$("#usermsg").attr("value", "");
		loadLog();
	return false;
});

function loadLog()
{
	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	$.ajax({
		url: "log.html",
		cache: false,
		success: function(html)
    {
			$("#chatbox").html(html); //Insert chat log into the #chatbox div

			//Auto-scroll
			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
			if(newscrollHeight > oldscrollHeight)
      {
				$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
			}
	  	},
	});
}

setInterval (loadLog, 2500);
</script>
-->
