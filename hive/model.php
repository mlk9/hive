<?php

//======================================================================
// Model System
//======================================================================

namespace Hive;

use Hive\DB;
use PDO;

class Model
{
    protected static $object;
    protected $db;
    protected $method_q;

    /* work static */
    public static function __callStatic($name, $arguments)
    {
        static::$object = new static();
        return static::$object->$name($arguments);
    }

    /* get this DB's object in this object */
    protected function getBD()
    {
        if (is_null($this->db)) {
            $arr = explode('\\', strtolower(get_called_class()));
            $model_name = end($arr);
            foreach (Connect::getTables() as $table) {
                if (strpos($table['Tables_in_hive'], $model_name)>-1 && strpos($table['Tables_in_hive'], $model_name)==0) {
                    return $this->db = DB::table($table['Tables_in_hive']);
                }
            }
        } else {
            return $this->db;
        }
    }

    /**
    * return model object for use
    *
    * @return object model
    */
    private function select()
    {
        return self::$object;
    }

    /**
    * create in the table's model
    *
    * @param array $data (require)
    */
    private function create($data = [])
    {
        return $this->getBD()->create($data[0])->queryExecute();
    }

    /**
    * update in the table's model
    *
    * @param array $data (require)
    */
    public function update($data = [])
    {
        return $this->getBD()->update($data)->queryExecute();
    }

    /**
    * delete in the table's model
    *
    */
    public function delete()
    {
        return $this->getBD()->delete()->queryExecute();
    }

    /**
    * where | and where select in the table's model
    * @param string $key (require)
    * @param string $condition (require)
    * @param string $value (require)
    *
    */
    public function where($key, $condition='=', $value)
    {
        if ($this->method_q!='where') {
            $this->getBD()->where($key, $condition, $value);
        } else {
            $this->getBD()->where($key, $condition, $value);
        }
        $this->method_q = 'where';
        return self::$object;
    }

    /**
    * where | or select in the table's model
    * @param string $key (require)
    * @param string $condition (require)
    * @param string $value (require)
    *
    */
    public function orWhere($key, $condition='=', $value)
    {
        if ($this->method_q!='where') {
            $this->getBD()->where($key, $condition, $value);
        } else {
            $this->getBD()->orWhere($key, $condition, $value);
        }
        $this->method_q = 'where';
        return self::$object;
    }

    /**
    * limit in count return query
    * @param int $count (require)
    *
    */
    public function limit($count)
    {
        $this->getBD()->limit($count);
        return self::$object;
    }

    /**
    * order by this query
    * @param string $key (require)
    * @param string $by (default : ASC)
    *
    */
    public function orderBy($key, $by='asc')
    {
        $this->getBD()->orderBy($key, $by='asc');
        return self::$object;
    }

    /**
    * return items in this query
    *
    * @return object items
    *
    */
    public function get()
    {
        $data = $this->getBD()->getExe();
        return $data->fetchAll(PDO::FETCH_CLASS, __CLASS__);

        $this->method_q = 'get';
    }
}
