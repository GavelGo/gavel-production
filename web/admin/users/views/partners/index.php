<!DOCTYPE html>
<html>
<head>
    <title>Gavelgo | Providers</title>
</head>
<body>
<?php
use PartnerDomain\Model;

echo "<br /><h1>ALL PROVIDERS</h1>";
if (!is_null($view_model)) {
    foreach ($view_model as $key => $value) {
    ?>
        <fieldset>
        <h3><?php echo $value['category_name'];?></h3>
        <?php
        $providers = explode(",", $value['provider_list']);
                foreach ($providers as $k => $v) {
                    if(!empty($v)){
                        $url_name = Model::encode_name($v);
    ?>
                        <h4><a href="<?php echo CUST_ROOT_URL . 'partners/' . $url_name?>"><?php echo $v; ?></a></h4>
    <?php
                    }
                    else {
    ?>
                    <h5>No Providers in this category</h5>
    <?php
                    }
                }
                echo "</fieldset>";
                echo "<br />";
    ?>
        </fieldset>
    <?php 
    }
}
?>

</body>
</html>
