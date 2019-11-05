<?php
// THIS IS OLD

/**
*
*/
class EmployeeModel extends Model{
	# Properties
	/**
	* @var int the coupon id from db
	*/
	public $id = 0; 

	/**
	* 
	*/
	public $access_level = 0; 

	/**
	* 
	*/
	public $full_name = '';

	/**
	* 
	*/
	public $email = '';

	/**
	* @var string a short bio
	*/
	public $bio = '';

	/**
	* @var string photo basename
	*/
	public $photo = '';

	/**
	* constructor sets object's properties using values in the supplied array
	*/
	public function __construct($data=array()){		
		# parent constructor not implicity called, so must call to initialize self::$dbh: 
		parent::__construct();	

		$this->id             = (isset($data['admin_id'])) ? (int)$data['admin_id'] : $this->id;

		$this->access_level   = (isset($data['admin_permission_level'])) ? (int)$data['admin_permission_level'] : $this->access_level;

		$this->full_name     = (isset($data['admin_full_name'])) ? (string)$data['admin_full_name'] : $this->full_name;

		# $this->last_name      = (isset($data['admin_last_name'])) ? (string)$data['admin_last_name'] : $this->last_name;

		$this->email          = (isset($data['admin_email'])) ? (string)$data['admin_email'] : $this->email;

		$this->bio  		  = (isset($data['admin_bio'])) ? (string) $data['admin_bio']: $this->bio;

		$this->photo 		  = (isset($data['admin_photo']))? (string)$data['admin_photo'] : $this->photo;
	}

	/**
	* Returns a Employee object matching given account email 
	*
    * @param string the partner email
    * @return the PartnerModel object or null if the record was not found or there was a problem
	*/

	public static function get_by_email($email = ""){
		if($stmt = self::$dbh->prepare("SELECT admin_id, admin_permission_level, admin_full_name, admin_email, admin_photo FROM admin WHERE admin_email=?")){
			$stmt->bind_param('s', $email);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				$row = $result->fetch_assoc(); 
				$stmt->close();
				return new EmployeeModel($row);
			}
			$stmt->close();
		}
		else {
		}
		return null;
	}

	/**
	* Returns a Employee object matching given paramter 
	*
    * @param string the employee email or int employee id or string employee name
    * @return a PartnerModel object or null if the record was not found or there was a problem
	*/

	public static function get_by_name($name = ''){
		$real_name = implode(" ", explode("-", $name));
		if($stmt = self::$dbh->prepare("SELECT admin_id, admin_permission_level, admin_full_name, admin_email, admin_photo, admin_bio FROM admin WHERE admin_full_name=?")){
			$stmt->bind_param('s', $real_name);
			if(!$stmt->execute()){
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				$row = $result->fetch_assoc(); 
				$stmt->close();
				#var_dump($row);
				return new EmployeeModel($row);
			}
			else {

			}
			$stmt->close();
		}
		else {

		}
		return null;
	}

	public function index(){
		# TODO: reduce spaghetti code: 
		if(!Authentication::has_permission($_SESSION['admin_id'], 2)){
				Messages::set_message('You do not have clearance', 'error');
				// header("Location: " . ROOT_URL . 'login');
				exit();
			}
			else {
				# will be list of EmployeeModel objects: 
				$list = array();

				if($stmt = self::$dbh->query("SELECT admin_id, admin_permission_level, admin_full_name, admin_email FROM admin")){
					while($row = $stmt->fetch_assoc()){
						$employee = new EmployeeModel($row);
						$list[] = $employee;
					}
				}
				return $list;
			}
	}

	/**
	*
	*/
	public function profile($name = ""){
		if(isset($_SESSION['admin_id'])){
			if(!Authentication::has_permission($_SESSION['admin_id'], 3)){
				Messages::set_message('You do not have clearance', 'error');
				# return;
			}
			else {
				$employee = EmployeeModel::get_by_name($name);
				return $employee;
			}
		}
		else {
			Messages::set_message('You must log in', 'error');
  			header("Location: " . ROOT_URL . 'login');
  			exit();
		}
		return null;
	}

	/**
	*
	*/
	public function hours(){
		return;
	}











}
?>