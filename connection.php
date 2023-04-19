<?php
$host = "localhost";
$user = "postgres";
$password = "8915lena";
$dbname = "kurs_work";

$connection_string = "host={$host} dbname={$dbname} user={$user} password={$password} ";
$con = pg_connect($connection_string);
session_start();
