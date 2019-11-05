<?php
use PartnerDomain\Model;
use PartnerDomain\Sanitation;
use PartnerDomain\Utilities;

class PartnerModel extends Model {
	# Properties
	/**
	* @var int the provider id from db
	*/
	public $id = 0; 

	/**
	* @var int which category this provider belongs to
	*/ 
	public $category_id = 0;

	/**
	* @var string name of provider
	*/
	public $name = '';

	/**
	* @var string a short description
	*/
	public $description = '';

	/**
	* @var string website
	*/
	public $website = '';

	/**
	* @var string public phone number
	*/
	public $phone_number = '';

	/**
	* @var string street address line 1
	*/
	public $address_line_one = '';

	/**
	* @var string street address line 2
	*/
	public $address_line_two = '';

	/**
	* @var string - profile photo basename
	*/
	public $photo_basename = '';

	/**
	*
	*/
	public $public_email = null;

	/**
	*
	*/
	public $public_phone = null;

	/**
	*
	*/
	public $account_admin = null;

	/**
	*
	*/
	public $account_email = null;

	/**
	*
	*/
	public $account_phone = null;

	/**
	*
	*/
	public $products = array();

	/**
	*
	*/
	public $coupons = array();

	/**
	* @var array - the IDs of all active auctions hosted
	*/
	public $activeAuctions = array();

	/**
	*
	*/
	public $photo_basenames = null;

	/**
	* constructor sets object's properties using values in the supplied array
	*/
	public function __construct($data=array()){
		parent::__construct('partner', 'php');

		$this->id = (isset($data['id']) && !empty($data['id'])) ? (int)$data['id'] : $this->id;

		$this->category_id = (isset($data['category_id']) && !empty($data['category_id'])) ? (int)$data['category_id'] : $this->category_id;

		$this->name = (isset($data['name']) && !empty($data['name'])) ? (string) $data['name'] : $this->name;

		$this->description = (isset($data['description']) && !empty($data['description'])) ? (string) $data['description']: $this->description;

		$this->website = (isset($data['website']) && !empty($data['website'])) ? (string) $data['website'] : $this->website;

		$this->address_line_one = (isset($data['address_line_one']) && !empty($data['address_line_one']))? (string)$data['address_line_one'] : $this->address_line_one;
		
		$this->address_line_two = (isset($data['address_line_two']) && !empty($data['address_line_two']))? (string)$data['address_line_two'] : $this->address_line_two;

		$this->public_email = (isset($data['public_email']) && !empty($data['public_email']))? (string)$data['public_email'] : $this->public_email;

		$this->public_phone = (isset($data['public_phone']) && !empty($data['public_phone']))? (string)$data['public_phone'] : $this->public_phone;

		$this->account_admin = (isset($data['account_admin']) && !empty($data['account_admin'])) ? (string) $data['account_admin'] : $this->account_admin;

		$this->account_email = (isset($data['account_email']) && !empty($data['account_email'])) ? (string) $data['account_email'] : $this->account_email;

		$this->account_phone = (isset($data['account_phone']) && !empty($data['account_phone'])) ? (string) $data['account_phone'] : $this->account_phone;

		$this->photo_basenames = array (
			isset($data['photo_one'])   ? $data['photo_one']   : 'default',
			isset($data['photo_two'])   ? $data['photo_two']   : 'default2',
			isset($data['photo_three']) ? $data['photo_three'] : 'default3',
			isset($data['photo_four'])  ? $data['photo_four']  : 'default4',
			isset($data['photo_five'])  ? $data['photo_five']  : 'default5',
		);
	}

	/**
	* Sets object's properties using the edit from post values in the supplied array
	*
	* @param assoc array  form values
	*/
	public function store_form_values($form_values){
		$this->__construct($form_values);
	}


	/**
	* Returns a Partner object matching given hash 
	*
    * @param string the parner hash
    * @return PartnerModel object if the record was found, null otherwise
	*/

	public static function getByHash($hash = null){
		$partner = null;

		$query = "SELECT p.id, c.category_id, p.hash, p.name, p.description, p.website, p.address_line_one, p.address_line_two, p.photo_one, p.photo_two, p.photo_three, p.photo_four, p.photo_five, p.public_email, p.public_phone
		         FROM partner p
		         INNER JOIN category c
		         ON p.hash=?
		         AND p.category_id=c.category_id";

		$results = self::selectPrepared($query, 's', $hash);
		if(!empty($results[0])){
			$partner = new self($results[0]);
		}
		return $partner;
	}

	/**
	* Returns a Partner object matching given id 
	*
    * @param int the partner name
    * @return Partner obj|false the partner object, or false if the record was found 
    * or there was a problem
	*/

