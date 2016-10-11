<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 10/11/16
 * Time: 8:43 AM
 */

namespace Tjcelaya\Laravel5\Vitess;

use Exception;
use Illuminate\Database\MySqlConnection;
use PDO;

class Connection extends MySqlConnection
{

    /**
     * VitessConnection constructor.
     *
     * @param $config
     */
    public function __construct(array $config = array())
    {
        $keyspace                 = array_get($config, 'database');
        $host                     = array_get($config, 'host');
        $port                     = array_get($config, 'port');
        $vitess_connection_string = "vitess:keyspace={$keyspace};host={$host};port={$port}";
        $this->pdo                = new \VitessPdo\PDO($vitess_connection_string);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($config['read_from_master']) && $config['read_from_master']) {
            $this->pdo->getClusterConfig()->readFromMaster();
        }
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchemaBuilder()
    {
        throw new Exception('Vitess driver does not support Schema');
    }
}