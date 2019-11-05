## pub sub notes

### most recent changes

### reminders
* notification table needs all hashes instead of ids, so that we can search the table based on subscriptions

### merge request
* only the latest commit is noteworthy, all earlier pushes had unfinished and/or broken code(sorry)

### subscipritions
* possible subscriptions
   * user domain
      * posts from single providers
    * posts in single categories
    * single coupons
    * single auctions/bids
    * offers
    * messages
       * all
     * from providers
     * from admin/site
   * provider domain
      * messages
       * all
     * from admin/site
     * from users
    * all coupons

### db structure
* provider_auction_subscription
  * auctions posted by providers
* user_auction_subscription
  * auctions posted by users
* user_message
  * messages from users to providers
* provider_message
  * messages from providers to users
* provider_coupon_subscription
  * coupon posted by provider
* user_coupon_subscription
  * coupon posted by user
* notification
  *
* notification_type
  * e.g. coupon_notification, auction_notification, partner_notification, account_notification
* user_notification_preference
  * for each notif type, whether the user wants to receive notifications
* partner_notification_preference
  * same as previous, but for users

### todo
* send multiple submission types, filter out duplicates
* coupon + auction activity 
* category activity

#### WIP
* choose notification defaults
* generate links for notification bar
* db tables
* remove extra/old standalone files and integrate code to corresponding pages

#### later
* preferences
   * add db tables back in
   * add Notification functions
   * move get preferences functions to user model and partner model
   * call get preferences in user_handler so only insert into user_notification_status if preferences match activity
   * set default preferences on signup

#### maybe
* move js datetime conversion

#### done - partial list
* move chat code to own branch/directory
* subscribe to coupon, auction, partner hashes instead of pkey ids
* update notification model ctor
* ajax save
* test saveUserNotificationStatus
* finish saveUserNotification
* update getUserNotifiations to join notification with user_notification_status
* move Notification.php to models/ and rename
* set as read on notification click

### final structure
* change autbahn script to prod link below
* subscription script in main
* posting connection in Utilities.php or Websocket.php
* config file
  * socket endpoint
  * subscription prefixes
  * notification element
  * messages element
  * notification defaults

* Notification.php
  * save all types of subscription preferences
  * retrieve preferences
  * save all types of notifications
  * retrieve all or some of notifications
  * update unread to read

### writeup notes
* some functions and features not exclusive to notifications are included, since the module heavily depends on them. The main example is indexing and searching for business objects by hash, not auto incremented primary key id. Another is Coupon::add()

* some functionality was implemented on this branch then removed, since it was either unecessary at the moment or may not be desirable.

* some functionality is not included since it is better suited for the `integration` branch. For example, when a partner adds an item, along with inserting that item into the database, that page opens a socket and broadcasts the event. the code for this is written and works, but as i said, will be left to the `integration` branch.

### autobahn prod script

* https://gist.githubusercontent.com/cboden/fcae978cfc016d506639c5241f94e772/raw/e974ce895df527c83b8e010124a034cfcf6c9f4b/autobahn.js