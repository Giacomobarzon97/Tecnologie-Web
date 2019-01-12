<?php

    class ValidateData{

        static function checkStringIsEmpty($string){
            //Check che non sia vuota
            if(!isset($string) || $string === ""){
                return false;
            }
            //Check lunghezza
            if(strlen($string) == 0 || strlen(trim($string)) == 0){
                return false; 
            }

            return true;
        }

        //Controlla che l'email sia valida
        static function validateEmail($email){
            if(!ValidateData::checkStringIsEmpty($email)){
                return false;
            }

            if(!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email)){
                return false;
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return false;
            }

            if(strlen($email) > 100){
                return false;
            }

            return true;
        }

        //Controlla che il nome/cognome contenga solo lettere e sia lungo da 3 a 100 caratteri
        static function validateName($string){
            if(!ValidateData::checkStringIsEmpty($string)){
                return false;
            }

            if(!preg_match('/^[A-Za-z]{1,99}$/', $string)){
                return false;
            }

            if(strlen($string) > 100){
                return false;
            }

            return true;
        }

        //Controlla se la password è lunga da 3 a 100 caratteri
        static function validatePassword($password){
            if(!ValidateData::checkStringIsEmpty($password)){
                return false;
            }

            if(strlen($password) > 100 || strlen($password) < 3){
                return false;
            }

            return true;
        }
    }//class_end

?>