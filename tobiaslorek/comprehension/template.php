<?php

use tobiaslorek/comprehension/Comprehension as C;

$nested = [
	[1, 2, 3, 4, 5]
	['a', 'b', 'c', 'd', 'e']
]

$st = "asdasd";

$other = [1,2,3,4,1];

C::_for($x)->in($nested)->or($st)->pick(5)->
	_and($i)->in($x)->
	_and($s)->asScan(function($acc, $i, $s) { return $acc + $i + $s; }, $i, $s)->
	_and($g)->asGroups(function($x, $s) { return $x + $s; }, $x, $s)->
	_where(function($g) { return $g > 0; })->
	_and($c)->in($st)->
	_and($upper)->asMapping(function($c, $d) { return toupper("{$c}{$d}"); }, $c, $i)
