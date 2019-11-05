<!DOCTYPE html>
<html>
<head>
    <title>Gavelgo | Categories</title>
</head>
<body>
<?php
foreach ($request_data as $key => $value) {
    $url_name = implode("-", explode(" ", strtolower($value['category_name']))); 
?>
    <h3><a href="/categories/<?php echo $url_name;?>"><?php echo $value['category_name'];?></a></h3> 
<?php
    $sub_cats = explode(",", $value['subcat_list']);
    foreach ($sub_cats as $k => $v) {
        if(!empty($v)){
            $subc_url_name = implode("-", explode(" ", strtolower($v))); 
?>
            <h5><a href="/categories/sub/<?php echo $subc_url_name; ?>"><?php echo $v; ?></a></h5>
<?php
        }
        else {
?>
            <h5>No subcategories</h5>
<?php
        }
    }
    echo "<br />";
}
?>
</body>
</html>