<?php include 'flowers.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Các Loài Hoa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .action-buttons a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Quản Lý Các Loài Hoa</h1>
    <a href="add_flower.php">Thêm Hoa Mới</a>
    <table>
        <thead>
            <tr>
                <th>Hình Ảnh</th>
                <th>Tên Hoa</th>
                <th>Mô Tả</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($flowers as $index => $flower): ?>
            <tr>
                <td><img src="<?= $flower['image'] ?>" alt="<?= $flower['name'] ?>" width="100"></td>
                <td><?= $flower['name'] ?></td>
                <td><?= $flower['description'] ?></td>
                <td class="action-buttons">
                    <a href="edit_flower.php?id=<?= $index ?>">Sửa</a>
                    <a href="delete_flower.php?id=<?= $index ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
