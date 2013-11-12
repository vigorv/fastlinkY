<?php
        echo "<pre>";
        print_r($links);
        echo ($sz/1024/1024)." Mb in use\n";
        echo (($limit-$sz)/1024/1024)." Mb for free\n";
        echo " as count:". count($links)."\n";
?>