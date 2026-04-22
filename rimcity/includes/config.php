<?php
// ============================================================
// RimCity — database configuration
//
// Default values match a standard Laragon / XAMPP install:
//   host=localhost, user=root, password='' (empty)
//
// You can override any value by setting an environment variable
// of the same name (handy for Docker / dev setups).
// ============================================================

$DB_HOST = getenv('RIMCITY_DB_HOST') ?: 'localhost';
$DB_PORT = getenv('RIMCITY_DB_PORT') ?: '3306';
$DB_USER = getenv('RIMCITY_DB_USER') ?: 'root';
$DB_PASS = getenv('RIMCITY_DB_PASS');       // default: empty string
if ($DB_PASS === false) { $DB_PASS = ''; }
$DB_NAME = getenv('RIMCITY_DB_NAME') ?: 'rimcity';

// Absolute path to the SQL dump used by the first-run auto-installer.
$SQL_FILE = __DIR__ . '/../database/rimcity.sql';
