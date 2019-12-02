<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="utf-8">
</head>
<title>やばい掲示板</title>

<?php
//編集パート１（選択～変数代入まで）
if(!empty($_POST["edit"])&& ($_POST["pass"]==="アーイ")){
 $f = "comp.txt";
 $fp = fopen($f,"r");
 $lin = file($f);
 $l = mb_convert_encoding($lin, "utf-8", "auto");

 foreach($l as $l1){
  $v = explode("<>",$l1);
  if($v[0]===$_POST["edit"]){
   $s = $v[0];  //編集番号
   $n = $v[1];  //編集名前
   $c = $v[2];  //編集コメント
  }
 }
 fclose($fp);
}
?>

<!-- HTML領域 -->
<h1 style="font-size: 20px;">やばい掲示板</h1>
やばくない(=ﾟωﾟ)ﾉ
<form action="comp.php" method="post">
 <dl>
   パス：
   <input style="background-color: #FFDDDD;" type="text" name="pass" value="" /><br>
  名前：
  <input type="text" name="name" value= "<?php if(!empty($n)){echo $n;} ?>" /><br>
  コメ：
  <input type="text" name="comment" value= "<?php if(!empty($c)){echo $c;} ?>" />
  <input type="submit" /><br>
  削除：
  <input type="text" name="del" value="" />
  <input type="submit" value="削除" /><br>
  編集：
  <input type="text" name="edit" value="" />
  <input type="hidden" name="subnum" value= "<?php if(!empty($_POST["edit"])){echo $_POST["edit"];} ?>" />
  <input type="submit" value="編集" />
  <!-- リロード -->
  <input type="submit" name="re" value="🔁" /><br>
 </dl>
</form>
<hr>
<!-- HTML領域 -->


<?php
if(!empty($_POST["name"]) && !empty($_POST["comment"])&& ($_POST["pass"]==="アーイ")){
//編集番号を受け付けたときの処理
 if(!empty($_POST["subnum"])){
  echo "****************名前・コメントを変更しました****************"."<br>";
  $f = "comp.txt";
  $lin = file($f);
  $l = mb_convert_encoding($lin, "utf-8", "auto");
  $fp = fopen($f,"w");

  foreach($l as $line){
   $v = explode("<>",$line);
   if($v[0]!==$_POST["subnum"]){ //編集番号じゃなかったら
    fwrite($fp, $line);
   }else{ //編集番号だったら
    //3年月日時間
    $d = date("Y/m/d H:i:s");
    //書き込み
    $wr = $_POST["subnum"]."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$d."\n";
    fwrite($fp,$wr);
    }
   }
 fclose($fp);
//新規投稿コメントを受け付けたときの処理
 }else{
  echo "****************コメントを受け付けました****************"."<br>";
  //ファイル
  $filename = "comp.txt";
  //0番号
  if(file_exists($filename)){
   $num = count(file($filename))+1;
  }else{
   $num=1;
  }
  //1名前
  $_POST["name"] = mb_convert_encoding($_POST["name"], "JIS", "auto");
  //2コメント
  $_POST["comment"] = mb_convert_encoding($_POST["comment"], "JIS", "auto");
  //3年月日時間
  $d = date("Y/m/d H:i:s");
  //書き込み
  $wr = $num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$d."\n";
  $fp = fopen($filename,"a+");
  fwrite($fp,$wr);
  fclose($fp);

  $f = "comp.txt";
  $array1 = file($f);
  $a1 = mb_convert_encoding($array1, "utf-8", "auto");
 }

//コメントがないときの処理
}else{
 echo "****************名前とコメントを入力！****************"."<br>";

 //削除対象番号を受け付けたときの処理
 if(!empty($_POST["del"])&& ($_POST["pass"]==="あ")){

  $f = "comp.txt";
  $fp = fopen($f,"r");
  $lines1 = file($f);
  $lines = mb_convert_encoding($lines1, "utf-8", "auto");
  fclose($fp);

  $fp = fopen($f,"w");
  foreach($lines as $line){
   $v = explode("<>",$line);
   if($v[0]!==$_POST["del"]){
    fwrite($fp, $line);
   }
  }
 fclose($fp);
 }
}

//表示
//表示or作る
if(file_exists("comp.txt")){
 $f = "comp.txt";
 $array1 = file($f);
 $a1 = mb_convert_encoding($array1, "utf-8", "auto");
 foreach($a1 as $value){
  $v = explode("<>",$value);
  echo $v[0]." ".$v[1]." ".$v[2]." ".$v[3]."<br>";
 }
}else{
 touch("comp.txt");
 $f = "comp.txt";
 $array1 = file($f);
 $a1 = mb_convert_encoding($array1, "utf-8", "auto");
 foreach($a1 as $value){
  $v = explode("<>",$value);
  echo $v[0]." ".$v[1]." ".$v[2]." ".$v[3]."<br>";
 }
}


?>
</html>
