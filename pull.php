<?php
 $url = 'https://youtube.googleapis.com/super_stickers/sticker_ids_to_urls.csv';
 $git = '/usr/bin/git';
 $dest = './list.json';
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
 curl_setopt($ch, CURLOPT_TIMEOUT, 45);
 $buffer = curl_exec($ch);
 if ($buffer === false)
  return;
 $t = time();
 $lines = explode("\n", $buffer);
 $arr = array();
 for ($i = 0; $i < count($lines); $i++)
 {
  if (empty($lines[$i]))
   continue;
  $cols = explode(',', $lines[$i]);
  if (count($cols) !== 2)
   die('UNKNOWN COL COUNT: '.$lines[$i]);
  $k = $cols[0];
  $v = $cols[1];
  if (strpos($v, '.com/') !== -1)
   $v = substr($v, strpos($v, '.com/') + 5);
  $arr[$k] = $v;
 }
 ksort($arr, SORT_NATURAL);
 header('content-type: application/json');
 $ytss = array();
 $ytss['list'] = $arr;
 $ytss['template'] = 'https://yt3.ggpht.com/%STICKER_ID%=s256-rwa';
 $s = json_encode($ytss, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
 $s = str_replace('    ', ' ', $s);
 $o = file_get_contents($dest);
 if ($s !== $o)
 {
  file_put_contents($dest, $s);
  exec($git.' add '.$dest);
  exec($git.' commit -m "Sticker Update on '.date('Y-m-d', $t).'"');
  exec($git.' tag "v'.date('Y.m.d', $t).'"');
  exec($git.' push');
  exec($git.' push --tags');
 }
?>