	public static function getById($id){
		$partner = null;
		$query = "SELECT * FROM partner WHERE id=?";
		$results = self::selectPrepared($query, 'i', $id);
		if (!empty($results[0])) {
			$partner = new self($results[0]);
		}
		return $partner;
	}

	/**
	*
	*/
	public static function add(){
		if(isset($_POST['submit'])){ 
			$clean_post = PartnerDomain\Sanitation::clean_data($_POST);
			$clean_photos = PartnerDomain\Sanitation::clean_data($_FILES);
			$upload = array_merge($clean_post, $clean_photos);

			$partner = new self($upload);
			$photo_upload_status = Utilities::upload_photos(constant("PARTNER_IMG_DIR"), $clean_photos);

			$partner->hash = Utilities::getUniqueHash('partner');


			$query = "INSERT IGNORE INTO partner(hash, category_id, name, description, website, address_line_one, address_line_two, photo_one, photo_two, photo_three, photo_four, photo_five, public_email, public_phone, account_admin, account_email, account_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			$insertStatus = self::affectRowsPrepared($query, 'sisssssssssssssss', $partner->hash,
				                                                                  $partner->category_id, 
				                                                                  $partner->name, 
				                                                                  $partner->description, 
				                                                                  $partner->website,
				                                                                  $partner->address_line_one, 
				                                                                  $partner->address_line_two, 
				                                                                  $partner->photo_basenames[0], 
				                                                                  $partner->photo_basenames[1],
				                                                                  $partner->photo_basenames[2],
				                                                                  $partner->photo_basenames[3],
				                                                                  $partner->photo_basenames[4],
				                                                                  $partner->public_email, 
				                                                                  $partner->public_phone, 
				                                                                  $partner->account_admin, 
				                                                                  $partner->account_email, 
				                                                                  $partner->account_phone)['affected_rows'];

			return $insertStatus;
		}
	}
	/**
	*
	*/
	public function update(){
		$query = "UPDATE partner 
		          SET name=?, description=?, website=?, address_line_one=?, address_line_two=?, photo_one=?, photo_two=?, photo_three=?, photo_four=?, photo_five=?, public_email=?, public_phone=?, account_admin=?, account_email=?, account_phone=? 
		          WHERE id=?";

		 var_dump($this);

		$updateResult = self::affectRowsPrepared($query, 'sssssssssssssssi', $this->name, $this->description, $this->website, $this->address_line_one, $this->address_line_two, $this->photo_basenames[0], $this->photo_basenames[1], $this->photo_basenames[2], $this->photo_basenames[3], $this->photo_basenames[4], $this->public_email, $this->public_phone, $this->account_admin, $this->account_email, $this->account_phone, $this->id)['affected_rows'];

		var_dump($updateResult);
		
		return $updateResult;
	}

	/**
	* Deletes current Provider object from database
	* called on button push and form submission on partner account page 
	* called on delete account button press
	* @return int 	success or failure
	*/

	public function delete(){
		$query = "DELETE FROM partner WHERE id=?";

		$deleteStatus = self::affectRowsPrepared($query, 'i', $this->id)['affected_rows'];
		if ($deleteStatus == 1) {
			foreach ($this->photo_basenames as $photo) {
				unlink(constant("PARTNER_IMG_DIR") . $photo . constant("IMG_EXTENSION"));
			}
		}

		return $deleteStatus;
	}


	/**
	*
	*/
	public static function index() {
		return;
	}	

	/**
	* @todo 
	* @return PartnerModel object
	*/
	public static function profile($hash){
		return PartnerModel::getByHash($hash);
	}

	/**
	*
	*/
	public static function account(){
		$dbh = Model::give_dbh();
		
			$partner = PartnerModel::get_by_id($_SESSION['partner_id']);

			if(isset($_POST['submit_update'])){
				$cleanPost = Sanitation::clean_data($_POST);

				$partner->store_form_values($cleanPost);
				$updateStatus = $partner->update();

				switch ($updateStatus) {
					case -1:
						echo 'Error Updating Profile';
						break;
					case 0:
						echo 'No Changes made to Profile';
				 		break;
					case 1:
						echo 'Update Profile successful!';
						break;
				
					default:
						break;
				}
		}

			if(isset($_POST['submit_delete'])){
				$delete_status = $partner->delete();

				switch ($delete_status) {
					case false:
						Messages::set_message('Error Deleting Account', 'error');
						break;
					case true:
						HomeModel::logout();
						Messages::set_message('Account Deleted. We\'re sorry to see you go. If your experience was unenjoyable, please leave us feedback <a href="/feedback">here</a>');
						header("Location: " . ROOT_URL);
						exit();
						break;
					
					default:
						break;
				}
				
			}
		return $partner;
	}
}
?>