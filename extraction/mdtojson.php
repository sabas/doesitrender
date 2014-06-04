<?php
//generate the json from taglist.md
$f=file('taglist.md');

$arr=array();
$k='';
foreach($f as $r){
if (substr($r,0,1)=='#')
{
$k=trim(substr($r,1));
continue;
}
if(trim($r)=="")continue;
$arr[$k][]=trim($r);
}

echo(json_encode($arr));
?>
