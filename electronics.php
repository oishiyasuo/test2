<?php
/**
 * 電子製品データ [ M_MX321_01_20170527050522.dat ]
 * 次の2カラムからなるtsv区切りで出力
 * |ISBN|著者名|
 * 「全角アルファベットを含み、全角スラッシュを含まない」一覧 と
 * 「全角アルファベットを含み、全角スラッシュを含む」一覧は別のファイルとして生成
 * utf-8でLF
 */

mb_internal_encoding("UTF-8");

$fp = fopen("M_MX321_01_20170527050522.dat", "r");
$fp_out1 = fopen("electronics_alpha_no_slash.txt", "w");
$fp_out2 = fopen("electronics_alpha_exist_slash.txt", "w");
while (($buffer = fgets($fp, 4096)) !== false) {
	$data = explode("\t", $buffer);
	$isbn = $data[2];
	$choshamei = $data[8];
	$exist = exist_alpha($choshamei);
	if ($exist) {
		echo "$isbn, $choshamei \n";
		$exist = exist_slash($choshamei);
		if ($exist) {
			fputs($fp_out2, "$isbn\t$choshamei".chr(10));
		} else {
			fputs($fp_out1, "$isbn\t$choshamei".chr(10));
		}
	}
}
fclose($fp);
fclose($fp_out1);
fclose($fp_out2);

//全角アルファベットが含まれるか？
function exist_alpha($choshamei) {
	$alpha = "ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ";
	for ($i=0; $i<mb_strlen($alpha); $i++) {
		$c1 = mb_substr($alpha, $i, 1);
		$pos = mb_strpos($choshamei, $c1);
		if ($pos !== false) return true;
	}
	return false;
}

//全角スラッシュが含まれるか？
function exist_slash($choshamei) {
	$pos = mb_strpos($choshamei, "／");
	if ($pos !== false) return true;
	return false;
}
?>
