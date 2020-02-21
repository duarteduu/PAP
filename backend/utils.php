<?php
    function isset_array($method_arr, $arr){
        foreach ($arr as $v){
            if (!array_key_exists($v, $method_arr)){
                return false;
            }
       }
        return true;
    }

    function string_size($str, $min, $max){
        if (strlen($str) >= $min && strlen($str) <= $max){
            return true;
        }
        return false;
    }

    function build_get_query($assoc_arr){
        $query = '';
        $c = 0;
        foreach ($assoc_arr as $k => $v){
            if ($c == 0){
                $query .= "?$k=$v";
            } else{
                $query .= "&$k=$v";
            }
            $c += 1;
        }
        return $query;
    }