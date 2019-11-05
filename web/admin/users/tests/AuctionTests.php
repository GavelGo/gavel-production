<?php
/**
* live bidding unit tests
*/

use PHPUnit\Framework\TestCase;

class AuctionTests extends TestCase {
    /*
    * bid increment
    * require higher offer
    * expiration time
    * limit single user bid rate
    * popularity calculation
    */
    
    public function testBidIncrement () : void {
        $bidId = 0;
	$currentOffer = 400;
        $bid = new Bid($bidId, $currentOffer);
	$bidder = new UserModel();
	$bidder->makeBid($bidId, 500);

        $this->assertEquals($bid->getCurrentOffer(), 500);
    }

    public function testRequireHigherOffer () : void {
        $bidId = 0;
        $currentOffer = 400;
        $bid = new AuctionModel($bidId, $currentOffer);
        $bidder = new UserModel();
        $bidder->makeBid($bidId, 300);

        $this->assertEquals($bid->getCurrentOffer(), 400);
    }

    public function testBidExpiration () : void {
        $bidId = 0;
	$bidExpirationTimestamp = "";
	$currentTimestamp = ""; // before expiration
	$bid = new AuctionModel($bidId, $bidExpirationTimestamp);
	
        $this->assertTrue($bid->getExpirationTimestamp() > $currentTimestamp);
        $this->assertEquals($bid->isExpired(), false);
	
        $currentTimestamp = ""; // after expiration
	$this->assertTrue($bid->getExpirationTimestamp < $currentTimestamp);
	$this->assertEquals($bid->isExpired(), true);
    }

    public function testLimitBidRate () : void {
        $bidId = 0;
	$bid = new AuctionModel($bidId, 100);
	$bidder = new UserModel();
	$bidder->makeBid(200);
	//wait less than limit
	$bidder->makeBid(300);
	$this->assertTrue($bid->bidRateLimitReached());

        $bidder->makeBid(300);
	// wait more than limit
	$bidder->makeBid(400);
	$this->assertFalse($bid->bidRateLimitReached());
    }
}