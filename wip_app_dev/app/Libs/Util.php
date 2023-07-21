<?php

namespace App\Libs;


class Util
{
    public static function generateId($case, $num){
        $tmp = "";
        for ($i = 1; $i <= $num; $i++) {
            $sw = mt_rand(0, 2);
            if ($sw == 0 && $i != 1) {    
                $tmp .= chr(mt_rand(48, 57));
            } else {
                if ($case == "U") {
                    $tmp .= chr(mt_rand(65, 90));
                } else {
                    if ($sw == 2) {
                        $tmp .= chr(mt_rand(97, 122));
                    } else {
                        $tmp .= chr(mt_rand(65, 90));
                    }
                }
            }
        }
        return $tmp;
    }

}

?>





