<?php

namespace Taxonomia\Common;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory
{

    /**
     * @return Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        $config = new Configuration();
        $conn = DriverManager::getConnection(include('config/doctrine.php'), $config);

        return $conn;
    }
}
