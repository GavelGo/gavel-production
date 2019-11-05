<?php
namespace PartnerDomain;

class Websocket {
	public static function connect_publisher() {
		$context = new \ZMQContext();
		$socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'pusher');
		$socket->connect("tcp://127.0.0.1:5555");
		return $socket;
	}
}
?>