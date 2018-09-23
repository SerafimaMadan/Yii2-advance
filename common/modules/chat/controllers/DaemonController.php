<?php

namespace common\modules\chat\controllers;

use common\modules\chat\components\Chat;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use yii\console\Controller;

/**
 * Default controller for the `chat` module
 */
class DaemonController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );

        $server->run();
        echo 'It is working' . PHP_EOL;
        $server->loop->addPeriodicTimer(5, function () {
            echo date('H:i:s') . PHP_EOL;
        });

        $server->run();

    }

}
