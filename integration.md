# integration notes

## types of request data
- Model object, whose fields are accessed directly
- associative array of Model objects, who are iterated over
- associative array of simple fields, e.g. strings and ints

## main side
- main: none

### bids
- add: none
- auction: object

### categories
- index: associative array
- profile: associative array, will be changed to object
- sub: ignore, this will change

### coupons
- add: none
- auction: object
- index: object
- profile: object

### home
- 404: none
- careers: none
- comingsoon: none
- contact: none
- explore: associative array of objects
- feeback: none
- gavelgo: none
- index: none
- info: none
- login: none
- logout: none
- notfound: none
- recover: none
- support: none
- terms: none

### partners
- index: associative array
- profile: object

### search
- index: none

### users
- index: none
- profile: object with associative arrays
- verify: none

## partners site
- main.php: none

### analytics
- index: None

### bids
- index: associative array
- profile: object

### coupons
- add: none
- auction: object
- profile: object

### home
- activate: none, this page will change
- feedback: none
- index: associative array
- login: none
- logout: none
- notfound: none
- register: none
- support: none
- verify: none

### partners
- account: object
- edit_profile: object
- listings: object
- mybids: associative array
- profile: object

### products
- add: none
- profile: object

## admin portal