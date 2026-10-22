<?php
    class CartItem{
        private $name;
        private $price;
        private $quantity;

        public function __construct($name, $price, $quantity){
            $this->name = $name;
            $this->price = $price;
            $this->quantity = $quantity;
        }

        public function getName(){
            return $this->name;
        }

        public function getPrice(){
            return $this->price;
        }

        public function getQuantity(){
            return $this->quantity;
        }

        public function getTotal(){
            return $this->price * $this->quantity;
        }
    }

    class ShoppingCart{
        private $items = [];

        public function addItem($item){
            if ($item->getPrice() <= 0 || $item->getQuantity() <= 0) {
                echo "Sản phẩm không hợp lệ! <br>";
                return;
            }
            $this->items[] = $item;
        }

        public function calculateTotal(){
            if (empty($this->items)) {
                return 0;
            }

            $total = 0;
            foreach ($this->items as $item){
                $total += $item->getTotal();
            }
            return $total;
        }

        public function findMaxPrice() {
            if (empty($this->items)) {
                echo "Giỏ hàng trống! <br>";
                return "";
            }

            $maxPrice = 0;
            foreach ($this->items as $item){
                if ($maxPrice < $item->getPrice()) {
                    $maxPrice = $item->getPrice();
                }
            }
            return $maxPrice;
        }

        public function displayCart(){
            if (empty($this->items)) {
                echo "Giỏ hàng trống! <br>";
                return;
            }

            foreach ($this->items as $item) {
                echo "Tên sản phẩm: " . $item->getName() . 
                    " | Số lượng: " . $item->getQuantity() .
                    " | Thành tiền: " . number_format($item->getTotal(), 0, ',', '.') . "<br>";                
            }
            echo "Tổng giá trị đơn hàng: " . number_format($this->calculateTotal(), 0, ',', '.') . "<br>";
        }
    }
    $cart = new ShoppingCart();

    $item1 = new CartItem("Áo" , 50000 , 5);
    $item2 = new CartItem("Quần" , 150000 , 2);
    $item3 = new CartItem("Điện thoại" , 50000000 , 3);
    $item4 = new CartItem("Laptop" , 25000000 , 1);
    $item5 = new CartItem("Bút" , 4000 , 10);

    $cart->addItem($item1);
    $cart->addItem($item2);
    $cart->addItem($item3);
    $cart->addItem($item4);
    $cart->addItem($item5);

    echo "Tổng giá trị sản phẩm: " . number_format($cart->calculateTotal()) . " VNĐ <br>";
    echo "Giá sản phẩm cao nhất: " . number_format($cart->findMaxPrice()) . " VNĐ <br>";
?>