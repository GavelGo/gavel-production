<?php
use PartnerDomain\Messages;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Category Profile</title>
</head>
<body>
<?php
if(!is_null($request_data) && !empty($request_data)){
	echo "<h2><b>" . $request_data['category_name'] . "</b></h2>";
	echo "<h3>" . $request_data['category_description'] . "</h3>";
	$sub_cats = explode(",", $request_data['subcat_list']);
    echo "<h4>Subcategories</h4>";
    foreach ($sub_cats as $k => $v) {            
        if(!empty($v)){
?>
            <a href="/categories"><?php echo $v; ?></a>
            <br />
<?php
        }
        else {
?>
            <h5>No subcategories</h5>
<?php
        }
    }
}
else {
	Messages::set_message('This category could not be found or does not exist', 'error');
}
Messages::display();
?>
</body>
</html>