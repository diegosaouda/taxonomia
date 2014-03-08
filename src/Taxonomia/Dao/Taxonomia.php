<?php

namespace Taxonomia\Dao;

use Doctrine\DBAL\Connection;

class Taxonomia
{
    
    /** @var Connection */
    private $connection;
    
    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * Busca por código
     * @param string $code Código de taxonomia
     * @return array|bool Valor encontrado|false para não encontrado
     */
    public function buscaPorCodigo($code)
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('tb_taxonomia', '')
            ->where('nm_taxonomia = :code')
            ->setParameter('code', $code)
            ->execute()
            ->fetch();
    }
    
    /**
     * Busca por descrição
     * @param string $descricao Texto usado para busca
     * @return array|bool Valor encontrado|false para não encontrado
     */
    public function buscaPorDescricao($descricao)
    {
        $like = '%'.strtolower($descricao).'%';
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('tb_taxonomia', '')
            ->where('lower(nm_descricao) like :descricao')
            ->orWhere('lower(nm_taxonomia) like :descricao')
            ->setParameter('descricao', $like)
            ->setParameter('descricao', $like)
            ->execute()
            ->fetchAll();
    }
    
    
    
}