<?php
    class Movie{
        public $id;
        public $title;
        public $price;
        public $totalSeats;
        public $availableSeats;

        public function __construct($id, $title, $price, $totalSeats){
            $this->id = $id;
            $this->title = $title;
            $this->price = $price;
            $this->availableSeats = $totalSeats;
            $this->totalSeats = $totalSeats;
        }

        public function bookTicket($quantity){
            if ($quantity <= 0 || $quantity > $this->availableSeats) {
                return false;
            }

            $this->availableSeats -= $quantity;
            return true;
        }

        public function cancelTicket($quantity){
            if ($quantity <= 0 || $quantity > $this->getSoldSeats()) {
                return false;
            } 

            $this->availableSeats += $quantity;
            return true;
        }

        public function getSoldSeats(){
            return $this->totalSeats - $this->availableSeats;
        }

        public function getRevenue(){
            return $this->getSoldSeats() * $this->price;
        }

        public function displayInfo(){
            echo "Mã phim: " . $this->id . " | " .
                "Tên phim: " . $this->title . " | " .
                "Giá vé: " . number_format($this->price) . " | " .
                "Tổng số ghế: " . $this->totalSeats . " | " .
                "Số ghế còn lại: " . $this->availableSeats . " | " .
                "Số vé đã bán: " . $this->getSoldSeats() . " | " .
                "Doanh thu: " . number_format($this->getRevenue()) . "VNĐ<br>";
        }
    

        public static function findMovieById($movies, $id){
            foreach ($movies as $movie) {
                if ($movie->id == $id) {
                    return $movie;
                }
            }
            return null;

        }

        public static function getTotalRevenue($movies){
            $totalRevenue = 0;
            foreach ($movies as $movie) {
                $totalRevenue += $movie->getRevenue();
            }
            return $totalRevenue;
        }

        public static function getBestSellingMovie($movies){
            if (empty($movies)) {
                return null;
            }

            $bestSellingMovie = $movies[0];

            foreach ($movies as $movie) {
                if ($movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()) {
                    $bestSellingMovie = $movie;
                }
            }

            return $bestSellingMovie;
        }
    }

    $movie1 = new Movie(1, "Avenger", 100000, 100);
    $movie2 = new Movie(2, "Avatar", 120000, 80);
    $movie3 = new Movie(3, "Batman", 90000, 120);
    $movies = [$movie1, $movie2, $movie3];

    //Đặt vé phim Avenger
    echo "Đặt vé xem phim Avenger: ";
    if ($movie1->bookTicket(0)) {
        echo "Đặt vé thành công! <br>";
    } else {
        echo "Đặt vé không thành công! Vui lòng kiểm tra lại số lượng vé đặt! <br>";
    }
    
    

    //Đặt vé phim Avatar
    echo "Đặt vé xem phim Avatar: ";
    if ($movie2->bookTicket(37)){
        echo "Đặt vé thành công! <br>";
    } else {
        echo "Đặt vé không thành công! Vui lòng kiểm tra lại số lượng vé đặt! <br>";
    }

    //Hủy 1 số vé phim Avenger
    echo "Hủy vé xem phim Avenger: ";
    if ($movie1->cancelTicket(5)){
        echo "Hủy vé thành công! <br>";
    } else {
        echo "Hủy vé không thành công! Vui lòng kiểm tra lại số lượng vé đã đặt! <br>";
    }

    //Danh sách các bộ phim
    echo "Danh sách các bộ phim: <br>";
    foreach ($movies as $movie) {
        $movie->displayInfo();
        echo "<br>";
    }

    //Tổng doanh thu của các bộ phim
    echo "Tổng doanh thu của các bộ phim: " . number_format(Movie::getTotalRevenue($movies)) . "VNĐ <br>";

    $bestSellingMovie = Movie::getBestSellingMovie($movies);
    if ($bestSellingMovie) {
        echo "Bộ phim bán chạy nhất: " . $bestSellingMovie->title . ", với số vé đã bán ra: " . $bestSellingMovie->getSoldSeats() . "<br>";

    } else {
        echo "Chưa có vé nào được bán ra!";
    }
?>
