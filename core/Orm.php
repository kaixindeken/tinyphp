<?php

namespace core;

use dispatcher\Box;
use mysql_xdevapi\Exception;

class Orm extends Box
{
    public $_where;
    public $_select;
    public $_limit;
    public $_sql;
    public $_table;
    public $_params = [];

    public function init()
    {
        $this->_table = $this->table ?? strtolower(end(explode('\\',get_called_class()))).'s';
    }

	protected function find()
	{
        $this->_sql = 'SELECT * FROM '.$this->_table;
	    return $this;    
	}

	public function select($select)
	{
        if (is_array($select)) {
            $select = implode(',',$select);
        }
		$this->_sql = str_replace('*',trim($select),$this->_sql);
	    return $this;
	}

	public function one() 
	{
		$this->_limit = ' LIMIT 1';
	    return current($this->fetch());
	}

	public function all() 
	{
		return $this->fetch();
    }

    public function fetch()
    {
        return  Model::prepare($this->_sql.($this->_where ?? ''))
            ->bind($this->_params)
            ->get();
    }



    public function where($condition){
        $this->_where = $this->setCondition($condition,'WHERE');
        return $this;
    }

    public function or($condition){
        $this->_where .= $this->setCondition($condition,'OR');
        return $this;
    }

    public function and($condition){
        $this->_where .= $this->setCondition($condition,'AND');
        return $this;
    }

    public function setCondition($condition,$type){
        if (is_string($condition)){
            return " $type $condition";
        }
        if (!is_array($condition) || count($condition) != 3){
            Throw new \Exception("Invalid args in condition!");
        }

        $keyword = strtoupper($condition[0]);
        $field = $condition[1];
        $value = $condition[2];

        if($keyword == "BETWEEN"){
            if(!is_array($value) || count($value) != 2){
                Throw new \Exception("Invalid args in BETWEEN");
            }
            $tag = " ? AND ? ";
            $value = [$value[0],$value[1]];
        }else{
            $tag = '?';
            if (is_array($value)){
                while(next($value)){
                    $tag .= ' ,?';
                }
                $tag = "($tag)";
            }
        }
        $this -> _params = array_merge($this->_params,is_array($value) ? $value : [$value]);
        return " $type $field $keyword $tag";
    }

}
