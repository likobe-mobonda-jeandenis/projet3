<?php
/**
 * Created by PhpStorm.
 * User: yanis
 * Date: 11/12/2018
 * Time: 10:08
 */

include "characters_&_tresures.php";
include "deplacement.php";

$_movementArray;
$dimensions_c;
$k = 0;
$p = 0;
$map;

$file = fopen("inputfile.txt", "r");
if ($file) {
    while (($line_ = fgets($file)) !== false) {
        $line = rtrim($line_);
        if ($line[0] == "C") {
            $dimensions_c = explode(" - ", $line);
            for ($i = 0; $i <= $dimensions_c[2]; $i++){
                for ($j = 0; $j <= $dimensions_c[1]; $j++){
                    $map[$i][$j] = new space;
                }
            }
        }
        elseif ($line[0] == "M") {
            $dimensions = explode(" - ", $line);
            $map[$dimensions[2]][$dimensions[1]] = new mountain($dimensions[1], $dimensions[2]);
        }
        elseif ($line[0] == "T") {
            $dimensions = explode(" - ", $line);
            $map[$dimensions[2]][$dimensions[1]] = new treasure($dimensions[1], $dimensions[2], $dimensions[3]);
        }
        elseif ($line[0] == "A") {
            $dimensions = explode(" - ", $line);
            $map[$dimensions[3]][$dimensions[2]] = new adventurer($dimensions[2], $dimensions[3], $dimensions[1], $dimensions[4], $dimensions[5], $k);
            $_movementArray[$k] = $map[$dimensions[3]][$dimensions[2]];
            $k++;
        }
        elseif ($line[0] == "O") {
            $dimensions = explode(" - ", $line);
            $map[$dimensions[2]][$dimensions[1]] = new orc($dimensions[1], $dimensions[2], $dimensions[3], $dimensions[4], $k);
            $_movementArray[$k] = $map[$dimensions[2]][$dimensions[1]];
            $k++;
        }
        elseif ($line[0] == "G") {
            $dimensions = explode(" - ", $line);
            $map[$dimensions[2]][$dimensions[1]] = new goblin($dimensions[1], $dimensions[2], $dimensions[3], $dimensions[4], $k);
            $_movementArray[$k] = $map[$dimensions[2]][$dimensions[1]];
            $k++;
        }
    }
    fclose($file);

    //afficher la map
    for ($i = 0; $i <= $dimensions_c[2]; $i++){
        for ($j = 0; $j <= $dimensions_c[1]; $j++){
            echo $map[$i][$j]->read_symbole();
        }
        echo "<br>";
    }
    echo "<br>";
    echo "<br>";

    // traitement des deplacements
    $l = 0;
    while ($_movementArray[$l]->read_symbole() != "A"){
        $l++;
    }
    $numberOfMovements = strlen($_movementArray[$l]->read_movements());
    for ($index = 0; $index < $numberOfMovements; $index++) {
        for ($index1 = 0; $index1 < $k; $index1++) {
            if ($_movementArray[$index1]->read_state() == "L")
            {
                advance_orientation();
            }
        }
    }

    // affichage de fin
    for ($i = 0; $i <= $dimensions_c[2]; $i++){
        for ($j = 0; $j <= $dimensions_c[1]; $j++){
            echo $map[$i][$j]->read_symbole();
        }
        echo "<br>";
    }

} else {
    echo "problem reading file";
}

$file = fopen("outputfile.txt", "w");
if ($file) {
    for ($i = 0; $i <= $dimensions_c[2]; $i++) {
        for ($j = 0; $j <= $dimensions_c[1]; $j++) {
            if ($map[$i][$j]->read_symbole() == "M") {
                fwrite($file, $map[$i][$j]->read_symbole() . " - " . $map[$i][$j]->read_x() . " - " . $map[$i][$j]->read_y() . "\n");
            }
        }
    }
    for ($i = 0; $i <= $dimensions_c[2]; $i++) {
        for ($j = 0; $j <= $dimensions_c[1]; $j++) {
            if ($map[$i][$j]->read_symbole() == "T") {
                fwrite($file, $map[$i][$j]->read_symbole() . " - " . $map[$i][$j]->read_x() . " - " . $map[$i][$j]->read_y() . " - " . $map[$i][$j]->read_number() . "\n");
                echo "<br>";
            }
        }
    }

    for ($j = 0; $j < $k; $j++) {
        if ($_movementArray[$j]->read_symbole() == "A" && $_movementArray[$j]->read_state() == "L") {
            fwrite($file, $_movementArray[$j]->read_symbole() . " - " . $_movementArray[$j]->read_name() . " - " . $_movementArray[$j]->read_x() . " - " . $_movementArray[$j]->read_y() . " - " . $_movementArray[$j]->read_orientation() . " - " . $_movementArray[$j]->read_level() . "\n");
        }
        if ($_movementArray[$j]->read_symbole() == "G") {
            fwrite($file, $_movementArray[$j]->read_symbole() . " - " . $_movementArray[$j]->read_x() . " - " . $_movementArray[$j]->read_y() . " - " . $_movementArray[$j]->read_state() . " - " . $_movementArray[$j]->read_n_combats() . "\n");
        }
        if ($_movementArray[$j]->read_symbole() == "O") {
            fwrite($file, $_movementArray[$j]->read_symbole() . " - " . $_movementArray[$j]->read_x() . " - " . $_movementArray[$j]->read_y() . " - " . $_movementArray[$j]->read_state() . " - " . $_movementArray[$j]->read_n_combats() . "\n");
        }
    }
}