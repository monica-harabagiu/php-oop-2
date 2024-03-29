<?php
    class Product {
        public $img;
        public $animal;
        public $title;
        public $price;
        public $category;

        function __construct($img, $animal, $title, $price, $category) {
            $this->img = $img;
            $this->animal = $animal;
            $this->title = $title;
            $this->price = $price;
            $this->category = $category;
        }
    };

    trait DiscountApplicable {
        public function applyDiscount($discountPercentage)
        {
            $discountedPrice = $this->price * (1 - $discountPercentage / 100);
            return number_format($discountedPrice, 2, '.', '') . ' €';
        }
    };


    class Accessory extends Product {
        use DiscountApplicable;
        public $material;
        public $size;

        function __construct($img, $animal, $title, $price, $category, $material, $size)
        {
            parent::__construct($img, $animal, $title, $price, $category);
            $this->material = $material;
            $this->size = $size;
        }
    };

    class Food extends Product {
        use DiscountApplicable;
        public $expiryDate;
        public $calories;

        function __construct($img, $animal, $title, $price, $category, $expiryDate, $calories)
        {
            parent::__construct($img, $animal, $title, $price, $category);
            $this->expiryDate = $expiryDate;
            $this->calories = $calories;
        }
    };

    class Toy extends Product {
        use DiscountApplicable;
        public $age;
        public $batteries;

        function __construct($img, $animal, $title, $price, $category, $age, $batteries)
        {
            parent::__construct($img, $animal, $title, $price, $category);
            $this->age = $age;
            $this->batteries = $batteries;
        }

        function hasBatteries() {
            return $this->batteries ? 'Batteries included' : 'Batteries not included';
        }
    };


    $productsArray = [ 
        $harness = new Accessory(
            'https://www.jurassicbark-online.co.uk/cdn/shop/products/hurttahedge_90c1c259-cf06-481c-b3de-0c110e93ba27_570x617_crop_top.jpg?v=1680095344',
            'dog',
            'Harness',
            45.99,
            'Accessories',
            'Polyester',
            'M'
        ),
        $wet85g = new Food(
            'https://www.jurassicbark-online.co.uk/cdn/shop/products/NSEMEAACANAPremiumPateWetCatFoodChickenFront85g_232fbcce-16f6-4590-a4d7-a7af597b5743_570x617_crop_top.png?v=1653382264',
            'cat',
            'Wet Food 85g',
            1.49,
            'Food',
            '10/2026',
            102
        ),
        $ballLauncher = new Toy(
            'https://www.jurassicbark-online.co.uk/cdn/shop/products/Medium18_570x617_crop_top.png?v=1647263341',
            'dog',
            'Ball Launcher',
            12.99,
            'Toys',
            'Adult',
            false
        )
    ];
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal store</title>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <header class="d-flex flex-column align-items-center py-5">
        <figure class="d-flex justify-content-center ">
            <img class="w-50"
                src="https://www.jurassicbark-online.co.uk/cdn/shop/t/23/assets/logo.png?v=125287641229179768511698997201"
                alt="Logo">
        </figure>
        <h1>Pet Shop</h1>

        <div class="container-fluid my-5">
            <div class="row col-10 mx-auto gap-3 justify-content-center my-5">
                <?php foreach($productsArray as $product) : ?>
                <div class="card col-3 px-0 ">
                    <figure class="figure position-relative " style="height: 80%; width:100%;">
                        <img src="<?= $product->img ?>" class="img-fluid object-fit-cover" alt="<?= $product->title.' copertina' ?>"
                        style="border-radius: 0.3rem 0.3rem 0 0">
                        <span class="position-absolute bg-white rounded rounded-circle px-2 py-1" style="top: 10px; right: 10px; aspect-ratio: 1;">
                            <i class="fa-solid <?= ($product->animal === 'dog') ? 'fa-dog' : 'fa-cat' ?>"></i>
                        </span>
                    </figure>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->title ?></h5>
                        <h6 class="card-text">
                        <?= $product->price ?> € |
                            <?php 
                                try {
                                    echo 'Discounted price: ' . $product->applyDiscount(10);
                                } catch (Exception $e) {
                                    echo "Error formatting price: " . $e->getMessage();
                                }
                            ?> 
                        </h6>
                    </div>
                    <div class="card-footer text-body-secondary">
                        <?= $product->category ?>
                    </div>
                    <div class="card-body">
                        <h6 class="mt-5">Additional informations:</h6>
                        <span class="card-title"><?= $product->material ?? $product->expiryDate ?? $product->age ?></span>
                        <br>
                        <span class="card-text">
                            <?= $product->taglia ?? $product->calories ?? ($product instanceof Toy ? $product->hasBatteries() : '') ?>
                </span>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </header>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>