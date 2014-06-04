<?php
//extract tag filters

$x=simplexml_load_file('../xml/carto.xml');

$filter=$x->xpath("//Style/Rule/Filter");

$array=array();

foreach($filter as $f){
	$a=explode(" and ",$f);
	if(count($a)>1)
	{
		foreach($a as $e){
		dofor($e);
		}
	}
	else
	dofor($f);
}

foreach($array as $k=>$arrv){
	echo '#'.$k."<br/>";
	sort($arrv);
	foreach($arrv as $vk=>$v){
	echo $v."<br/>";
	}
	echo "<br/>";
}

function dofor($tag)
{
	$tag=html_entity_decode((string)$tag);
	$pat="/\(\[([\w:]+)\]\s!?=\s*'([\w-]+)'\)/i";

	$arr=array();
	preg_match_all($pat,$tag,$arr);

	if(!isset($arr[1][0])) return;

	if ($arr[1][0] == 'feature')
	{
		$ex=explode('_',$arr[2][0],2);
		addDict($ex[0],$ex[1]);
	}
	else
		addDict($arr[1][0],$arr[2][0]);
}

function addDict($k,$v){
	global $array;
	if(isset($array[$k])&& in_array($v,$array[$k])) return;
	$array[$k][]=$v;
	return;
}
?>
