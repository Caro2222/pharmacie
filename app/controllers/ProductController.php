<?php


class ProductController
{
    private  $allowedExtensions =[".jpg",".jpeg",".png"];
    public function showAllAction()
    {
        $model = NEW ProductModel();


        return [
            'template' => ['folder' => "Product",
                "file" => 'showAll',
            ],
            "title" => " fiche produit",
           "allProducts"=>$allproducts=$model->showAll(),
        ];
    }

    public function showOneAction()
    {
        $redirectURl=null;

        $model= NEW ProductModel();


        return [
            'template' => ['folder' => "Product",
                "file" => 'showOne',
            ],
            "title" => " fiche produit",
            "product"=> $model->showOne($_GET['id']),
            "redirect" => $redirectURl,
        ];
    }

    public function createAction()
        {

            $redirectURl=null;
            $error = false ;
            $modelLabo =NEW LaboratoireModel();
            $allLabo= $modelLabo->findAllLabo();


            if($_POST) {

                $flashBag = NEW Flashbag();
                if (!isset($_POST['productName']) || trim($_POST['productName']) == "") {

                    $flashBag->addMessage("Veuillez entrer le nom du laboratoire");
                    $error = "true";
                }
                if (!isset($_POST['description']) || trim($_POST['description']) == "") {

                    $flashBag->addMessage("Veuillez entrer la description du laboratoire");
                    $error = "true";
                }
                if (!isset($_POST['category']) || trim($_POST['category']) == "") {

                    $flashBag->addMessage("Veuillez entrer la category du laboratoire");
                    $error = "true";
                }
                if (!isset($_POST['buyPrice']) || trim($_POST['buyPrice']) == "") {

                    $flashBag->addMessage("Veuillez entrer le prix d'achat");
                    $error = "true";
                }
                if (!isset($_POST['sellingPrice']) || trim($_POST['sellingPrice']) == "") {

                    $flashBag->addMessage("Veuillez entrer le prix de vente du produit");
                    $error = "true";
                }
                if (!isset($_POST['laboratoire']) || trim($_POST['laboratoire']) == "") {

                    $flashBag->addMessage("Veuillez entrer le laboratoire");
                    $error = "true";
                }



                if ($error) {

                    return ["redirect" => "pharmacie_product_create"];
                } else {

                    $model = NEW ProductModel();
                   $idProduct= $model->create($_POST['productName'],$_POST['description'], $_POST['category'],$_POST['buyPrice'],
                        $_POST['sellingPrice'],$_POST['laboratoire'],$_POST['image']= NULL);

                    if(isset($_FILES["image"]) && $_FILES["image"]["error"]>=0)
                    {

                        $extension= (substr($_FILES['image']['name'],
                            strpos($_FILES["image"]["name"],'.',strlen($_FILES['image']['name'])-5)));
                        if(in_array($extension,$this->allowedExtensions))
                        {


                            $filename = "product_" . $idProduct . $extension;

                            $router = new Router();
                            $filePath = $router->getWwwPath(true)."/upload/";
                            move_uploaded_file($_FILES['image']['tmp_name'],$filePath . $filename);
                            $model->updateImg($idProduct,$filename);
                        }
                    }
                    $flashBag = new Flashbag();
                    $flashBag->addMessage("Fiche produit crée avec succés");
                    $redirectURl = "pharmacie_laboratoire_showAll";


                }

                }
            return [
                'template' => ['folder' => "Product",
                    "file" => 'create',
                ],
                "title" => "Création de fiche produit",
                'allLabo' => $allLabo,
                "redirect" => $redirectURl,
            ];
        }




        public function updateAction()
        {
            $redirect= null;
            $product=null;
           $allLabo=null;
            $model=NEW ProductModel();

            if(isset($_GET['id']) && ctype_digit($_GET['id']))
            {
                $product=$model->showOne($_GET['id']);

                $modelLabo= NEW LaboratoireModel();
                $allLabo=$modelLabo->findAllLabo();

                if(!$product)
                {
                    $redirect="pharmacie_product_showAll";
                }
            }
            elseif(isset($_POST['productName']))
            {
                $router = new Router();
                $model = new ProductModel();

                $model->update($_POST["id"], $_POST['productName'], $_POST['productDescription'], $_POST['category'],
                    $_POST['buyPrice'],  $_POST['sellingPrice'],$_POST['laboratoire'] ,$_POST['photo']=NULL);
                if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0 && $_FILES["image"]['error']>= 0)
                {
                    $product = $model->showOne($_POST['id']) ;
                    $filePath = $router->getWwwPath(true) . "/upload/";
                    if($product['image'])
                    {
                        $fileName = $product['image'];
                        $fullFilePath = $filePath . $fileName;
                        if (file_exists($fullFilePath)) {
                            unlink($fullFilePath);
                        }
                    }

                    $extension= (substr($_FILES['image']['name'],
                        strpos($_FILES["image"]["name"],'.',strlen($_FILES['image']['name'])-5)));

                    if (in_array($extension,$this->allowedExtensions))
                    {
                        $filename = "product_".$_POST['id'].$extension;

                        move_uploaded_file($_FILES["image"]["tmp_name"],$filePath.$filename);
                        $model->updateImg($_POST['id'],$filename);

                    }


                }
                elseif(isset($_POST["img-suppr"]) && $_POST["img-suppr"])
                {
                    //effacer l'image existance et mettre img dans la BDD à NULL
                    $plat = $model->showOne($_POST['id']) ;
                    $filePath = $router->getWwwPath(true)."/upload/" ;
                    $fileName = $plat['image'] ;
                    $fullFilePath = $filePath.$fileName ;
                    if(file_exists($fullFilePath))
                    {
                        unlink($fullFilePath) ;
                    }
                    $model->updateImg($_POST['id'],NULL);
                }
                $redirect="pharmacie_product_showAll";
            }
            else
            {
                $redirect ="pharmacie_product_showOne";
            }



            return [
                'template' => ['folder' => "Product",
                    "file" => 'update',
                ],
                "title" => "Modifier la fiche produit",

                "redirect" =>$redirect,
                "product"=>$product,
              "allLabo"=>$allLabo,
            ];
        }

}