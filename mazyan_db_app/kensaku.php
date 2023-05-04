<?php
try {
  // DB接続情報
  $dsn = 'mysql:dbname=mazyan_db_app;host=localhost;charset=utf8mb4';
  $user = 'root';
  $password = 'araiofficeDaisaku208';
  // DB接続
  $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo 'データベース接続に失敗しました。: ' . $e->getMessage();
  exit;
}

$result = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $search_type = $_POST['search_type'];
  $search_query = $_POST['search_query'];

  if ($search_type === 'username') {
    $sql = "SELECT game_results.*, userstable.name FROM `game_results` JOIN `userstable` ON game_results.id = userstable.id WHERE userstable.name LIKE :keyword";
  } else {
    $sql = "SELECT game_results.*, userstable.name FROM `game_results` JOIN `userstable` ON game_results.id = userstable.id WHERE game_results.$search_type LIKE :keyword";
  }

  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':keyword', '%' . $search_query . '%');
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麻雀得点管理アプリ武君</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
        <nav>
    <a href="index.php">麻雀得点管理アプリ武君</a>
    <a href="game_result.php">ゲーム内容設定</a>
    <a href="kensaku.php">成績</a>
    <a href="register_member.php">新規メンバー登録</a>
  </nav>
        </nav>
    </header>
<body>
  <h1>麻雀得点管理アプリ武君</h1>

  <form action="" method="post">
    <label for="search_type">検索タイプ</label>
    <select name="search_type" id="search_type">
    <option value="username">ユーザー名</option>
  <option value="day">日付</option>
  <option value="hanchankaisuu">半荘回数</option>
  <option value="tokuten">トータル得点</option>
  <option value="rank">順位</option>
  <option value="yakitori">焼き鳥</option>
  <option value="hako">箱</option>
  <option value="CIP">CIP</option>
  <option value="yakumanID">役満ID</option>
  <option value="money">お金</option>
  <option value="seisan">精算</option>
</select>
    <br>
    <label for="search_query">検索キーワード</label>
    <input type="text" name="search_query" id="search_query">
    <br>   
    <input type="submit" class="btn" name="search" value="検索">
  </form>

  
  <div class="results-container">
    <?php if (!empty($result)): ?>
      <table class="products-table">
      <tr>
        <th>ID</th>
        <th>日付</th>
        <th>半荘回数</th>
        <th>トータル得点</th>
        <th>順位</th>
        <th>役満</th>
        <th>箱</th>
        <th>CIP</th>
        <th>お金</th>
        <th>精算</th>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['day']; ?></td>
            <td><?php echo $row['hanchankaisuu']; ?></td>
            <td><?php echo $row['tokuten']; ?></td>
            <td><?php echo $row['rank']; ?></td>
            <td><?php echo $row['yakumanID']; ?></td>
            <td><?php echo $row['hako']; ?></td>
            <td><?php echo $row['CIP']; ?></td>
            <td><?php echo $row['money']; ?></td>
            <td><?php echo $row['seisan']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    <?php else: ?>
      <p>検索結果がありません。</p>
    <?php endif; ?>
  </div>
  <footer>
  <a href="read.php" class="btn">もどれ</a>
    </main>
     <footer>
         <p class="copyright">&copy; 麻雀得点管理アプリ武君 All rights reserved.</p>
     </footer>
 </body>
 
 </html>