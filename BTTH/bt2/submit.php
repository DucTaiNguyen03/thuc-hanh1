<?php
// Đọc lại tệp câu hỏi
$filename = "Quiz.txt";
if (!file_exists($filename)) {
    die("Tệp câu hỏi không tồn tại!");
}

$questions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$parsedQuestions = [];

// Xử lý câu hỏi và đáp án
foreach ($questions as $line) {
    if (preg_match('/^(.*?)\?(.*)$/', $line, $matches)) {
        $currentQuestion = ['question' => trim($matches[1]), 'choices' => [], 'answer' => ''];
        $parsedQuestions[] = $currentQuestion;
    } elseif (preg_match('/^([A-D])\.(.*)$/', $line, $matches)) {
        $parsedQuestions[count($parsedQuestions) - 1]['choices'][$matches[1]] = trim($matches[2]);
    } elseif (preg_match('/^ANSWER:\s*([A-D])$/', $line, $matches)) {
        $parsedQuestions[count($parsedQuestions) - 1]['answer'] = $matches[1];
    }
}

// Kiểm tra kết quả
$score = 0;
$total = count($parsedQuestions);

foreach ($parsedQuestions as $index => $question) {
    $userAnswer = $_POST["question_$index"] ?? ''; // Lấy câu trả lời của người dùng
    if ($userAnswer === $question['answer']) {
        $score++; // Tăng điểm nếu đúng
    }
}

// Hiển thị kết quả
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả bài thi</title>
</head>
<body>
    <h1>Kết quả bài thi</h1>
    <p>Bạn đã trả lời đúng <strong><?= $score ?>/<?= $total ?></strong> câu.</p>
    <p>Điểm số của bạn: <strong><?= round(($score / $total) * 10, 2) ?></strong> / 10</p>
    <a href="index.php">Làm lại bài thi</a>
</body>
</html>
