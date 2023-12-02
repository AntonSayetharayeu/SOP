<?php

if (file_exists('fun-steps.php'))
    include('fun-steps.php');

$config_file = "core/.config/config.php";

switch($step){

    case 2:
    step2();
    break;
    
    case 3:
    step3();
    break;
    
    case 4:
    step4();
    break;
    
    case 5:
    step5();
    break;
    
    case 6:
    step6();
    break;
    
    case 7:
    step7();
    break;
    
    case 8:
    step8();
    break;
    
    case 9:
    step9();
    break;
    
    default:
    if(file_exists($config_file)){
            if(is_writable($config_file)){
                    $step = 1;
                    //form_install_step1(); - do generacji formularza
            } else {
                echo "<p>Zmień uprawnienia do pliku <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></p>";
                echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
            }
        }else{
            echo "<p>Stwórz plik <code>".$config_file."</code><br>np. <code>touch ".$config_file."</code></p>";
            echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
        }
    
    break;
}

?>