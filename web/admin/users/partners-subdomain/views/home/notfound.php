<!DOCTYPE html>
<html>
<head>
	<title>Error</title>
</head>
<style type="text/css">
	h1 {text-align:center;}
	p {text-align:center;}
</style>
<body>
<br /><br /><br />
<h1>404</h1>
<p>Either the URL entered is incorrect, or this page does not exist.</p>
<p>Try searching or going to Gavelgo's <a href="/">Home Page</a></p>
<?php
if(isset($_SERVER['HTTP_REFERER'])){
?>
	<div style="text-align:center">
  		<a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Go Back</a>
	</div>​
	<br />
<?
}
?>
<div style="text-align:center">
  <a href="<?php echo ROOT_URL?>">Home</a>
</div>​
</body>
</html>