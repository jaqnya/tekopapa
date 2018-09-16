<?php
include_once 'app/core/config.inc.php';

class Connection {

    private static $connection;

    public static function connect() {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO('mysql:host=' . SERVER_NAME . '; dbname=' . DATABASE_NAME, USER_NAME, PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->exec('SET CHARACTER SET utf8');
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
                die();
            }
        }
    }

    public static function disconnect() {
        if (isset(self::$connection)) {
            self::$connection = null;
        }
    }

    public static function get_connection() {
        return self::$connection;
    }

}
?>