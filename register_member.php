<?php
// Connect to database
$dsn = 'mysql:dbname=mazyan_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'araiofficeDaisaku208';
try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $sql = 'INSERT INTO userstable(name) VALUES(:name)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    try {
        $stmt->execute();
        echo '新しいメンバーが登録されました。';
    } catch (PDOException $e) {
        exit('エラーが発生しました。' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
 <html lang="ja">
 
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>麻雀得点管理APP武君</title>
     <link rel="stylesheet" href="css/style.css">
 
     <!-- Google Fontsの読み込み -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
 </head>
 
 <body>
     <header>
         <nav>
             <a href="index.php">麻雀得点管理アプリ武君</a>
         </nav>
     </header>
<body>
    <form action="" method="post">
        <label for="name">名前：</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">登録する</button>
    </form>
    <a href="read.php" class="btn">もどれ</a>
    </main>
     <footer>
         <p class="copyright">&copy; 麻雀得点管理アプリ武君 All rights reserved.</p>
     </footer>
 </body>
 
 </html>