<?php
$query = $_SERVER['QUERY_STRING'] ?? '';
$target = 'consulta-externa.php' . ($query !== '' ? '?' . $query : '');
header('Location: ' . $target, true, 302);
exit;
