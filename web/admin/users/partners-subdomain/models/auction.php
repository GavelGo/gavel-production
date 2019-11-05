<?php
use PartnerDomain\Model;
use PartnerDomain\Utilities;

class AuctionModel extends Model {
	public $id = 0;
	public $hash = null;
	public $partnerId = null;
	public $partnerName = null;
	public $partnerHash = null;
	public $categoryId = null;
	public $category_name = null;
	public $title = null;
	public $description = null;
	public $currentOffer = null;
	public $reservePrice = null;
	public $minimumIncrement = null;
	public $comments = null;
	public $start = null;
	public $finish = null;
	public $time_submitted = null;
	public $photo_basenames = null;

	/**
	* constructor sets object's properties using values in the supplied array
	*/
	public function __construct($data = array()){
		parent::__construct('auction', 'php');

		$this->id = (isset($data['id'])) ? 
			(int)$data['id'] : 
			$this->id;

		$this->hash = (isset($data['hash'])) ? 
			(string)$data['hash'] : 
			$this->hash;

		$this->categoryId = (isset($data['category_id'])) ? 
			(string) $data['category_id'] : 
			$this->categoryId;

		$this->category_name = (isset($data['category_name'])) ? 
			(string) $data['category_name'] : 
			$this->category_name;

		$this->partnerId = (isset($data['partner_id'])) ? 
			(string) $data['partner_id'] : 
			$this->partnerId;

		$this->partnerHash = (isset($data['partner_hash'])) ? 
			(string) $data['partner_hash'] : 
			$this->partnerHash;

		$this->partnerName = (isset($data['partner_name'])) ? 
			(string) $data['partner_name'] : 
			$this->partnerName;

		$this->title = (isset($data['title'])) ? 
			(string) $data['title'] : 
			$this->description;

		$this->description = (isset($data['description'])) ? 
			(string) $data['description'] : 
			$this->description;

		$this->currentOffer = (isset($data['offer'])) ? 
			(string) $data['offer'] : 
			$this->currentOffer;

		$this->reservePrice = (isset($data['reserve_price'])) ? 
			(string) $data['reserve_price'] : 
			$this->reservePrice;

		$this->minimumIncrement = (isset($data['minimum_increment'])) ? 
			$data['minimum_increment'] : 
			$this->minimumIncrement;

		$this->comments = (isset($data['comments'])) ? 
			(string) $data['comments'] : 
			$this->comments;

		$this->start = (isset($data['start'])) ? 
			self::getDateTime((string) $data['start']) : 
			$this->start;

		$this->finish = (isset($data['finish'])) ? 
			self::getDateTime((string) $data['finish']) : 
			$this->finish;

		$this->time_submitted = (isset($data['submitted'])) ? 
			self::getDateTime((string) $data['submitted']) : 
			$this->time_submitted;

		$this->photo_basenames = array (
			isset($data['photo_one'])   ? $data['photo_one']   : 'default',
			isset($data['photo_two'])   ? $data['photo_two']   : 'default',
			isset($data['photo_three']) ? $data['photo_three'] : 'default',
			isset($data['photo_four'])  ? $data['photo_four']  : 'default',
			isset($data['photo_five'])  ? $data['photo_five']  : 'default',
		);	
	}

	/**
	*
	*/
	public function index() {
		$auctions = null;

		$query = "SELECT c.category_id AS category_id, c.category_name, a.id, a.hash, p.id AS partner_id, p.name AS partner_name, p.hash AS partner_hash, a.title, a.description, a.offer, a.reserve_price, a.minimum_increment, a.start, a.finish, a.photo_one, a.submitted
		          FROM category c 
		          LEFT JOIN partner_auction a 
		          ON c.category_id=a.category_id
		          INNER JOIN partner p
		          ON a.partner_id=p.id";

		$results = self::select($query);
		foreach ($results as $row) {
			$auction = new self($row);
			$auctions[] = $auction;
		}
		return $auctions;
	}

