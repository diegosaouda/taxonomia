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
     * @param  string $code Código de taxonomia
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
     * @param  string $descricao Texto usado para busca
     * @param  string $tipo Tipo de taxonomia
     * @return array|bool Valor encontrado|false para não encontrado
     */
    public function buscaPorDescricaoTipo($descricao, $tipo)
    {
        $likeDescricao = '%'.strtolower($descricao).'%';
        $likeTipo = $tipo.'%';
        
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('tb_taxonomia', '')
            ->where('lower(nm_descricao) like :descricao')
            ->orWhere('lower(nm_taxonomia) like :descricao')
            ->setParameter('descricao', $likeDescricao)
            ->setParameter('descricao', $likeDescricao);
        
        if ($tipo !== 'todas') {
            $qb->andWhere('lower(nm_taxonomia) like :tipo')
                ->setParameter('tipo', strtolower($likeTipo))
                ->orderBy('nm_taxonomia','asc');
        }
        
        return $qb->execute()
            ->fetchAll();
    }
    
    /**
     * Inserir a próxima taxonomia code
     * @param array $data Dados a ser inserido
     * @return array Dados da inserção
     */
    public function insertNextTaxonomia(array $data)
    {
        $data['nm_taxonomia'] = $this->getNextTaxonomia($data['nm_taxonomia']);
        $data['nm_idioma'] = 'pt_BR';
        $data['nm_modulo'] = 'Core';
        $data['nm_login'] = 'root';
        $data['nm_ip'] = 'localhost';
        
        //removendo o ponto do inicio do texto
        //esse ponto é usado para dizer que é aquela palavra que quero, 
        //idependente do resultado da busca / da taxonomia existir
        if ($data['nm_descricao'][0] === '.') {
            $data['nm_descricao'] = substr($data['nm_descricao'], 1);
        }
        
        $this->connection->insert('tb_taxonomia', $data);
        return $data;
    }
    
    /**
     * Retorna o próximo código de taxonomia
     * @param string $tipo Tipo da taxonomia
     * @return string Code Taxonomia
     */
    public function getNextTaxonomia($tipo)
    {
        $codeTaxonomia = $this->connection->createQueryBuilder()
            ->select('MAX(substring(nm_taxonomia,2)::integer) as max_taxonomia')
            ->from('tb_taxonomia', '')
            ->where('substring(nm_taxonomia, 1, 1) = :tipo')
            ->setParameter('tipo', $tipo)
            ->execute()->fetch();
        
        return $tipo . sprintf("%04d", ($codeTaxonomia['max_taxonomia']+1) );
    }
}
