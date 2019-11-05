<?php
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 1){
	echo "<h1>CUSTOMER AUCTIONS</h1>";
	echo "<br />";
?>
	<a href="<?php echo ROOT_URL . 'auctions/' . $_SESSION['partner_name'];?>">--> View auctions on your Products and Coupons</a>
<?php
	foreach ($request_data as $key => $auction) {
?>
		<h2><?php echo $auction['category_name']?></h2>
<?php
		if(!is_null($auction['auction_title'])){
?>
			<div class="panel panel-default">
  			<div class="panel-body">
			<p><b><?php echo $auction['auction_title']?></b> <a href="/auctions/<?php echo implode("-", explode(" ", strtolower($auction['auction_title'])));?>">View</a></p>
			<!--<p><b><?php #echo $auction['auction_title']?></b> <a href="/auction/<?php #echo Model::encode_name(strtolower($auction['auction_title']));?>">View</a></p>-->

			<p><?php echo $auction['auction_description'];?></p>
			<p><?php echo $auction['auction_cost'];?></p>
			<p><?php echo date('F d, Y', strtotime($auction['auction_start']));?></p>
			<p><?php echo date('F d, Y', strtotime($auction['auction_finish']));?></p>
<?php
			if(date('F d, Y') > $auction['auction_finish']){
				echo "Finished<br /><br />";
			}
			if(!is_null($auction['auction_photo'])){
?>
				<img src="assets/img/uploads/auctions/<?php echo $auction['auction_photo']?>" alt="auction photo" style="width: 200px;height: 200px;">
<?php
			}
			else {
?>
				<img src="assets/img/uploads/auctions/default.png" alt="auction photo" style="width: 200px;height: 200px;">
				</div></div>
<?php
			}
		}
		else {
			?>
			<p>None</p>
			</div>
			<?php
		}
		/*
		foreach ($value as $k => $v) {
			# echo "<b>$k</b> => $v";
			if($k === 'auction_title'){
				echo "<b>$v</b>";
			}
			else if($k === 'auction_start' || $k === 'auction_finish'){
				echo date('F d, Y', strtotime($v));
			}
			else {
				echo $v;
			}
			echo "<br />";
		}
		*/
		# echo "</fieldset>";
		echo "<br />";
		# echo "<br />";
	}
}
else {
	?>
	<a href="<?php echo ROOT_URL . 'login';?>">You must log in to view auctions</a>
	<?php
}
?>