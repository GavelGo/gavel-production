<?php
/**
* unit tests for main site
*/

use PHPUnit\Framework\TestCase;

class UserTests extends TestCase {
	# url encoding

	# each business object has essential properties set after fetch(may be redundant)

	# check google maps url encoding, 200 status for each

	# check 200 status for every link? maybe with a web crawler

	# registration: call register with
		# 1) good data, user does not already exists, assert count of users is ++
		# 2) user already exists, assert count stays the same
		# 3) bad data, user count stays the same 
}
?>