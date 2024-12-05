<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'flowers.php';
    $new_flower = [
        "name" => $_POST['name'],
        "description" => $_POST['description'],
        "image" => "images/" . $_FILES['image']['name']
    ];
    move_uploaded_file($_FILES['image']['tmp_name'], $new_flower['image']);
    $flowers[] = $new_flower;
    file_put_contents('flowers.php', '<?php $flowers = ' . var_export($flowers, true) . ';');
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hoa Mới</title>
</head>
<body>
    <h1>Thêm Hoa Mới</h1>
    <form action="add_flower.php" method="post" enctype="multipart/form-data">
        <label for="name">Tên Hoa:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="description">Mô Tả:</label>
        <textarea name="description" id="description" required></textarea><br>
        <label for="image">Hình Ảnh:</label>
        <input type="file" name="image" id="image" required><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
