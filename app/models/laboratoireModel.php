<?php


class LaboratoireModel
{
    public function create($name,$description,$contact,$logo){

        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("INSERT INTO laboratoire (nameLabo,description,contact,logo)
                                        VALUES (:nameLabo,:description,:contact,:logo)");
        $query->execute(["nameLabo"=>$name,
                        "description"=>$description,
                        "contact"=>$contact,
                         "logo"=>$logo   ]);
        return $pdo->lastInsertId();
        }

        public function findAllLabo()
        {
            $pdo = (new Database())->getPdo();
            $query = $pdo->prepare("SELECT nameLabo
                                            FROM laboratoire");
            $query->execute();
            return $query->fetchAll();
        }



}