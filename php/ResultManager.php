<?php
class ResultManager {
    private $is_error = false;
    private $result_message = NULL;

    function __construct($input_result_message, $input_is_error = false) {
        $this->result_message = $input_result_message;
        $this->is_error = $input_is_error;
    }

    function getIsError(){
        return $this->is_error;
    }

    function getMessage(){
        return $this->result_message;
    }
}

?>