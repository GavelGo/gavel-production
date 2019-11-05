function textCounter(span, text, limit){
	var charCount = document.getElementById(text);
	document.getElementById(span).innerHTML = 255 - charCount.value.length
}
