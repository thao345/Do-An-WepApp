<?php
session_start();


$file = 'count.txt';

if (!file_exists($file)) {
    file_put_contents($file, '0');
}

$count = (int)file_get_contents($file);

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'increment' && !isset($_SESSION['has_visited'])) {
        $_SESSION['has_visited'] = true;
        $count++;
    } elseif ($_GET['action'] == 'decrement' && isset($_SESSION['has_visited'])) {
        unset($_SESSION['has_visited']);
        $count--;
    }
    file_put_contents($file, $count);
}

?>