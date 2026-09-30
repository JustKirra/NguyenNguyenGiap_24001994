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

        public function removeItem($name){
            $found = false;
            foreach ($this->items as $key => $item) {
                if ($item->getName() == $name) {
                    unset($this->items[$key]);
                    $this->items = array_values($this->items);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo "Sản phẩm không có trong giỏ hàng! <br>";
            }
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

    $item1 = new CartItem("Áo thun", 100000, 2);
    $item2 = new CartItem("Quạt", 50000, 3);
    $item3 = new CartItem("Khăn", 15000, 6);
    $item4 = new CartItem("Iphone 18 pro max", 37000000, 1);
    $item5 = new CartItem("Iphone 18 pro max", 37000000, 0);
    $item6 = new CartItem("Iphone 15 plus" , 0 , 1);

    $cart->addItem($item1);
    $cart->addItem($item2);
    $cart->addItem($item3);
    $cart->addItem($item4);
    $cart->addItem($item5);
    $cart->addItem($item6);
    
    echo "Giỏ hàng hiện tại: <br>";
    $cart->displayCart();

    $cart->removeItem("Khăn");
    $cart->removeItem("Pin");

    echo "<br> Giỏ hàng sau khi cập nhật: <br>";
    $cart->displayCart();
?>
