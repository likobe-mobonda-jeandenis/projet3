<?php

/**
 * Created by PhpStorm.
 * User: yanis
 * Date: 28/12/2018
 * Time: 21:49
 */

function advance_orientation ()
{
    global $_movementArray, $index1;
    $_y = $_movementArray[$index1]->read_y();
    $_x = $_movementArray[$index1]->read_x();

    if ($_movementArray[$index1]->read_symbole() == "A")
    {
        $orientation = $_movementArray[$index1]->read_orientation();
        $movements = $_movementArray[$index1]->read_movements();
        if ($movements[0] == "D" || $movements[0] == "G")
            orientation();
        elseif ($movements[0] == "A"){
            if ($orientation == "N")
                advance($_x, $_y-1, $_x, $_y);
            elseif ($orientation == "E")
                advance($_x+1, $_y, $_x, $_y);
            elseif ($orientation == "S")
                advance($_x, $_y+1, $_x, $_y);
            elseif ($orientation == "O")
                advance($_x-1, $_y, $_x, $_y);
        }
    }
    elseif ($_movementArray[$index1]->read_symbole() == "O")
    {
        $_c_movement = $_movementArray[$index1]->read_current_movements();
        $_m_movement = $_movementArray[$index1]->read_max_movements();
        $_s_movement = $_movementArray[$index1]->read_switch_movements();

        if ($_c_movement == 0)
        {
            $_movementArray[$index1]->write_switch_movements(0);
            $_movementArray[$index1]->write_current_movements($_c_movement+1);
            advance($_x, $_y+1, $_x, $_y);
        }
        elseif ($_c_movement == $_m_movement)
        {
            $_movementArray[$index1]->write_switch_movements(1);
            $_movementArray[$index1]->write_current_movements($_c_movement-1);
            advance($_x, $_y-1, $_x, $_y);
        }
        elseif ($_c_movement < $_m_movement && $_s_movement == 0){
            $_movementArray[$index1]->write_current_movements($_c_movement+1);
            advance($_x, $_y+1, $_x, $_y);
        }
        elseif ($_c_movement < $_m_movement && $_s_movement == 1)
        {
            $_movementArray[$index1]->write_current_movements($_c_movement-1);
            advance($_x, $_y-1, $_x, $_y);
        }
    }
    elseif ($_movementArray[$index1]->read_symbole() == "G")
    {
        $_c_movement = $_movementArray[$index1]->read_current_movements();
        $_m_movement = $_movementArray[$index1]->read_max_movements();
        $_s_movement = $_movementArray[$index1]->read_switch_movements();

        if ($_c_movement == 0)
        {
            $_movementArray[$index1]->write_switch_movements(0);
            $_movementArray[$index1]->write_current_movements($_c_movement+1);
            advance($_x+1, $_y, $_x, $_y);
        }
        elseif ($_c_movement == $_m_movement)
        {
            $_movementArray[$index1]->write_switch_movements(1);
            $_movementArray[$index1]->write_current_movements($_c_movement-1);
            advance($_x-1, $_y, $_x, $_y);
        }
        elseif ($_c_movement < $_m_movement && $_s_movement == 0){
            $_movementArray[$index1]->write_current_movements($_c_movement+1);
            advance($_x+1, $_y, $_x, $_y);
        }
        elseif ($_c_movement < $_m_movement && $_s_movement == 1)
        {
            $_movementArray[$index1]->write_current_movements($_c_movement-1);
            advance($_x-1, $_y, $_x, $_y);
        }
    }
}

function orientation()
{
    global $_movementArray, $index1;

    $boussole = array("N", "E", "S", "O");
    $i = 0;
    while ($boussole[$i] != $_movementArray[$index1]->read_orientation()) {
        $i++;
    }
    $movements = $_movementArray[$index1]->read_movements();
    if ($movements[0] == "D") {
        if ($i != 3) {
            $i++;
            $_movementArray[$index1]->write_orientation($boussole[$i]);
        } else {
            $_movementArray[$index1]->write_orientation("N");
        }
    } elseif ($movements[0] == "G") {
        if ($i != 0) {
            $i--;
            $_movementArray[$index1]->write_orientation($boussole[$i]);
        } else {
            $_movementArray[$index1]->write_orientation("O");
        }
    }
    $_movementArray[$index1]->write_movements();
}

