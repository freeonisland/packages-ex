<?php
/*
 * This file is part of RedisManager.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 App\Managers 
 */

namespace App\Managers;

//use Phalcon\Db\Adapter\Pdo\Sqlite;
use App\Adapters\DbAdapter;

class RedisManager extends DbAdapter
{
    private $client;
    private $resp;

    function __construct()
    {
        $this->init();
        $this->run();
    }

    function getConnection()
    {
        return $this->client;
    }

    private function run()
    {
        $this->resp = $this->sendCommands();
        $r = $this->getResponse();
       // v($r);
    }


    public function setPageCache($content)
    {
        //echo $content;
        $url = urlencode($_SERVER['REQUEST_URI']);
        $this->client->set('page_'.$url, base64_encode($content));
        $this->client->expire('page_'.$url, 4);
        //return true;
    }

    public function getPageCache()
    {return false;
        $url = urlencode($_SERVER['REQUEST_URI']);
        if( $p = $this->client->get('page_'.$url) ) {
            return base64_decode($p);
        }
        
        return false;
    }

    private function sendCommands()
    {
        $client = $this->client;

        //$client = new Predis\Client($single_server + array('read_write_timeout' => 0));

// Initialize a new pubsub consumer.
$pubsub = $client->pubSubLoop();

// Subscribe to your channels
$pubsub->subscribe('control_channel', 'notifications');

        //echo 'begin';
        $i=0;
        if(0)
        foreach ($pubsub as $message) {
            switch ($message->kind) {
                case 'subscribe':
                    echo "Subscribed to {$message->channel}", PHP_EOL;
                    break;
        
                case 'message':
                    if ($message->channel == 'control_channel') {
                        if ($message->payload == 'quit_loop') {
                            echo 'Aborting pubsub loop...', PHP_EOL;
                            $pubsub->unsubscribe();
                        } else {
                            echo "Received an unrecognized command: {$message->payload}.", PHP_EOL;
                        }
                    } else {
                        echo "Received the following message from {$message->channel}:",
                             PHP_EOL, "  {$message->payload}", PHP_EOL, PHP_EOL;
                    }
                    break;
            }
        }
        //echo 'en2d';
        unset($p);

        $r = $this->client->set('alpha', 90);
        return $r;
    }

    private function getResponse()
    {
        return $this->resp;
    }

    /*
    https://github.com/nrk/predis
    http://squizzle.me/php/predis/doc/#connection
    */

    function init()
    {
        //$client = new Predis\Client('unix:/path/to/redis.sock');
        $param = [
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => '6379'
        ];
        /*$param = array(
            'tcp://redis:6379',
          //  'tcp://redis_slv:6379'    
        );*/
        $opt = [
            'read_write_timeout' => 0
            //'replication' => 'sentinel',
           // 'service' => 'mymaster'
        /*
            profile: specifies the profile to use to match a specific version of Redis.
            prefix: prefix string automatically applied to keys found in commands.
            exceptions: whether the client should throw or return responses upon Redis errors.
            connections: list of connection backends or a connection factory instance.
            cluster: specifies a cluster backend (predis, redis or callable object).
            replication: specifies a replication backend (TRUE, sentinel or callable object).
            aggregate: overrides cluster and replication to provide a custom connections aggregator.
            parameters:  list of default connection parameters for aggregate connections.

            $options = [
            'replication' => 'sentinel',
            'service' => 'mymaster',
            'parameters' => [
                'password' => $secretpassword,
                'database' => 10,
            ],
        ];
        */
    ];
        $this->client = new \Predis\Client($param, $opt);
        $this->client->connect();
    }

    /*
        $client = new Predis\Client([
        'scheme' => 'tls',
        'ssl'    => ['cafile' => 'private.pem', 'verify_peer' => true],
        ]);

        // Same set of parameters, but using an URI string:
        $client = new Predis\Client('tls://127.0.0.1?ssl[cafile]=private.pem&ssl[verify_peer]=1');
    */

    /*
        $parameters = ['tcp://10.0.0.1?alias=master', 'tcp://10.0.0.2', 'tcp://10.0.0.3'];
        $options    = ['replication' => function () {
            // Set scripts that won't trigger a switch from a slave to the master node.
            $strategy = new Predis\Replication\ReplicationStrategy();
            $strategy->setScriptReadOnly($LUA_SCRIPT);

            return new Predis\Connection\Aggregate\MasterSlaveReplication($strategy);
        }];

        $client = new Predis\Client($parameters, $options);
        $client->eval($LUA_SCRIPT, 0);             // Sticks to slave using `eval`...
        $client->evalsha(sha1($LUA_SCRIPT), 0);    // ... and `evalsha`, too.
    */

    function pipeline()
    {
        /*$responses = $client->pipeline(function ($pipe) {
            for ($i = 0; $i < 1000; $i++) {
                $pipe->set("key:$i", str_pad($i, 4, '0', 0));
                $pipe->get("key:$i");
            }
        });*/
    }

    function transact()
    {
        /*
        $responses = $client->transaction(function ($tx) {
            $tx->set('foo', 'bar');
            $tx->get('foo');
        });

        // Returns a transaction that can be chained thanks to its fluent interface:
        $responses = $client->transaction()->set('foo', 'bar')->get('foo')->execute();
        */
    }

    function script()
    {
        /*
         *     public function getScript()
    {
        return <<<LUA
        math.randomseed(ARGV[1])
        local rnd = tostring(math.random())
        redis.call('lpush', KEYS[1], rnd)
        return rnd
        LUA;
            }
        }

        // Inject the script command in the current profile:
        $client = new Predis\Client();
        $client->getProfile()->defineCommand('lpushrand', 'ListPushRandomValue');

        $response = $client->lpushrand('random_values', $seed = mt_rand());
         */
    }

    function connect()
    {
        /*
         * $client = new Predis\Client('tcp://127.0.0.1', [
            'connections' => [
                'tcp'  => 'Predis\Connection\PhpiredisStreamConnection',  // PHP stream resources
                'unix' => 'Predis\Connection\PhpiredisSocketConnection',  // ext-socket resources
            ],
        ]); 

        class MyConnectionClass implements Predis\Connection\NodeConnectionInterface
        {
            // Implementation goes here...
        }

        // Use MyConnectionClass to handle connections for the `tcp` scheme:
        $client = new Predis\Client('tcp://127.0.0.1', [
            'connections' => ['tcp' => 'MyConnectionClass'],
        ]);
         */
    }

    private function _db()
    {
        $db = new Sqlite(
            [
                "dbname" => $this->config->database->dbname,
            ]
        );
        $r = $db->describeColumns('test');
        
        $db->begin();

        $smt = $db->prepare("INSERT INTO test(nom,pass) VALUES (:nom,:pass)");
        $smt->bindValue(':nom','alpha');
        $smt->bindValue(':pass', 2);
        $smt->execute();

        $db->commit();
    }

}