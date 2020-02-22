<?php

namespace App\models;

    use Aura\SqlQuery\QueryFactory;
    use PDO;

    class  QueryBuilder{

        private $queryFactory;
        private $PDO;

        public function __construct(QueryFactory $queryFactory, PDO $PDO)
        {

            $this->queryFactory = $queryFactory;
            $this->PDO = $PDO;
        }

        function all($table){
            $select = $this->queryFactory->newSelect();
            $select->cols(['*'])->from($table);
            $sth = $this->PDO->prepare($select->getStatement());
            $sth->execute($select->getBindValues());
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }

        function getOne($table, $id) {
            $select = $this->queryFactory->newSelect();
            $select->cols(['*'])
                ->from($table)
                ->where('id=:id')
                ->bindValues(['id'=>$id]);

                $sth = $this->PDO->prepare($select->getStatement());
                $sth->execute($select->getBindValues());
                return $sth->fetch(PDO::FETCH_ASSOC);
        }

        function add ($table,$data) {
            $insert = $this->queryFactory->newInsert();
            $insert -> into ( $table)
                ->cols ($data);
            $sth= $this->PDO->prepare($insert-> getStatement());
            $sth->execute( $insert->getBindValues());
            // get the last insert ID
            $name= $insert-> getLastInsertIdName('id');
            return $this->PDO-> lastInsertId( $name);
        }

        function delete ($table, $id) {
            $delete = $this->queryFactory->newDelete();
            $delete
                ->from($table) // FROM this table
                ->where('id = :id') // AND WHERE these conditions
                ->bindValue('id', $id); // bind one value to a placeholder
            $sth = $this->PDO->prepare($delete->getStatement());
            $sth->execute($delete->getBindValues());
        }

        function update ($table, $data,$id) {

            $update = $this->queryFactory->newUpdate();
            $update
                ->table($table) // update this table
                ->cols($data)
                ->where('id = :id') // AND WHERE these conditions
                ->bindValue('id',$id);
            $sth = $this->PDO->prepare($update->getStatement());
            $sth-> execute( $update-> getBindValues());

        }

        function test () {
//            foreach ($categories as $item2) {
//                if (in_array($item['id_categories'], $item2)){
//
//                }
//            }
        }
    }

?>