function advance($_x, $_y, $x_original, $y_original)
{
    // defenir pour ce qui suit le deplacement sur les tresaures, et sortie de la map
    global $map, $_movementArray, $index1, $dimensions_c;
    $switch = true;

    if ($_x >= 0 && $_y >= 0 && $_x <= $dimensions_c[1] && $_y <= $dimensions_c[2]){ // ne pas sortir de la map
        if ($map[$_y][$_x]->read_symbole() != "M" && $map[$_y][$_x]->read_symbole() != $map[$y_original][$x_original]->read_symbole()) { // colisions
            $tempLevel = $map[$y_original][$x_original]->read_treasure(); // variable ,ombre de trésores sur la case originalement
            if ($map[$_y][$_x]->read_symbole() == "T") { // gestion de trésores
                if ($map[$y_original][$x_original]->read_symbole() == "A"){
                    $map[$y_original][$x_original]->write_level();
                    $map[$_y][$_x]->write_number();
                }
                $map[$y_original][$x_original]->write_treasure($map[$_y][$_x]->read_number());
            } else {
                $map[$y_original][$x_original]->write_treasure(0);
            }
            // rencontre entre enemies
            if ($map[$y_original][$x_original]->read_symbole() == "A" && ($map[$_y][$_x]->read_symbole() == "G" || $map[$_y][$_x]->read_symbole() == "O")){
                if ($map[$y_original][$x_original]->read_level() < $map[$_y][$_x]->read_level()){
                    $map[$y_original][$x_original]->write_state();
                    $switch = false;
                }
                else
                    $_movementArray[$map[$_y][$_x]->read_index()]->write_state();
                    $map[$y_original][$x_original]->write_n_combats();
            }
            elseif (($map[$y_original][$x_original]->read_symbole() == "G" || $map[$y_original][$x_original]->read_symbole() == "O") && $map[$_y][$_x]->read_symbole() == "A"){
                if ($map[$y_original][$x_original]->read_level() <= $map[$_y][$_x]->read_level()){
                    $map[$y_original][$x_original]->write_n_combats();
                    $map[$y_original][$x_original]->write_state();
                    $switch = false;
                }
                else {
                    $map[$y_original][$x_original]->write_n_combats();
                    $_movementArray[$map[$_y][$_x]->read_index()]->write_state();
                }
            }

            if ($switch == true){
                $map[$_y][$_x] = $map[$y_original][$x_original];
                unset($map[$y_original][$x_original]);
                if ($tempLevel != 0)
                    $map[$y_original][$x_original] = new treasure($x_original, $y_original, $tempLevel);
                else
                    $map[$y_original][$x_original] = new space;
                $map[$_y][$_x]->write_x($_x);
                $map[$_y][$_x]->write_y($_y);
                $_movementArray[$index1] = $map[$_y][$_x];
            }
            elseif ($switch == false){
                unset($map[$y_original][$x_original]);
                $map[$y_original][$x_original] = new space;
            }
        }
        elseif ($map[$_y][$_x]->read_symbole() == "M" && ($map[$y_original][$x_original]->read_symbole() == "G" || $map[$y_original][$x_original]->read_symbole() == "O"))
        {
            $_m_movements = $_movementArray[$index1]->read_max_movements();
            $_movementArray[$index1]->write_max_movements($_m_movements-1);
            $map[$y_original][$x_original]->write_max_movements($_m_movements-1);
        }
    }
    elseif ($_x < 0 || $_y < 0 || $_x > $dimensions_c[1] || $_y > $dimensions_c[2]){ // enlever un nombre maximum de mouvement, sinon le monstre va revenir plus qu'il ne le faut parceque a l'allée il s'est retrouvé bloqué
        $_m_movements = $_movementArray[$index1]->read_max_movements();
        $_movementArray[$index1]->write_max_movements($_m_movements-1);
        $map[$y_original][$x_original]->write_max_movements($_m_movements-1);
    }
    if ($_movementArray[$index1]->read_symbole() == "A" && $switch == true) // enlever une consigne de mouvement
        $map[$_y][$_x]->write_movements();
}