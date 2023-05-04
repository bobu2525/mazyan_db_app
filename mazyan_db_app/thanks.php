<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>送信完了</title>
</head>
<body>
<?php
        // このコードは、PHPの三項演算子を使って、$_POST['〇〇〇']が存在する場合はその値を、
        // 存在しない場合は空文字列を、$〇〇〇に代入するという意味です。
        $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $goiken = isset($_POST['goiken']) ? $_POST['goiken'] : '';


        // htmlspecialcharsは、エスケープ処理を行うPHPの関数で、
        // 特殊文字を HTML エンティティに変換することで、
        // クロスサイトスクリプティング（XSS）
        // 攻撃を防ぐために使われます。
        // 読み⽅ 「エイチティーエムエルスペシャルチャーズ」と読みます。 
        $nickname = htmlspecialchars($nickname);
        $email = htmlspecialchars($email);
        $goiken = htmlspecialchars($goiken);

        // このコードは、フォームから送信されたデータを元に、メッセージを表示するためのものです。
        // 具体的には、以下のように処理しています。
        // print文を使用して、$nickname、$goiken、$emailに格納されている値を順番に出力しています。
        // それぞれの出力の間に、固定の文章を挿入しています。
        // 最後に、メールアドレスについては「電子手紙にて確認されたし」という文章を追加しています。    

        print $nickname;
        print '様<br>';
        print 'ご意見ありがとうございます。<br>' ;
        print '頂いだご意見「';
        print $goiken;
        print '」<br>';
        print $email;
        print 'に電子手紙にて確認されたし。';  
    $mail_sub='アンケート受け付けました。';
    $mail_boody= $nickname."様へ¥nアンケートご協力ありがとうごさいました。";
    $mail_boody=html_entity_decode($mail_boody, ENT_QUOTES, "UTF-8");
    $mail_head='from: XXX@XXX.co.jp';
    mb_language('japanese');
    mb_internal_encoding("UTF-8");
    mb_send_mail($email, $mail_sub, $mail_boody, $mail_head);
      ?> 
      <a href="menu.html">メニューにもどる</a><br>
	<h1>お問い合わせありがとうございました。</h1>
	<p>以下の内容でお問い合わせを受け付けました。</p>
	<ul>
		<li>ニックネーム：<?php echo htmlspecialchars($_POST['nickname'], ENT_QUOTES); ?></li>
		<li>メールアドレス：<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?></li>
		<li>ご意見：<?php echo htmlspecialchars($_POST['goiken'], ENT_QUOTES); ?></li>
	</ul>

</body>
</html>