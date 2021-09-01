<?php

//======================================================================
// DB System
//======================================================================

namespace Hive;

use PDO;

class DB
{
    protected static $object;
    protected static $PDO =null;
    protected $query = [];
    protected $table;

    protected function __construct($arguments)
    {
        self::$object = $this;
        self::$PDO = Connect::get();
        $this->table = $arguments[0];
        $this->query[] = "SELECT * FROM `{$arguments[0]}`";
        return self::$object;
    }

    public static function __callStatic($name, $arguments)
    {
        if ($name=="table") {
            self::$object = new DB($arguments);
        }
        return self::$object;
    }

    public function query($query)
    {
        $this->query[] = $query;
        return self::$object;
    }


    public function create($data=[])
    {
        $table = $this->table;
        $q = "INSERT INTO `{$table}` (";
        foreach (array_keys($data) as $key) {
            $and = null;
            if (count($data)>1 && array_key_last($data)!=$key) {
                $and = ",";
            }
            $q .= " `{$key}` {$and}";
        }
        $q .= ") VALUES ( ";
        foreach ($data as  $key => $value) {
            $and = null;
            if (count($data)>1 && array_key_last($data)!=$key) {
                $and = ",";
            }
            $q .= " '{$value}' {$and}";
        }
        $q .= " );";
        $this->query[] = $q;
        return self::$object;
    }

    public function delete()
    {
        $table = $this->table;
        $this->query[] = "DELETE FROM `{$table}`";
        // self::$query .= $query;
        return self::$object;
    }

    public function update($data=[])
    {
        $table = $this->table;
        $q = "UPDATE `{$table}` SET";
        foreach ($data as $key => $value) {
            $and = null;
            if (count($data)>1 && array_key_last($data)!=$key) {
                $and = ",";
            }
            $q .= " `{$key}` = '{$value}' {$and}";
        }
        $this->query[] = $q;
        return self::$object;
    }

    public function where($key, $condition='=', $value)
    {
        if (!in_array('WHERE', $this->query)) {
            $this->query[] .= " WHERE `{$key}` {$condition} '{$value}'";
        } else {
            $this->query[] .= " AND `{$key}` {$condition} '{$value}'";
        }
        return self::$object;
    }
    public function orWhere($key, $condition='=', $value)
    {
        if (!in_array('WHERE', $this->query)) {
            $this->query[] .= " WHERE `{$key}` {$condition} '{$value}'";
        } else {
            $this->query[] .= " OR `{$key}` {$condition} '{$value}'";
        }
        return self::$object;
    }

    public function orderBy($key, $by='asc')
    {
        $byUp = strtoupper($by);
        $this->query[] .= " ORDER BY `{$key}` {$byUp}";
        return self::$object;
    }

    public function limit($count)
    {
        $this->query[] .= " LIMIT {$count}";
        return self::$object;
    }

    private function getLine()
    {
        $q = null;
        if (arrayFindString('DELETE', $this->query)!=false) {
            $q .= arrayFindString('DELETE', $this->query);
        }
        if (arrayFindString('UPDATE', $this->query)!=false) {
            $q .= arrayFindString('UPDATE', $this->query);
        }
        if (is_null($q)) {
            $q .= $this->query[array_search('SELECT', $this->query)];
        }
        foreach ($this->query as $where) {
            if (strpos($where, "WHERE")>-1) {
                $q .= $where;
            }
            if (strpos($where, "AND")>-1) {
                $q .= $where;
            }
            if (strpos($where, "OR")>-1) {
                $q .= $where;
            }
        }
        if (arrayFindString('ORDER', $this->query)!=false) {
            $q .= arrayFindString('ORDER', $this->query);
        }
        if (arrayFindString('LIMIT', $this->query)!=false) {
            $q .= arrayFindString('LIMIT', $this->query);
        }
        return $q;
    }

    public function queryExecute()
    {
        return self::$PDO->exec($this->getLine());
    }

    public function get()
    {
        $data = self::$PDO->prepare($this->getLine());
        $data->execute();
        $res = $data->setFetchMode(PDO::FETCH_ASSOC);
        return $data->fetchAll();
    }
    public function getExe()
    {
        $data = self::$PDO->prepare($this->getLine());
        $data->execute();
        return $data;
    }
}
