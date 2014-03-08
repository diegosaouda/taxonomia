<?php

namespace Taxonomia\Controller;

use Slim\Slim;
use SlimController\SlimController;
use Taxonomia\Common\ConnectionFactory;
use Taxonomia\Dao\Taxonomia as TaxonomiaDao;

class Taxonomia extends SlimController
{

    /**@var Doctrine\DBAL\Connection */
    private $connection;

    /**@var TaxonomiaDao */
    private $taxonomiaDao;

    /**
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        parent::__construct($app);
        $this->connection = (new ConnectionFactory())->getConnection();
        $this->taxonomiaDao = new TaxonomiaDao($this->connection);
    }

    /**
     * @param string $id
     */
    public function codeAction($id)
    {
        $taxonomia = $this->taxonomiaDao->buscaPorCodigo($id);
        $this->app->response->body(json_encode($taxonomia));
    }

    /**
     * @param string $id
     */
    public function buscaAction($descricao)
    {
        $taxonomia = $this->taxonomiaDao->buscaPorDescricao($descricao);
        $this->app->response->body(json_encode($taxonomia));
    }
}
