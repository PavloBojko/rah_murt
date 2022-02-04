<?php
class Connection
{
    public static function make(array $config)
    {
        return new PDO("{$config['connection']};dbname={$config['dataBase']}", $config['userName'], $config['password']);
        
    }
}
