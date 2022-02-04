<?php
class QueryBuilder
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    //Получаем всю таблицу если $data не передана, или конкретную строку если $data передана
    public function get_table_if_no_data(string $table, array $data = null)
    {
        if (!empty($data)) {
            $keys = array_keys($data);
            $str = '';
            foreach ($keys as $key => $value) {
                if ($key !== count($keys) - 1) {
                    $adn = ' AND ';
                } else {
                    $adn = '';
                }
                $str .= $value . ' LIKE :' . $value . $adn;
            }
        }
        empty($data) ? $sql = "SELECT * FROM {$table}" : $sql = "SELECT * FROM {$table} WHERE {$str}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(empty($data) ? null : $data);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Добавляем в таблицу (регестрируем пользователя)
    public function add_table(string $table, array $data)
    {
        $key = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$key}) VALUES ({$values})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }
    // Добавляем в таблицу и сразу же возвращает id добавленного поля
    public function add_in_table_return_id(string $table, array $data)
    {
        $this->add_table($table, $data);
        $id_add_rows = $this->get_table_if_no_data($table, $data);
        return $id_add_rows['0']['id'];
    }
    //обновляєм поле в таблице
    public function update_table(string $table, array $data, string $id)
    {
        $str = '';
        foreach (array_keys($data) as $key => $value) {
            $str .= $value . ' = :' . $value . ',';
        }
        $key = rtrim($str, ',');
        $data['id']=$id;
        $sql = "UPDATE {$table} SET {$key} WHERE {$table}.`id` = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }
    //Удаляем строку из таблицы
    public function del_rows(string $table, string $id)
    {
        $sql="DELETE FROM {$table} WHERE `social_links`.`id` = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
    }
}
