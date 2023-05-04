<?PHP
$dsn = 'mysql:dbname=mazyan_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'araiofficeDaisaku208';

try {
    $pdo = new PDO($dsn, $user, $password);

    $sql_select = 'SELECT userstable.id, game_results.hanchankaisuu, game_results.tokuten, game_results.rank, game_results.day, game_results.CIP, game_results.yakumanid, userstable.name, userstable.id, yakuman_name.yakumanid, yakuman_name.yakuman_name
FROM yakuman_name INNER JOIN (userstable INNER JOIN game_results ON userstable.id = game_results.id) ON yakuman_name.yakumanid = game_results.yakumanid';

    $stmt_select = $pdo->query($sql_select);
    $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
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
     <main>
         <article class="products">
             <h1>メニュー</h1>
             <div class="products-ui">
                 <div>
                     <!-- ここに並び替えボタンと検索ボックスを作成する -->
                 </div>
                 <a href="game_result.php" class="btn">ゲーム内容設定</a>
                 <br>
                 <br>
                 
                 <br><a href="kensaku.php" class="btn">成績</a>
                 <br>
                 <a href="index.php" class="btn">もどれ</a>
                 <br>
                 <br>
                
             </div>
             <table class="products-table">
                 <tr>
                     <th>メンバー</th>
                     <th>半チャン回数</th>
                     <th>箱単価</th>
                     <th>１位回数</th>
                     <th>対戦日</th>
                     <th>役満</th>
                 </tr>
                 <?php
                 // 配列の中身を順番に取り出し、表形式で出力する
                 foreach ($products as $product) {
                     $table_row = "
                         <tr>
                         <td>{$product['name']}</td>
                        <td>{$product['hanchankaisuu']}</td>
                       <td>{$product['tokuten']}</td>
                       <td>{$product['id']}</td>
                        <td>{$product['name']}</td>
                        <td>{$product['yakumanid']}</td>                          
                         </tr>                 
                     ";
                     echo $table_row;
                 }
                 ?>
             </table>
         </article>
     </main>
     <footer>
         <p class="copyright">&copy; 麻雀得点管理APP武君 All rights reserved.</p>
     </footer>
 </body>
 
 </html>