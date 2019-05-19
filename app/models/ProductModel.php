<?php


class ProductModel
{

    public function showAll()
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT * FROM product");
        $query->execute();
        return $query->fetchAll();
    }

    public function showOne($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT * FROM product
                                        WHERE id=:id");
        $query->execute(['id' => $id]);
        return $query->fetch();
    }


    public function create($productName, $description, $category, $buyPrice, $sellingPrice, $laboratoire, $image)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("INSERT INTO product (`productName`, `productDescription`, `category`, `buyPrice`, `sellingPrice`, `laboratoire`,image)
                                        VALUES (:productName,:description,:category,:buyPrice,:sellingPrice,:laboratoire,:image) ");
        $query->execute(["productName" => $productName,
            "description" => $description,
            "category" => $category,
            "buyPrice" => $buyPrice,
            "sellingPrice" => $sellingPrice,
            "laboratoire" => $laboratoire,
            "image" => $image]);

        return $pdo->lastInsertId();
    }


    public function updateImg($id, $filename)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("UPDATE product
                                            SET image = :filename
                                            WHERE id = :id ");
        $query->execute([
            "filename" => $filename,
            "id" => $id,
        ]);
    }

    public function update($id, $productName, $productDescription, $category, $buyPrice, $sellingPrice, $laboratoire, $image)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("UPDATE product
                                        SET productName=:productName,
                                        productDescription=:productDescription,
                                        category=:category,
                                        buyPrice=:buyPrice,
                                        sellingPrice=:sellingPrice,
                                        laboratoire=:laboratoire,
                                        image=:image
                                        WHERE id=:id
                                        ");
        $query->execute(['id' => $id,
            'productName' => $productName,
            'productDescription' => $productDescription,
            'category' => $category,
            'buyPrice' => $buyPrice,
            'sellingPrice' => $sellingPrice,
            'laboratoire' => $laboratoire,
            'image' => $image]);

        $pdo->lastInsertId();
    }
}

