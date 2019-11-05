<?php
require '../config.php';
require '../../vendor/autoload.php';
require '../classes/Model.php';
require '../classes/Utilities.php';
require '../models/Notification.php';

use PartnerDomain\Model;
use PartnerDomain\Notification as Notification;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\MessageComponentInterface;

/**
* @todo maybe consolidate a few functions, e.g. onCouponEntry and onAuctionEntry
*/
class Pusher implements WampServerInterface {
    // all types of incoming requests
    protected $submissionTypes = array(
        // event              => handler name
        'couponActivity'      => 'onCouponActivity',   // a coupon event occurs, e.g. edit, end
        'auctionActivity'     => 'onAuctionActivity',  // a coupon event occurs, e.g. edit, end, new bid
        'partnerActivity'     => 'onPartnerActivity',  // a provider creates or updates content
        'categoryActivty'     => 'onCategoryActivity', // a post in a category
        'makeCustomerOffer'   => 'onCustomerOffer',    // a customer makes an offer to a provider
        'makeProviderOffer'   => 'onProviderOffer',    // a provider makes an offer to a customer
        'sendCustomerMessage' => 'onCustomerMessage',  // a customer sends a message to a provider
        'sendProviderMessage' => 'onProviderMessage'   // a provider sends a message to a customer
    );

    protected $subscribers = array();

    // only need one array
    // this is because $topic is an object in the Ratchet library, not just what 
    // we're calling the subscription 
    // this will be filled with all active auction ids, all categories
    // that may make the array very large, so may still need a better solution
    protected $subscribedTopics = array();

    /**
    * add to array based on submission type
    * may need to fill arrays on login
    * @param conn - connection object provided by Ratchet
    * @param topic - Topic object, the literal written in the js on the get page
    */
    public function onSubscribe(ConnectionInterface $conn, $topic) {
        $this->subscribedTopics[$topic->getId()] = $topic;
        $this->subscribers[$conn->resourceId] = $conn;
    }

    /**
    * remove topic and subscriber
    */
    public function onUnSubscribe(ConnectionInterface $conn, $topic) {
        unset($this->subscribedTopics[$topic->getId()]);
        unset($this->subscribers[$conn->resourceId]);
    }
    
    /**
    * create connection
    */
    public function onOpen(ConnectionInterface $conn) {
        $this->subscribers[$conn->resourceId] = $conn;
        echo "pusher/onOpen: " . PHP_EOL;
        print_r(array_keys($this->subscribers));
    }

    /**
    * close connection
    */
    public function onClose(ConnectionInterface $conn) {
        unset($this->subscribers[$conn->resourceId]);
    }

    /**
    * a direct invocation from the console
    */
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    /**
    * catch publish events client side
    * @param conn  - publisher
    * @param topic - receiver
    * @param event - what was published
    */
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
        foreach ($this->subscribers as $rid => $subscriber) {
                $topic->broadcast($event);
        }
    }

    /**
    *
    */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        // log
    }

    /**
    * receive all requests, delegate to corresponding function
    */
    public function onSubmission($activity) {
        $content = json_decode($activity, true);

        // request type does not exist
        if (!array_key_exists($content['submission_type'], $this->submissionTypes)) {
            return;
        }
        // request type exists, call the corresponding function
        try {
            $func = $this->submissionTypes[$content['submission_type']];
            $this->$func($content);
        }
        catch(Exception $e){
            // log
        }

        return;
    }

    /**
     * actions to take when a coupon is added 
     * @param string - JSON'ified string received from ZeroMQ
     */
    public function onCouponEntry($entry) {
        // $entryData = json_decode($entry, true);

        // the lookup coupon object isn't set there is no one to publish to
        // $entryData['category_id'] is where we're looking for the matching string the user is subscribed to
        if (!array_key_exists($entry['category_id'], $this->subscribedTopics)) {
            return;
        }
        $topic = $this->subscribedTopics[$entryData['category_id']];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($entryData);
    }

    /**
     * actions to take when an auction is added
     * @param string - JSON'ified string received from ZeroMQ
     */
    public function onAuctionEntry($entry) {
        $entryData = json_decode($entry, true);

        // If the lookup auction object isn't set there is no one to publish to
        //$entryData['category_id'] is where we're looking for the matching string the user js subscribed to
        if (!array_key_exists($entryData['category_id'], $this->subscribedTopics)) {
            return;
        }
        $topic = $this->subscribedTopics[$entryData['category_id']];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($entryData);
    }

    /**
    * actions to take when a user submits a bid in an auction
    * @param string - JSON'ified string 
    */
    public function onCustomerOffer($offer) {
        $offerData = json_decode($offer, true);

        // If the lookup offer object isn't set there is no one to publish to
        if (!array_key_exists($offerData['auction_id'], $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics[$offerData['auction_id']];

        $topic->broadcast($offerData);
    }

    /**
    *
    */
    public function onPartnerActivity($content) {
        $body = "New ";
        switch ($content['content_type']) {
            case 'coupon':
                $body .= "coupon";
                break;

            case 'auction':
                $body .= "auction";
                break;
            
            default:
                $body .= "item";
                break;
        }
        $body .= " from " . $content['partner_name'] . ": " . $content['title'];

        if (array_key_exists($content['partner_hash'], $this->subscribedTopics)) {
            $notification = Notification::saveUserNotification($content['content_type'], $content['partner_hash'], $content['category_hash'], $body, $content['hash']);

            $content['link'] = $notification->link;
            $content['body'] = $notification->body;
            $content['notification_id'] = $notification->id;

            $topic = $this->subscribedTopics[$content['partner_hash']];
            $topic->broadcast($content);
        }
    }
}
?>