<?php
    require '../classes/Pusher.php';
    
    $loop   = React\EventLoop\Factory::create();
    $pusher = new Pusher;
    // listen for zmq push after request
    $context = new React\ZMQ\Context($loop);
    $pull = $context->getSocket(ZMQ::SOCKET_PULL);
    // only self(127.0.0.1) connections for now
    $pull->bind('tcp://127.0.0.1:5555');
    $pull->on('message', array($pusher, 'onSubmission'));

    // Set up WebSocket server for clients wanting real-time updates
    // remotes can connect(0.0.0.0)
    $webSock = new React\Socket\Server('0.0.0.0:8080', $loop);
    $webServer = new Ratchet\Server\IoServer(
        new Ratchet\Http\HttpServer(
            new Ratchet\WebSocket\WsServer(
                new Ratchet\Wamp\WampServer(
                    $pusher
                )
            )
        ),
        $webSock
    );
    $loop->run();
?>