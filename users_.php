<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['cedula'] !== 'admin') header('Location: index.php');