<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Text To Speech</title>
</head>
<input type="text" name="text">
<a href="#" class="say">Say it!</a>
<audio src="" class="speech" hidden></audio>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(function(){
	$('a.say').on('click',function(e){
		e.preventDefault();
var text = $('input[name="text"]').val();
var url="https://translate.google.com/translate_tts?ie=UTF-&&q="+text+"&tl=en";
$('audio').attr('src',url).get(0).play();
		});
	});
	</script>
<body>
</body>
</html>