<?php
    class Movie{
        public $id;
        public $title;
        public $price;
        public $totalSeats;
        public $availableSeats;

        public function __constructor($id, $title, $price, $totalSeats){
            $this->id = $id;
            $this->title = $title;
            $this->price = $price;
            $this->availableSeats = $totalSeats;
        }

        public function bookTicket($quantity){
            if ($quantity <= 0 || $quantity > $this->availableSeats) {
                echo "Số lượng vé đặt không hợp lệ! <br>";
                return;
            }

            $this->availableSeats = $this->availableSeats - $quantity;
        }

        public function cancelTicket($quantity){
            if ($quantity <= 0 || $quantity > $this->getSoldSeats()) {
                echo "Số lượng vé hủy không hợp lệ! <br>";
                return;
            } 

            $this->availableSeats = $this->availableSeats + $quantity;
        }

        public function getSoldSeats(){
            return $this->totalSeats - $this->availableSeats;
        }

        public function getRevenue(){
            return $this->getSoldSeats * $this->price;
        }

        public function displayInfo(){
            echo "Mã phim: " . $this->id . 
                "Tên phim: " . $this->title . 
                "Giá vé: " . $this->price . 
                "Tổng số ghế: " . $this->totalSeats . 
                "Số ghế còn lại: " . $this->availableSeats . 
                "Số vé đã bán: " . $this->getSoldSeats() . 
                "Doanh thu: " . $this->getRevenue() . "<br>";
        }
    }

    class ListOfMovie{
        public $movies = [];

        public function findMovieByld($movies, $id){
            
        }

        public function getTotalRevenue($movies){

        }

        public function getBestSellingMovie($movies){

        }
    }
?>
