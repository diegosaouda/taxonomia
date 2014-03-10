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
        $connectionFactory = new ConnectionFactory();
        $this->connection = $connectionFactory->getConnection();
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
     * @param string $descricao
     * @param string $tipo
     */
    public function buscaAction($descricao, $tipo)
    {
        $taxonomia = $this->taxonomiaDao->buscaPorDescricaoTipo($descricao, $tipo);
        $this->app->response->body(json_encode($taxonomia));
    }
    
    /**
     * @param string $descricao
     * @param string $tipo
     */
    public function inserirAction()
    {
        $data = $this->getRequestJson();
        
        $this->connection->beginTransaction();
        $result = $this->taxonomiaDao->insertNextTaxonomia($data);
        $this->connection->commit();
        
        $this->app->response->body(json_encode($result));
    }
    
    /**
     * Get post Json
     * @return array
     */
    private function getRequestJson()
    {
        $requestJson = file_get_contents('php://input');
        return (array) json_decode($requestJson);
    }
}
