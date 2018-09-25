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

        // Check and init structure
        if ($this->firebaseCmsConfig->structure) {

        } else {
            // Simply serve the templates folder 1 for 1
        }

        // Check and init content
        if ($this->firebaseCmsConfig->content) {

        }


    }

}

$firebaseCms = new FirebaseCms();

?>