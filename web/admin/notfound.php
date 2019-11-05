<?php
echo "<h1>404</h1>";
echo "<p>Either the URL entered is incorrect, or this page does not exist.</p>";
if(isset($_SERVER['HTTP_REFERER'])){
?>
	<a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Go Back</a>
	<br />
<?
}
?>
<a href="<?php echo ROOT_URL?>">Home</a>