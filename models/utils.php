<?php
    function  pujar_imatge($nom_form, $nom_foto){
        $target_dir = __DIR__ . "/../uploads/";
        $nom_foto = str_replace(" ", "_",$nom_foto);

        $tmp_name = $_FILES[$nom_form]['tmp_name'];
        if (is_dir($target_dir) && is_uploaded_file($tmp_name))
        {
            $img_type = $_FILES[$nom_form]['type'];
            if((strpos($img_type, "gif") ||strpos($img_type, "jpg") || strpos($img_type, "jpeg") || strpos($img_type, "png") ))
            {
                if(strpos($img_type, "jpeg")){
                    $extensio = 'jpeg';
                }else{
                    $extensio = substr($img_type, -3,3);
                }
                if(move_uploaded_file($tmp_name, $target_dir.'/'.$nom_foto.'.'.$extensio))
                {
                    return $nom_foto.'.'.$extensio;
                }
            }
        }
        return null;
    }
    function neteja_dades($dada){
        $dada = trim($dada);
        $dada = stripslashes($dada);
        $dada = htmlspecialchars(($dada));
        return $dada;
    }
?>