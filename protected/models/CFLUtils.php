<?php

class CFLUtils {

    public static function genRandomString($length = 10, $chars = '', $type = array()) {
        //initialize the characters
        $alphaSmall = 'abcdefghijklmnopqrstuvwxyz';
        $alphaBig = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '0123456789';
        $othr = '`~!@#$%^&*()/*-+_=[{}]|;:",<>.\/?' . "'";

        $characters = "";
        $string = '';
        //defaults the array values if not set
        isset($type['alphaSmall']) ? $type['alphaSmall'] : $type['alphaSmall'] = true;  //alphaSmall - default true  
        isset($type['alphaBig']) ? $type['alphaBig'] : $type['alphaBig'] = true;      //alphaBig - default true
        isset($type['num']) ? $type['num'] : $type['num'] = true;                //num - default true
        isset($type['othr']) ? $type['othr'] : $type['othr'] = false;             //othr - default false 
        isset($type['duplicate']) ? $type['duplicate'] : $type['duplicate'] = true;    //duplicate - default true     

        if (strlen(trim($chars)) == 0) {
            $type['alphaSmall'] ? $characters .= $alphaSmall : $characters = $characters;
            $type['alphaBig'] ? $characters .= $alphaBig : $characters = $characters;
            $type['num'] ? $characters .= $num : $characters = $characters;
            $type['othr'] ? $characters .= $othr : $characters = $characters;
        }
        else
            $characters = str_replace(' ', '', $chars);

        if ($type['duplicate'])
            for (; $length > 0 && strlen($characters) > 0; $length--) {
                $ctr = mt_rand(0, (strlen($characters)) - 1);
                $string .= $characters[$ctr];
            }
        else
            $string = substr(str_shuffle($characters), 0, $length);

        return $string;
    }

}