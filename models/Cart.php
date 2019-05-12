<?php

class Cart
{

    /**
     * Добавление товара в корзину (сессию)
     * @param int $id
     */
    public static function addProduct($id)
    {
        $id = intval($id);
        $product = Product::getProductById($id);

        // Пустой массив для товаров в корзине
        $productsInCart = array();
        $productsInCartByPrice = array();

        // Если в корзине уже есть товары (они хранятся в сессии)
        if (isset($_SESSION['products'])) {
            // То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }
        
        // Если в корзине уже есть цены товаров (они хранятся в сессии)
        if (isset($_SESSION['products_prices'])) {
            // То заполним наш массив товарами
            $productsInCartByPrice = $_SESSION['products_prices'];
        }

        // Если товар есть в корзине, но был добавлен еще раз, увеличим количество
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            // Добавляем нового товара в корзину
            $productsInCart[$id] = 1;
        }
        
        // Если товар есть в корзине, но был добавлен еще раз, добавим цену
        if (!array_key_exists($id, $productsInCartByPrice)) {    
            // Добавляем цену товара в корзину
            $productsInCartByPrice[$id] = $product['price'];
        }

        $_SESSION['products'] = $productsInCart;
        $_SESSION['products_prices'] = $productsInCartByPrice;
        
        return self::countItems();
    }
    
    /**
     * Удаляем товара из корзины (сессии)
     * @param int $id
     */
    public static function deleteProduct($id)
    {
        $productsInCart = self::getProducts();
        $productsInCartByPrice = self::getProductsCost();

        unset($productsInCart[$id]);
        unset($productsInCartByPrice[$id]);

        $_SESSION['products'] = $productsInCart;
        $_SESSION['products_prices'] = $productsInCartByPrice;
    }

    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int 
     */
    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    public static function getProductsCost()
    {
        if (isset($_SESSION['products_prices'])) {
            return $_SESSION['products_prices'];
        }
        return false;
    }
    
    public static function getTotalPriceFromStart()
    {
        $totalPrice = 0;    
        $productsIds = self::getProducts();
        if ($productsIds) {
            $productsIds = array_keys($_SESSION['products']);
            $products = Product::getProductsByIds($productsIds);
            $totalPrice = Cart::getTotalPrice($products);            
        }       
        return $totalPrice; 
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();
        $total = 0;
        
        if ($productsInCart) {            
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * Подсчет стоимости товара в зависимости от количества
     * @param int $id, $number
     */
    public static function getCountCost($id, $number)
    {
        $total = 0;
        
        $product = Product::getProductById($id);
        
        $total = $number * $product['price'];

        return $total;
    }

    /**
     * Подсчет количество определенного товара
     * @param int $id
     */
    public static function getCartAmount($id)
    {
        $totalAmount = 0;
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
            if (array_key_exists($id, $productsInCart))
                $totalAmount = $productsInCart[$id];
        }

        return $totalAmount;
    }
    
    /**
     * Добавление нескольких товаров в корзину (сессию)
     * @param int $id
     */
    public static function addNumberOfProducts($id, $number)
    {
        $id = intval($id);
        $number = intval($number);
        
        $product = Product::getProductById($id);

        // Пустой массив для товаров в корзине
        $productsInCart = array();
        $productsInCartByPrice = array();
        
        // Если в корзине уже есть товары (они хранятся в сессии)
        if (isset($_SESSION['products'])) {
            // То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }
        
        if (isset($_SESSION['products_prices'])) {
            // То заполним наш массив ценами товаров
            $productsInCartByPrice = $_SESSION['products_prices'];
        }

        // Если товар есть в корзине, но был добавлен еще раз, увеличим количество
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] += $number;
        } else {
            // Добавляем нового товара в корзину
            $productsInCart[$id] = $number;
        }
        
        if (!array_key_exists($id, $productsInCartByPrice)) {
            $productsInCartByPrice[$id] = $product['price'];
        } 

        $_SESSION['products'] = $productsInCart;
        $_SESSION['products_prices'] = $productsInCartByPrice;

        return self::countItems();
    }
    
    /**
     * Добавление нескольких товаров в корзине (сессии), находясь в корзине
     * @param int $id
     */
    public static function changeNumberOfProducts($id, $number)
    {
        $id = intval($id);
        $number = intval($number);
        
        $product = Product::getProductById($id);
        
        $productsInCartByPrice = array();
        
        if (isset($_SESSION['products_prices'])) {
            // То заполним наш массив ценами товаров
            $productsInCartByPrice = $_SESSION['products_prices'];
        }
        
        if (!array_key_exists($id, $productsInCartByPrice)) {
            $productsInCartByPrice[$id] = $product['price'];
        } 

        $productsInCart = $_SESSION['products'];

        $productsInCart[$id] = $number;
        
        if ($productsInCart[$id] == 0) {
            unset($productsInCart[$id]);
            unset($productsInCartByPrice[$id]);
        }

        $_SESSION['products'] = $productsInCart;
        $_SESSION['products_prices'] = $productsInCartByPrice;

        return self::countItems();
    }
    
    /**
     * Проверяет, можно ли добавлять столько товаров в корзину
     */
    public static function checkIfEnough($id, $number, $isChange = false)
    {
        $amount = self::getCartAmount($id);
        $product = Product::getProductById($id);
        
        if ($isChange == true)
            $amount = 0;
        
        if ($number + $amount <= $product['stock']) {
            return true;
        }
        return false;
    }
    
    /* 
     * Очищает корзину
     */
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
        
        if (isset($_SESSION['products_prices'])) {
            unset($_SESSION['products_prices']);
        }
    }

}
