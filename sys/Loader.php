<?php
/*
 * Class Loader
 * Created By Kang Hen
 * Dec 2016
 */

class Loader{

    /*
     * model()
     * load model file from model folder in folder app
     */
    function model($model){
        return $this->_load($model, APP_PATH. '/model/');
    }

    /*
     * helper()
     * load helper in app helper
     */
    function helper($helper){
        return $this->_load($helper, APP_PATH. '/helper/');
    }

    /*
     * _load()
     * load file
     */
    function _load($load, $path){

        /* if file as array */
        if(is_array($load)){
            foreach ($load as $file) {
                if(file_exists($path . ucfirst($file). '.php')){
                    require $path . ucfirst($file) .'.php';
                }else{
                    echo 'File {'. $file .'} not found';
                }
            }
        }else{
            /* single file */
            if(file_exists($path . ucfirst($load) . '.php')){
                require $path . ucfirst($load) . '.php';
            }else{
                echo 'File {'. $load .'} not found';
            }
        }
    }

}