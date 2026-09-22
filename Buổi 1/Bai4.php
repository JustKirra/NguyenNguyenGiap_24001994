<?php
    class Student {
        public $name;
        public $age;
        public $score;

        public function __construct($name, $age, $score) {
            $this->name = $name;
            $this->age = $age;
            $this->score = $score;
        }

        public function getRank() {
            if ($this->score >= 8.0) {
                return "Giỏi";
            } elseif ($this->score >= 6.5) {
                return "Khá";
            } elseif ($this->score >= 5.0) {
                return "Trung bình";
            } else {
                return "Yếu";
            }
        }

        public function isPassed() {
            return $this->score >= 5.0;
        }

        public function displayStudent() {
            $status = $this->isPassed() ? "Đạt" : "Không đạt";
            echo "Họ tên: " . $this->name . 
                " - Tuổi: " . $this->age . 
                " - Điểm: " . $this->score . 
                " - Xếp loại: " . $this->getRank() . 
                " - Trạng thái: " . $status . "<br>";
        }
    }

    function findBestStudent(array $students) {
        if (empty($students)) {
            return null;
        }

        $best = $students[0];
        foreach ($students as $student) {
            if ($student->score > $best->score) {
                $best = $student;
            }
        }
        return $best;
    }

    function countPassedStudents(array $students) {
        $count = 0;
        foreach ($students as $student) {
            if ($student->isPassed()) {
                $count++;
            }
        }
        return $count;
    }

    function calculateAverageScore(array $students){
        if (empty($students)) {
            return 0;
        }

        $totalScore = 0;
        foreach ($students as $student) {
            $totalScore += $student->score;
        }
        return $totalScore / count($students);
    }

    $student1 = new Student("Nguyen Van An", 20, 8.5);
    $student2 = new Student("Tran Thi Binh", 21, 6.5);
    $student3 = new Student("Le Van Cuong", 19, 4.5);
    $student4 = new Student("Pham Thi Dung", 20, 7.5);

    $students = [$student1, $student2, $student3, $student4];

    echo "Danh sách sinh viên <br>";

    foreach ($students as $student) {
        $student->displayStudent();
    }

    $bestStudent = findBestStudent($students);
    if ($bestStudent) {
        echo "Sinh viên đạt điểm cao nhất: " . $bestStudent->name . "<br>";
    }

    echo "Số sinh viên đạt: " . countPassedStudents($students) . " sinh viên<br>";
    echo "Điểm trung bình của lớp: " . calculateAverageScore($students) . "<br>";
?>    

