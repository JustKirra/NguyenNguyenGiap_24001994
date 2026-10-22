<?php
    $name = "Nguyễn Nguyên Giáp";
    $score = 10;
    if ($score < 0 | $score > 10) {
        echo "Điểm không hợp lệ!";
        return;
    }

    function xepHang($score) {
        if ($score >= 8) {
            $hocLuc = "Giỏi";
            return $hocLuc;
        } elseif (6.5 <= $score) {
            $hocLuc = "Khá";
            return $hocLuc;
        } elseif (5 <= $score) {
            $hocLuc = "Trung bình";
            return $hocLuc;
        } else {
            $hocLuc = "Yếu";
            return $hocLuc;
        }
    }

    echo "Họ và tên: " .  $name . " | Điểm: " . $score . " | Xếp hạng: " . xepHang($score);
?>