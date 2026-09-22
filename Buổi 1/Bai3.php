<?php
    $students = [
        [
            "name" => "Nguyen Van An",
            "age" => 20,
            "score" => 8.5
        ],
        [
            "name" => "Tran Thi Binh",
            "age" => 21,
            "score" => 6.5
        ],
        [
            "name" => "Le Van Cuong",
            "age" => 19,
            "score" => 4.5
        ],
        [
            "name" => "Pham Thi Dung",
            "age" => 20,
            "score" => 7.5
        ]
    ];

    function findBestStudent($students) {
        if (empty($students)) {
            return null;
        }

        $best = $students[0];
        foreach ($students as $student) {
            if ($student["score"] > $best["score"]) {
                $best = $student;
            }
        }
    }

    function findWorstStudent($students) {
        if (empty($students)) {
            return null;
        }

        $worst = $students[0];
        foreach ($students as $student) {
            if ($student["score"] < $worst["score"]) {
                $worst = $student;
            }
        }

        return $worst;
    }

    function  countPassedStudent($students) {
        $count = 0;
        foreach ($students as $student) {
            if ($student["score"] >= 5) {
                $count++;
            }
        }
        return $count;
    }

    function findStudentByName($students, $name) {
        foreach ($students as $student) {
            if (stripos($student["name"], $name) !== false) {
                return $student;
            }
        }

        return null;
    }

    echo "Danh sách sinh viên sau khi lọc: <br>";

    $bestStudent = findBestStudent($students);
    if ($bestStudent) {
        echo "Sinh viên điểm cao nhất: " . $bestStudent["name"] . "<br>";
    }

    $worstStudent = findWorstStudent($students);
    if ($worstStudent) {
        echo "Sinh viên điểm thấp nhất: " . $worstStudent["name"] . "<br>";
    }

    $passed = countPassedStudent($students);
    echo "Số sinh viên qua môn: " . $passed . " sinh viên <br>";

    $searchName = "Cuong";
    $foundStudent = findStudentByName($students, $searchName);
    echo "Kết quả tìm kiểm theo từ khóa " . $searchName . ": <br>";
    if ($foundStudent) {
        echo "Tên: " . $foundStudent["name"] . " - Tuổi: " . $foundStudent["age"] . " - Điểm: " . $foundStudent["score"] . "<br>";
    } else {
        echo "Không tìm thấy sinh viên với từ khóa này. <br>"; 
    }
?>
