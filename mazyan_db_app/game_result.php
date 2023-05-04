<?php
session_start();


// エラーメッセージがある場合は取得して削除する
$error_msg = "";
if (isset($_SESSION["error_msg"])) {
    $error_msg = $_SESSION["error_msg"];
    unset($_SESSION["error_msg"]);
}
// データベース接続情報
$dsn = 'mysql:dbname=mazyan_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'araiofficeDaisaku208';
$pdo = new PDO($dsn, $user, $password);

// メンバー情報を取得
$sql = "SELECT * FROM member";
$members = $pdo->query($sql)->fetchAll();


// 役満名を取得
$sql = "SELECT yakumanid, yakuman_name FROM yakuman_name";
$yakumans = $pdo->query($sql)->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $yakuman = $_POST["yakuman"];
    // 変更点: プレイヤー人数を取得
    $player_count = $_POST["player_count"];

    // 変更点: プレイヤー人数に応じたループ
    for ($i = 1; $i <= $player_count; $i++) {
        $rank = "rank" . $i;
        ${"rank" . $i} = $_POST[$rank];
    }

    $sql = "INSERT INTO results (date, memberid, rank, yakuman) VALUES (:date, :memberid, :rank, :yakuman)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":yakuman", $yakuman);
    
    for ($i = 1; $i <= $player_count; $i++) {
        $stmt->bindParam(":memberid", ${"memberid" . $i});
        $stmt->bindParam(":rank", ${"rank" . $i});
        $stmt->execute();
    }

    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果入力</title>
    <link rel="stylesheet" href="css/style.css">
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
    <tbody>
    <form action="game_result.php" method="post" class="registration-form">
      

    <table>
  <thead>
    <tr>
      <th colspan="2">結果入力</th>
 
    </tr>
   
    <tr>
    <th>開催日</th>
    
      <th><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required></th>

  
      </tr>
<tr>
      
<td>プレイヤー人数</td>
      <td><!-- プレイヤー人数選択用のセレクトボックス -->
        <label for="player_count">プレイヤー:</label>
        <select name="player_count" id="player_count">
          <option value="3">3人</option>
          <option value="4">4人</option>
        </select></td>
</tr>
     
<tr>
      
<td>半チャン回数</td>



<td>
  <form id="half_count_form" action="game_result.php" method="post">
  <script>
    function resetHalfCount() {
      const halfCountInput = document.getElementById("half_count");
      halfCountInput.value = 0;
      // Add any other logic you want to reset here
    }
  </script>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
      error_reporting(E_ERROR | E_PARSE);
    }
    error_reporting(E_ERROR | E_PARSE);

    // 前回の半荘回数を取得
    $prevCount = isset($_SESSION["half_count"]) ? $_SESSION["half_count"] : 0;

    // 半荘回数を更新
    if(isset($_POST['reset'])) {
        $currentCount = 0;
        $_SESSION["half_count"] = $currentCount;
      } else {
        $currentCount = $prevCount + 1;
        $_SESSION["half_count"] = $currentCount;
      }
  
      // フォームに表示する
      echo '<input type="number" name="half_count" id="half_count" value="' . $currentCount . '" required>';
      ?>
      <button type="button" onclick="document.getElementById('half_count_form').reset(); document.getElementById('half_count').value='0';">リセット</button>
    </form>
  </td>
        </th>
       
      </td>
  </tr>
    </thead>
    <tbody>
  
    <tr>
          <td>箱代金</td>
          <td><!-- プレイヤー人数選択用のセレクトボックス -->
     
          <select name="hako_fee" id="hako_fee">
            <option value="3">100円</option>
            <option value="4">200円</option>
          </select></td>
      </tr>
  
      <tr>
          <td>チップ</td>
          <td><!-- プレイヤー人数選択用のセレクトボックス -->
     
          <select name="chip_fee" id="chip_fee">
            <option value="3">100円</option>
            <option value="4">200円</option>
          </select></td>
      </tr>
  
      <tr>
          <td>やきとり </td>
          <td><!-- プレイヤー人数選択用のセレクトボックス -->
  
          <select name="yakitori_fee" id="yakitori_fee">
            <option value="3">100円</option>
            <option value="4">200円</option>
          </select></td>
      </tr>
  
    <tr>
          <td>役満祝儀 </td>
          <td><!-- プレイヤー人数選択用のセレクトボックス -->
    
          <select name="yakuman_fee" id="yakuman_fee">
            <option value="3">100円</option>
            <option value="4">200円</option>
          </select></td>
      </tr>
  
      <tr>
          <td> <div class="button-container">
      <button type="submit" form="registration-form" class="btn">書き込み</button>
      
  </div>  </td>
          <td><a href="read.php" class="btn">戻る</a></td>
      </tr>
    </tbody>
  </table>
  
        
  
          <table>
              <thead>
                  <tr>
                      <th>メンバー</th>
                      <th>ユーザー名</th>
                      <th>得点</th>
                      <th>順位</th>
                      <th>焼き鳥</th>
                    <th>役満</th>
                <th></th>
            </tr>
        </thead>
        <select name="memberid<?= $i ?>" required>
        <?php for ($i = 1; $i <= 4; $i++) : ?>
    <tr>
        <td>メンバー<?= $i ?></td>
        <td>
            <select name="memberid<?= $i ?>" required>
                <option disabled selected value="">選択してください</option>
                <?php foreach ($members as $member) : ?>
                    <option value="<?= $member['id'] ?>"><?= $member['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </td>
                    </td>
            <td>
                <input type="number" name="tokuten<?= $i ?>" min="0" max="100000000" required>
            </td>
            <td>
                <select name="rank<?= $i ?>" required>
                    <option disabled selected value="">選択してください</option>
                    <?php for ($j = 1; $j <= 4; $j++) : ?>
                        <option value="<?= $j ?>"><?= $j ?>位</option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="hako<?= $i ?>" required>
                    <option value="1">あり</option>
                    <option value="0">なし</option>
                </select>
            </td>
            <td>
    <select name="yakumanid<?= $i ?>">
        <option disabled selected value="">選択してください</option>
        <?php foreach ($yakumans as $yakuman) : ?>
            <option value="<?= $yakuman['yakumanid'] ?>"><?= $yakuman['yakuman_name'] ?></option>
        <?php endforeach; ?>
    </select>
</td>
        </tr>
    <?php endfor; ?>
</tbody>
    </table>
    
    </form>

<style>
    .button-container {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 16px;
    }
</style>
</body>
</html>