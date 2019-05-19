<?php


class LaboratoireController
{
    public function createAction()
    {
        $redirectURl=null;
        $error = false ;

        if($_POST)
        {

            $flashBag = NEW Flashbag();
            if(!isset($_POST['name']) || trim($_POST['name'])=="")
            {

                $flashBag->addMessage("Veuillez entrer le nom du laboratoire");
                $error="true";
            }
            if(!isset($_POST['description']) || trim($_POST['description'])=="")
            {

                $flashBag->addMessage("Veuillez entrer le nom la description");
                $error="true";
            }
            if(!isset($_POST['contact']) || trim($_POST['contact'])=="")
            {

                $flashBag->addMessage("Veuillez entrer le contact du laboratoire");
                $error="true";
            }

            if ($error) {

                return ["redirect" => "pharmacie_laboratoire_create"];
            } else {

                $model= NEW LaboratoireModel();
                $model->create($_POST['name'],$_POST['description'],$_POST['contact'],$_POST['logo']);

                $flashBag = new Flashbag();
                $flashBag->addMessage("Fiche laboratoire crée avec succés");
                $redirectURl = "pharmacie_home";

           }

        }

        return [
            "template"=> [
                            "folder"=>"laboratoire",
                            "file"=>"create",
            ],
            "title"=>"Création fiche laboratoire",

        ];
    }
}