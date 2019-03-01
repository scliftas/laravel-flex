<?php

namespace Shaunclift\Flex\Managers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\ConnectionInterface;
use Shaunclift\Flex\Exceptions\UnsupportedDatabaseTypeException;

class DatabaseManager
{
    /**
     * The current database connection
     *
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Type of the database connection
     *
     * @var String
     */
    protected $type;

    /**
     * Create a new database manager instance
     *
     * @param String $type
     * @param ConnectionInterface $connection
     */
    public function __construct(String $type, ConnectionInterface $connection = null)
    {
        if (!in_array($type, DB::availableDrivers())) throw new UnsupportedDatabaseTypeException('Unsupported databse type provided: ' . $type);

        $this->connection = $connection ?: DB::connection($type);
        $this->type = $type;
    }

    /**
     * Create a new database
     *
     * @param String $name
     * @return DatabaseManager
     */
    public function create(String $name) :DatabaseManager
    {
        if (!$result = $this->connection->statement('CREATE DATABASE ' . $name)) return false;

        return $this->makeConnection($name);
    }

    /**
     * Get a database connection
     *
     * @param String $name
     * @return void
     */
    public function get(String $name)
    {
        return $this->connection->statement('SHOW DATABASES');
    }

    /**
     * Make a connection to an existing database
     *
     * @param String $name
     * @return DatabaseManager
     */
    public function makeConnection(String $name) :DatabaseManager
    {
        $config = Config::get('database.connections.' . $this->type);
        $config['database'] = $name;
        config(['database.connections.' . $name => $config]);

        DB::purge($name);

        return new static($this->type, DB::connection($name));
    }
}