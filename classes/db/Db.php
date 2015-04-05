<?php
class Db extends PDO{

    private static $_instance;

    public function __construct( ) {
    
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance))
        {
            try {
                self::$_instance = new PDO('mysql:host='._DB_HOST_.';dbname='._DB_NAME_, _DB_LOGIN_, _DB_PASSWORD_);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return self::$_instance; 
    }

    /**
     * Query select
     *
     * @params string  $table  Table name
     * @params mixed   $fields Fields name
     * @params array   $where  Condition ('id' => $id)
     * @params boolean $row    If is row or not
     *
     * return object.
     */
    public static function select($table, $fields='*', $where=null, $row=true)
    {
        if (is_array($fields))
        {
            foreach ($fields as $field)
                $selectFields .= $field.',';

            $fields = rtrim($selectFields, ',');
        }

        $selectWhere = '';
        if ($where)
            foreach ($where as $key => $w)
                $selectWhere .= ($selectWhere == '') ? 'WHERE '.$key.' = :'.$key : ' AND '.$key.' = :'.$key;

        $db = self::getInstance();

        $pdo = $db->prepare("SELECT ".$fields." FROM ".$table." ".$selectWhere);

        if ($where)
            foreach ($where as $key => $wh)
                foreach ($wh as $k => &$w)
                    $pdo->bindParam(':'.$key, $w, $k);

        $pdo->execute();

        if ($row)
            return $pdo->fetch(PDO::FETCH_OBJ);
        else
        {
            $pdo->setFetchMode(PDO::FETCH_ASSOC);

            while($res = $pdo->fetch())
            {
                foreach ($res as $k => $r)
                    $select[$k] = $r;

                $selects[] = $select;
            }

            return $selects;
        }
    }

    /**
     * Query insert
     *
     * @params string $table  Table name
     * @params array  $fields Fields name (array(field => array(type => $val)));
     *
     * return object.
     */
    public static function insert($table, $fields)
    {
        $insert = '';
        $values    = '';
        foreach ($fields as $key => $field)
        {
            $insert .= $key.',';
            $values .= ':'.$key.',';
        }

        $db  = Db::getInstance();
        $ins = $db->prepare("INSERT INTO ".$table." (".rtrim($insert, ',').") VALUES (".rtrim($values, ',').")");

        foreach ($fields as $key => $field)
            foreach ($field as $k => &$f)
                $ins->bindParam(':'.$key, $f, $k);

        if($ins->execute())
            return $db->lastInsertId();

        return false;
    }

    /**
     * Query update
     *
     * @params string $table  Table name
     * @params array  $fields Fields name (array(field => array(type => $val)));
     * @params array  $where  Where (array(where => array(type => $val)));
     *
     * return object.
     */
    public static function update($table, $fields, $where=null)
    {
        $update = '';

        foreach ($fields as $key => $field)
        {
            $update .= $key.'= :'.$key.',';
        }

        $updateWhere = '';
        if ($where)
            foreach ($where as $key => $w)
                $updateWhere .= ($updateWhere == '') ? 'WHERE '.$key.' = :'.$key : ' AND '.$key.' = :'.$key;


        $db  = Db::getInstance();
        $up = $db->prepare("UPDATE ".$table." SET ".rtrim($update, ',')." ".$updateWhere);

        foreach ($fields as $key => $field)
            foreach ($field as $k => &$f)
                $up->bindParam(':'.$key, $f, $k);

        if ($where)
            foreach ($where as $key => $wh)
                foreach ($wh as $k => &$w)
                    $up->bindParam(':'.$key, $w, $k);

        return $up->execute();
    }

    public static function delete($table, $where=null)
    {
        $deleteWhere = '';
        if ($where)
            foreach ($where as $key => $w)
                $deleteWhere .= ($deleteWhere == '') ? 'WHERE '.$key.' = :'.$key : ' AND '.$key.' = :'.$key;

        $db  = Db::getInstance();
        $delete = $db->prepare("DELETE FROM ".$table." ".$deleteWhere);

        if ($where)
            foreach ($where as $key => $wh)
                foreach ($wh as $k => &$w)
                    $delete->bindParam(':'.$key, $w, $k);


        return $delete->execute();
    }
}