	/**
	*
	*/
	public function add($partnerId = 0){
		$auction = null;

		if(isset($_POST['submit'])){
			$clean_post = PartnerDomain\Sanitation::clean_data($_POST);
			$clean_photos = PartnerDomain\Sanitation::clean_data($_FILES);
			$upload = array_merge($clean_post, $clean_photos);

			$auction = new self($upload);
			$photo_upload_status = Utilities::upload_photos("partners-subdomain/assets/img/uploads/auctions", $clean_photos);

			if ($partnerId == 0 && isset($clean_post['partner_id'])) {
				$partnerId = $clean_post['partner_id'];
			}

			$startTimestamp = Utilities::convertDateToTimestamp($auction->start);
			$endTimestamp   = Utilities::convertDateToTimestamp($auction->finish);
			$auction->hash  = Utilities::getUniqueHash('partner_auction');

			$query = "INSERT INTO partner_auction(partner_id, category_id, title, hash, description, reserve_price, minimum_increment, start, finish, photo_one, photo_two, photo_three, photo_four, photo_five) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$affectedRows = self::affectRowsPrepared($query, 'iisssiisssssss', $partnerId, 
																			    $auction->categoryId, 
																			    $auction->title, 
																			    $auction->hash, 
																			    $auction->description, 
																			    $auction->reservePrice, 
																			    $auction->minimumIncrement, 
																			    $startTimestamp, 
																			    $endTimestamp, 
																			    $auction->photo_basenames[0], 
																			    $auction->photo_basenames[1],
																			    $auction->photo_basenames[2],
																			    $auction->photo_basenames[3],
																			    $auction->photo_basenames[4]);
			return $auction;
		}
	}

	/**
	*
	*/
	public static function getByHash($hash) {
		$auction = null;

		$query = "SELECT a.id, a.partner_id, a.category_id, a.title, a.hash, a.description, a.offer, a.reserve_price, a.minimum_increment, a.start, a.finish, a.submitted, a.photo_one, a.photo_two, a.photo_three, a.photo_four, a.photo_five, c.category_name, p.name AS partner_name, p.hash AS partner_hash
		          FROM partner_auction a 
		          INNER JOIN category c 
		          ON a.hash=? 
		          AND a.category_id=c.category_id 
		          INNER JOIN partner p 
		          ON a.partner_id=p.id";
		
		$query_results = self::selectPrepared($query, 's', $hash);
		if (!empty($query_results[0])) {
			$auction = new self($query_results[0]);
		}

		return $auction;
	}

	/**
	* called when auction profile page is loaded
	* may add more later
	*/
	public function profile($hash){
		return self::getByHash($hash);
	}

	/**
	* update current offer
	*
	* @param userId - int : the id of the bidder
	* @param bid - int : numerical value of the offer
	*
	* @return 1 if successful, 0 otherwise
	* @todo save successful bid to bid history
	*/
	public function makeBid($userId, $bid) {
		$updateStatus = 0;
		$insertStatus = 0;

		if ($this->id != 0) {
			if ($bid > $this->getCurrentOffer()) {
				$query = "UPDATE partner_auction SET offer=? WHERE id=?";
				$updateStatus = self::affectRowsPrepared($query, 'ii', $bid, $this->id)['affected_rows'];

				if ($updateStatus == 1) {
					$query = "INSERT INTO bid_history(auction_id, bid, user_id) VALUES(?,?,?)";
					$insertStatus = self::affectRowsPrepared($query, 'iii', $this->id, $bid, $userId)['affected_rows'];
				}
			}
		}
		return ($updateStatus == 1 && $insertStatus == 1);
	}

	/**
	* get the value and user of the highest bid on the current bid
	*
	* @return assoc array of user id and offer 
	*/
	public function getCurrentOffer() {
		$currentBid = null;

		if ($this->hash != null) {
			$query = "SELECT offer FROM partner_auction WHERE hash=?";
			$currentBid = self::selectPrepared($query, 'i', $this->hash)[0]['offer'];
		}
		return $currentBid;
	}

	/**
	* @todo format created time
	*/
	public function getBidHistory() {
		$query = "SELECT h.bid, h.created, u.user_first_name, u.user_last_name
		                 FROM bid_history h
		                 INNER JOIN users u
		                 ON h.auction_id=?
		                 AND h.user_id=u.user_id
		                 ORDER BY bid DESC";
		$bids = self::selectPrepared($query, 'i', $this->id);
		foreach ($bids as &$bid) {
			$bid['created'] = self::getDateTime($bid['created']);
		}

		$query = "SELECT COUNT(DISTINCT user_id) AS unique_bidders, COUNT(bid) as bid_count
		          FROM bid_history
		          WHERE auction_id=?";
		$stats = self::selectPrepared($query, 'i', $this->id)[0];
		$uniqueBidders = $stats['unique_bidders'];
		$bidCount      = $stats['bid_count'];

		return array(
			'unique_bidders' => $uniqueBidders,
			'bid_count'      => $bidCount,
			'bids'           => $bids
		);
	}
}
?>