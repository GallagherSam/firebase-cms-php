<?php

    // Dependencies
    include 'worker.php';
    include 'classes/templateArray.php';
    include 'classes/slotManifest.php';

    $siteDataUrl = "site-data.json";

    // Check if the site-config file exists
    if (file_exists($siteDataUrl)) {

        // Read the data from the file
        // Kickoff main app
        class App {

            // Define all variables in this class as public
            public $pageUrl;
            public $siteConfig;
            public $siteData;

            public $siteConfigUrl = "site-config.json";
            public $siteDataUrl = "site-data.json";

            public $pageString;

            // Constructor
            function __construct() {

                $this->util = new Utility;

                // Get the site config
                $this->siteConfig = json_decode(file_get_contents($this->siteConfigUrl));

                // Get the site data config
                $this->siteData = json_decode(file_get_contents($this->siteDataUrl));

                // Use the pageUrl to find the right structural config
                $this->pageUrl = $_SERVER["REQUEST_URI"];

                // Get the actual url by removing the base url defined in the site config
                $this->pageUrl = substr($this->pageUrl, strlen($this->siteConfig->baseUrl), strlen($this->pageUrl));

                if (strlen($this->pageUrl) === 0 || $this->pageUrl === $this->siteConfig->homeUrl) {
                    // At the index
                    $this->getPageStructure("index");
                } else {
                    // Need to get the correct page
                    $this->getPageStructure("somethingElse");
                }

            }

            function getPageStructure($pageId) {

                // Check to make sure the page exists
                if ($this->siteData->$pageId) {

                    $string = $this->recursivelyBuildSite("index");
                    $this->util->log($string);
                    echo $string;

                } else {
                    // Return an error page
                    echo "This page doesn't exist...";
                }

            }

            function recursivelyBuildSite($pageId, $content = null) {
                // Get the template markup for the site wrapper
                if ($pageId === "index") {
                    $templateString = file_get_contents("templates/site-wrapper.html");
                } else {
                    $templateString = file_get_contents("templates/{$pageId}.html");
                }
                $this->util->log($templateString);
                $siteArray = new TemplateArray($templateString);
                $this->util->log($siteArray);
                $slotManifest = new SlotManifest($this->siteData->$pageId);

                if ($slotManifest->hasSlots) {
                    for ($i = 1; $i <= $slotManifest->numberOfSlots; $i++) {
                        $slot = $slotManifest->getSlot($i);
                        $string = $this->recursivelyBuildSite($slot->template);
                        $this->util->log($string);
                        $siteArray->addToActiveSlot($string, $i);
                    }
                }

                $string = $siteArray->createFinalString();

                return $siteArray->createFinalString();

            }

            // Debugging Functions

            function getState() {
                $this->util->log($this);
            }

        }

        class Utility {

           function log($any) {
                if (is_string($any)) {
                    $data = "'" . $any . "'";
                } else {
                    $data = json_encode($any);
                }
                echo "<script>console.log(" . $data . ")</script>";
            }

            function javascriptLog($any) {
            }

        }

        buildSite();

    } else {

        // Prompt the worker to load the site data (should only ever happen once)
        include 'worker.php';
        buildSite();

    }

    function buildSite() {
        $app = new App;
        //echo "Hello";
    }

?>