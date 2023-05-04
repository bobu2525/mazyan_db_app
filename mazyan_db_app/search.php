<?php
$dsn = 'mysql:dbname=mazyan_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'araiofficeDaisaku208';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーが発生した場合にエラーメッセージを表示する

    if (isset($_POST['search'])) {
        // 検索ボタンがクリックされたときの処理
        $search_type = $_POST['search_type'];
        $search_query = $_POST['search_query'];

        // プレースホルダーを使用して SQL 文を実行
        $sql = "SELECT name, day FROM `game_results` WHERE $search_type LIKE :keyword";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $search_query . '%', PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麻雀得点管理アプリ武君</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <h1>麻雀得点管理アプリ武君</h1>

    <form action="" method="post">
        <label for="search_type">検索タイプ</label>
        <select name="search_type" id="search_type">
            <option value="name	">name	</option>
            <option value="day">日付</option>
            <option value="tokuten">トータル得点</option>
            <option value="rank">順位</option>
            <option value="yakuman">役満</option>
            <option value="hako">箱</option>
            <option value="CIP">CIP</option>
            <option value="money">お金</option>
            <option value="seisan">精算</option>
        </select>
        <br>
        <label for="search_query">検索キーワード</label>
        <input type="text" name="search_query" id="search_query">
        <br>
        <input type="submit" name="search" value="検索">
    </form>
    <?php if (!empty($result)): ?>
        <ul>
        <?php foreach ($result as $row): ?>
            <li>ID: <?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>, 日付: <?php echo htmlspecialchars($row['day'], ENT_QUOTES); ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="read.php" class="btn">もどれ</a>
</body>

</html>