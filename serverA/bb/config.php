<?php
$db = pg_connect("host=localhost dbname=bb_db user=postgres password=postgres");
if (!$db) {
    die("Error in connection: " . pg_last_error());
}
?>
