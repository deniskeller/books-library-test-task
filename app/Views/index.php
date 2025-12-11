<?php
require_once '../database/config.php';

$res = $pdo->query('SELECT * FROM authors');
$row = $res->fetchAll(PDO::FETCH_ASSOC);
dump($row);
dd($row);
