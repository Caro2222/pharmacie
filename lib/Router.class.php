<?php


class Router
{
    private  $rootURl="/pharmacie/index.php";
    private  $wwwPath="/pharmacie/www";
    private $allUrls=[];
    private $localHostPath = ABSOLUTE_ROOT_PATH;


    private $allRoutes=
        [
            "/"
            =>[
                "controller"=>"Home",
                "method"=>"main",
                "name"=>'pharmacie_home'
            ],
            "/product/create"
            =>[
                "controller"=>"Product",
                "method"=>"create",
                "name"=>"pharmacie_product_create"
            ],
              "/laboratoire/create"
            =>[
                "controller"=>"Laboratoire",
                "method"=>"create",
                "name"=>"pharmacie_laboratoire_create"
            ],
            "/laboratoire/showAll"
            =>[
                "controller"=>"Laboratoire",
                "method"=>"showAll",
                "name"=>"pharmacie_laboratoire_showAll"
            ],
            "/product/showAll"
            =>[
                "controller"=>"Product",
                "method"=>"showAll",
                "name"=>"pharmacie_product_showAll"
            ],
            "/product/showOne"
            =>[
                "controller"=>"Product",
                "method"=>"showOne",
                "name"=>"pharmacie_product_showOne"
            ],

            "/product/update"
            =>[
                "controller"=>"Product",
                "method"=>"update",
                "name"=>"pharmacie_product_update"
            ],











        ];

    public function __construct()
    {
        $nbrSlashes =substr_count($this->rootURl,"/");
        $this->localHostPath=dirname($this->localHostPath,$nbrSlashes-1);
        foreach ($this->allRoutes as $url=>$route)
        {
            $this->allUrls[$route["name"]]=
                ["url"=>$url,
                    "route"=>["controller"=>$route['controller'],
                        "method"=>$route["method"]
                    ]
                ];
        }
    }

    public function getRoute($requestedPath)
    {
        if(isset($this->allRoutes[$requestedPath]))
        {
            return $this->allRoutes[$requestedPath];
        }
        // a renplacé par des execptions
        die("Erreurs url inconnu");
    }

    public function getWwwPath($absolute=false)
    {
        if($absolute)
        {
            return realpath($this->localHostPath.$this->wwwPath);
        }
        else {
            return $this->wwwPath;
        }

    }

    public function generatePath($routeName)
    {

        return $this->rootURl.$this->allUrls[$routeName]["url"];
    }
}