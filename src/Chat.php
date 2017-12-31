<?php
namespace App;
use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {

    protected $clients;
    protected $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $this->user[$conn->ressourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $from, $data) {
        $from_id = $from->ressourceId;
        $data = json_decode($data);
        $type = $data->type;
        switch ($type){
            case 'chat':
                $user_id = $data->user_id;
                $chat_msg = $data->chat_msg;
                $response_from = "<span style='color:#999'><b>".$user_id."</b> ".$chat_msg."</span><br /><br />";
                $response_to = "<b>".$user_id."</b>:".$chat_msg."<br /><br />";
                $from->send(json_decode(array("type"=>$type, "msg"=>$response_from)));

                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send(json_encode(array("type"=>$type, "msg"=>$response_to)));
                    }
                }
                break;

        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        unset($this->user[$conn->ressourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

/*$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8280
);
$server->run();*/
