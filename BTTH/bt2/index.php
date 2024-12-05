<?php
// Đọc dữ liệu từ file
$quiz_file = 'quiz.txt'; // Đường dẫn đến tệp tin câu hỏi

// Khởi tạo mảng chứa các câu hỏi
$questions = [];

// Đọc file
$file = fopen($quiz_file, 'r');
if ($file) {
    $current_question = [];
    while (($line = fgets($file)) !== false) {
        $line = trim($line);
        if (empty($line)) {
            continue; // Bỏ qua các dòng trống
        }

        if (strpos($line, 'ANSWER:') !== false) {
            // Lưu đáp án
            $current_question['answer'] = substr($line, 8);
            $questions[] = $current_question;
            $current_question = []; // Khởi tạo lại câu hỏi tiếp theo
        } else {
            if (empty($current_question)) {
                // Lưu câu hỏi
                $current_question['question'] = $line;
            } else {
                // Lưu các lựa chọn
                $current_question['options'][] = $line;
            }
        }
    }
    fclose($file);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answers = $_POST['answers'] ?? [];
    $correct_count = 0;
    $feedback = [];

    // Kiểm tra câu trả lời của người dùng
    foreach ($questions as $index => $question) {
        $correct_answer = strtoupper(trim($question['answer']));
        $user_answer = strtoupper(trim($user_answers[$index] ?? ''));

        if ($user_answer == $correct_answer) {
            $correct_count++;
            $feedback[] = "Câu " . ($index + 1) . ": Đúng";
        } else {
            $feedback[] = "Câu " . ($index + 1) . ": Sai (Đáp án đúng: $correct_answer)";
        }
    }

    // Hiển thị kết quả
    echo "<h2>Kết quả bài thi</h2>";
    foreach ($feedback as $line) {
        echo "<p>$line</p>";
    }
    echo "<p>Số câu đúng: $correct_count/" . count($questions) . "</p>";
    echo "<p>Điểm số: " . ($correct_count * 100 / count($questions)) . "/100</p>";
} else {
    // Hiển thị bài thi
    echo "<h2>Bài Thi Trắc Nghiệm</h2>";
    echo "<form method='POST'>";

    foreach ($questions as $index => $question) {
        echo "<h3>Câu " . ($index + 1) . ": " . $question['question'] . "</h3>";
        foreach ($question['options'] as $option) {
            echo "<input type='radio' name='answers[$index]' value='" . strtoupper(substr($option, 0, 1)) . "'> " . $option . "<br>";
        }
    }

    echo "<input type='submit' value='Nộp bài'>";
    echo "</form>";
}
?>
