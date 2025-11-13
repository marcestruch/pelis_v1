<?php
    interface IDbAccess
    {
        public static function getAll();
        public static function select($id);
        public static function insert($object);
        public static function delete($object);
        public static function update($object);
    }
?>