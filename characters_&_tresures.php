<?php
/**
 * Created by PhpStorm.
 * User: yanis
 * Date: 11/12/2018
 * Time: 10:44
 */


class space
{
    private $_symbole = '*';

    public function read_symbole()
    {
        return $this->_symbole;
    }
}

class mountain
{
    private $_symbole = 'M';
    private $_x;
    private $_y;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }
    public function read_symbole()
    {
        return $this->_symbole;
    }
    public function read_x()
    {
        return $this->_x;
    }
    public function read_y()
    {
        return $this->_y;
    }
}
class treasure
{
    private $_symbole = 'T';
    private $_x;
    private $_y;
    private $_number;

    public function __construct($x, $y, $number)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_number = $number;
    }
    public function read_symbole()
    {
        return $this->_symbole;
    }
    public function read_x()
    {
        return $this->_x;
    }
    public function read_y()
    {
        return $this->_y;
    }
    public function read_number()
    {
        return $this->_number;
    }
    public function write_number()
    {
        $this->_number--;
    }
}
class adventurer
{
    private $_index;
    private $_symbole = 'A';
    private $_x;
    private $_y;
    private $_name;
    private $_level = 0;
    private $_orientation;
    private $_movements;
    private $_onTreasure = 0; // stocke le niveau du trésore sur la case pour pouvoir le reconstituer apres le mouvement
    private $_state = "L";

    public function __construct($x, $y, $name, $orientation, $movements, $i)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_name = $name;
        $this->_orientation = $orientation;
        $this->_movements = $movements;
        $this->_index = $i;
    }
    public function read_index()
    {
        return $this->_index;
    }
    public function read_symbole()
    {
        return $this->_symbole;
    }
    public function read_name()
    {
        return $this->_name;
    }
    public function read_x()
    {
        return $this->_x;
    }
    public function read_y()
    {
        return $this->_y;
    }
    public function read_state()
    {
        return $this->_state;
    }
    public function read_level()
    {
        return $this->_level;
    }
    public function read_orientation()
    {
        return $this->_orientation;
    }
    public function read_movements()
    {
        return $this->_movements;
    }
    public function read_treasure()
    {
        return $this->_onTreasure;
    }
    public function write_x($le_x)
    {
        $this->_x = $le_x;
    }
    public function write_y($le_y)
    {
        $this->_y = $le_y;
    }
    public function write_state()
    {
        $this->_state = "D";
    }
    public function write_level()
    {
        $this->_level++;
    }
    public function write_orientation($le_orientation)
    {
        $this->_orientation = $le_orientation;
    }
    public function write_movements()
    {
        $this->_movements = substr($this->_movements, 1);
    }
    public function write_treasure($le_treasureLevel)
    {
            $this->_onTreasure = $le_treasureLevel;
    }
}
class orc
{
    private $_index;
    private $_symbole = 'O';
    private $_x;
    private $_y;
    private $_level;
    private $_max_movements;
    private $_switch_movements = 0;
    private $_current_movements = 0;
    private $_onTreasure = 0;
    private $_state = "L";
    private $_n_combats = 0;

    public function __construct($x, $y, $level, $n_movements, $i)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_level = $level;
        $this->_max_movements = $n_movements;
        $this->_index = $i;
    }
    public function read_index()
    {
        return $this->_index;
    }
    public function read_symbole()
    {
        return $this->_symbole;
    }
    public function read_x()
    {
        return $this->_x;
    }
    public function read_y()
    {
        return $this->_y;
    }
    public function read_state()
    {
        return $this->_state;
    }
    public function read_n_combats()
    {
        return $this->_n_combats;
    }
    public function read_level()
    {
        return $this->_level;
    }
    public function read_max_movements()
    {
        return $this->_max_movements;
    }
    public function read_switch_movements()
    {
        return $this->_switch_movements;
    }
    public function read_current_movements()
    {
        return $this->_current_movements;
    }
    public function read_treasure()
    {
        return $this->_onTreasure;
    }
    public function write_x($le_x)
    {
        $this->_x = $le_x;
    }
    public function write_y($le_y)
    {
        $this->_y = $le_y;
    }
    public function write_state()
    {
        $this->_state = "D";
    }
    public function write_n_combats()
    {
        $this->_n_combats++;
    }
    public function write_switch_movements($le_switch_movements)
    {
        $this->_switch_movements = $le_switch_movements;
    }
    public function write_current_movements($le_t_movement)
    {
        $this->_current_movements = $le_t_movement;
    }
    public function write_max_movements($le_m_movement)
    {
        $this->_max_movements = $le_m_movement;
    }
    public function write_treasure($le_treasureLevel)
    {
        $this->_onTreasure = $le_treasureLevel;
    }
}
class goblin
{
    private $_index;
    private $_symbole = 'G';
    private $_x;
    private $_y;
    private $_level;
    private $_max_movements;
    private $_switch_movements = 0;
    private $_current_movements = 0;
    private $_onTreasure = 0;
    private $_state = "L";
    private $_n_combats = 0;

    public function __construct($x, $y, $level, $n_movements, $i)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_level = $level;
        $this->_max_movements = $n_movements;
        $this->_index = $i;
    }
    public function read_symbole()
    {
        return $this->_symbole;
    }
    public function read_index()
    {
        return $this->_index;
    }
    public function read_x()
    {
        return $this->_x;
    }
    public function read_y()
    {
        return $this->_y;
    }
    public function read_state()
    {
        return $this->_state;
    }
    public function read_n_combats()
    {
        return $this->_n_combats;
    }
    public function read_level()
    {
        return $this->_level;
    }
    public function read_max_movements()
    {
        return $this->_max_movements;
    }
    public function read_switch_movements()
    {
        return $this->_switch_movements;
    }
    public function read_current_movements()
    {
        return $this->_current_movements;
    }
    public function read_treasure()
    {
        return $this->_onTreasure;
    }
    public function write_x($le_x)
    {
        $this->_x = $le_x;
    }
    public function write_y($le_y)
    {
        $this->_y = $le_y;
    }
    public function write_state()
    {
        $this->_state = "D";
    }
    public function write_n_combats()
    {
        $this->_n_combats++;
    }
    public function write_switch_movements($le_switch_movements)
    {
        $this->_switch_movements = $le_switch_movements;
    }
    public function write_current_movements($le_t_movement)
    {
        $this->_current_movements = $le_t_movement;
    }
    public function write_max_movements($le_m_movement)
    {
        $this->_max_movements = $le_m_movement;
    }
    public function write_treasure($le_treasureLevel)
    {
        $this->_onTreasure = $le_treasureLevel;
    }
}