<?php
class Connection
{
    public static function make($config)
    {
        return new PDO("{$config['connection']};dbname={$config['dataBase']}", $config['userName'], $config['password']);
        
    }
}
