<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Site
 *
 * @author Vladimir
 */
class Site {

    public static function isIndexActive($neededURI, $neededURI2 = false)
    {
        // Получить строку запроса
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        
        if ($neededURI2) {
            if ($neededURI == $uri[1] AND $neededURI2 == $uri[2])
                return true;            
        } else {
            if ($neededURI == $uri[1])
                return true;
        }
        return false;
    }
    
    // Отображает правильное склонение у числительных
    public static function declination($number, $titles)
    {
        $cases = array (2, 0, 1, 1, 1, 2);
        return $number." ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    }
}
