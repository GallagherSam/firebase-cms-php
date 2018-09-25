<?php

// Dependencies
include "classes/util.php";

class FirebaseCms {

    // Public Properties

    // Private Properties
    private $firebaseCmsConfig;
    private $util;

    function __construct() {

        // Load dependencies
        $this->util = new Util();

        $this->util->consoleLog("CMS Starting");

        // Load the init config
        $this->loadEngineConfig();

    }

    private function loadEngineConfig() {

        $this->firebaseCmsConfig = json_decode(file_get_contents("./configs/firebaseCms.json"));


    }

}

$firebaseCms = new FirebaseCms();

?>