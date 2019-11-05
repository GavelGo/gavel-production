<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Partners</title>
</head>
<body>
<h1>ALL PARTNERS</h1>
<?php
foreach ($view_model as $key => $value) {
?>
    <h3><?php echo $value['category_name'];?></h3>
    <?php
    $providers = explode(",", $value['provider_list']);
            foreach ($providers as $k => $v) {
                if(!empty($v)){
                    $url_name = preg_replace("/(\s)/", "-", $v);
?>
                    <h5><a href="<?php echo CUST_ROOT_URL . 'partners/' . $url_name?>"><?php echo $v; ?></a></h5>
<?php
                }
                else {
?>
                <h5>No Providers in this category</h5>
<?php
                }
            }
            echo "<br />";
?>
    </fieldset>
<?php 
}
?>
</body>
</html>