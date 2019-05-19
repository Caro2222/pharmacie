<?php
class HomeController
{
    public function mainAction()
    {

        return [
            'template' => ['folder' => "Home",
                "file" => 'home',
            ],
            "title" => "Pharmacie de la gare",
        ];

    }
}