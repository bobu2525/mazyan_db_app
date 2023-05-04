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

try {
    // $pdo = new PDO($dsn, $user, $password); // ここをコメントアウトする
    $sql_select_users = 'SELECT * FROM `userstable`';
    $stmt_select_users = $pdo->query($sql_select_users);
    $users = $stmt_select_users->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit($e->getMessage());
}

$sql_game_results = 'SELECT u.name, COUNT(g.id) AS hanchan_count, SUM(g.score) AS total_score, 
    COUNT(CASE WHEN g.rank = 1 THEN 1 END) AS first_place_count, 
    COUNT(CASE WHEN g.bako = 1 THEN 1 END) AS bako_count, 
    COUNT(CASE WHEN g.yakitori = 1 THEN 1 END) AS yakitori_count, 
    COUNT(CASE WHEN g.yakuman = 1 THEN 1 END) AS yakuman_count
    FROM userstable u 
    LEFT JOIN gameresulttable g ON u.id = g.user_id
    GROUP BY u.id';
$stmt_game_results = $pdo->query($sql_game_results);
$records = $stmt_game_results->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麻雀得点管理アプリ武君</title>
    <link rel="stylesheet" href="css\style.css">
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
    <main>
    <section>
    <h1>メニュー</h1>
        <table class="menu">
            <tbody>
                <tr>
                  <td>
                        <h1>通算成績</h1>
                        <br>
                        <br>
                    </td>
                    <td>
                        <a href="game_result.php" class="btn">ゲーム内容設定</a>
                        <br>
                        <hr>
                        <a href="kensaku.php" class="btn">成績</a>
                        <br>
                        <hr>
                        <!-- 新規メンバー登録リンクを追加 -->
                        <a href="register_member.php" class="btn">新規メンバー登録</a>
                        <br>
                        <hr>
                        <a href="index.php" class="btn">もどれ</a>
                        <br>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </section>
    <h1>通算成績</h1>
<table class="products-table">
    <tr>
        <th>メンバー</th>
        <th>総半チャン回数</th>
        <th>トータル金額</th>
        <th>１位回数</th>
        <th>箱回数</th>
        <th>焼き鳥回数</th>
        <th>役満回数</th>
    </tr>
    <?php foreach ($records as $record) { ?>
        <tr>
            <td><?php echo $record['name']; ?></td>
            <td><?php echo $record['hanchan_count']; ?></td>
            <td><?php echo $record['total_score']; ?></td>
            <td><?php echo $record['first_place_count']; ?></td>
            <td><?php echo $record['bako_count']; ?></td>
            <td><?php echo $record['yakitori_count']; ?></td>
            <td><?php echo $record['yakuman_count']; ?></td>
        </tr>
    <?php } ?>
</table>
        </div>
    </article>
    <a href="index.php" class="btn">もどれ</a>
</main>
<footer>
    <p>&copy; 麻雀得点管理APP武君 All rights reserved.</p>
</footer>
</body>
</html>