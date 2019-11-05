<?php
/**
*
*/
class CategoryModel extends PartnerDomain\Model {
	/**
	*
	*/
	public $id = 0;

	/**
	*
	*/
	public $name = '';

	/**
	*
	*/
	public $description = '';

	/**
	*
	*/
	public $displayIcon = '';

	/**
	*
	*/
	public $subcategories = array();

	/**
	*
	*/
	public function __construct($data = array()){
		parent::__construct();

		$this->id = (isset($data['category_id'])) ? 
			(int)$data['category_id'] : 
			$this->id;

		$this->name = (isset($data['category_name'])) ? 
			(string) $data['category_name'] : 
			$this->name;

		$this->description = (isset($data['category_description'])) ? 
			(string) $data['category_description'] : 
			$this->description;

		$this->displayIcon = (isset($data['category_icon'])) ? 
			(string) $data['category_icon'] : 
			$this->description;
	}

	/**
	*
	*/
	public function index(){
		return $this->get_with_subcategories();
	}

	/**
	* get all with subcategories
	*/
	public function get_with_subcategories($name = ''){
		$category_row = array();
		if(empty($name)){
			$query = "SELECT c.category_id, c.category_name, GROUP_CONCAT(s.subcategory_name SEPARATOR ',') as 'subcat_list' FROM category c LEFT JOIN subcategory s ON c.category_id=s.subcategory_id GROUP BY c.category_id";
			if($result = self::$dbh->query($query)){
    			while($row = $result->fetch_assoc()){
					$category_row[$row['category_id']] = $row;
				}
			}
			else {
				echo self::$dbh->error;
			}
		}
		else{
			# for individual profile page: 
			if($stmt = self::$dbh->prepare("SELECT c.category_id, c.category_name, c.category_description, GROUP_CONCAT(s.subcat_name SEPARATOR ',') AS 'subcat_list' FROM category c LEFT JOIN subcategories s ON c.category_name=? AND c.category_id=s.category_id")){
				$stmt->bind_param('s', $name);
				if(!$stmt->execute()){
					Messages::set_message('Could not retrieve info!', 'error');
				}
				else {
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$category_row = $row;
				}
			}

		}
		return $category_row;
	}

	/**
	*
	*/
	public static function getCategoryNames(){
		$categoryNames = array();

		if($result = self::$dbh->query("SELECT category_id, category_name FROM category")){
			while($row = $result->fetch_assoc()){
				$category = new self($row);
				$categoryNames[] = $category;
			}
			$result->close();
			self::$dbh->close();
		}

		return $categoryNames;
	}





	/**
	*
	*/
	public function profile($name = ''){
		return $this->get_with_subcategories($name);
	}

	/**
	*
	*/
	public function sub_profile($name = ''){
		return 1;
	}

}
?>