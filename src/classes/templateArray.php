<?php

    class TemplateArray {

        public $siteArray;
        public $numberOfChildren;

        private $deliminator = "<php-include></php-include>";
        private $originalString; 
        private $onlyString = false;
        public $siteString;

        function __construct($string) {

            $this->originalString = $string;
            $this->buildInitialString($string);

        }

        public function addToActiveSlot($string, $i) {

            $this->siteArray[$i] = $string;

        }

        public function createFinalString() {

            if (!$this->onlyString) {
                return implode(" ", $this->siteArray);
            } else {
                return $this->siteString;
            }

        }

        private function compressHTML($htmlString) {

            return preg_replace('/\s+/S', " ", $htmlString);

        }

        private function buildInitialString($string) {

            if (strpos($string, $this->deliminator)) {

                $array = explode($this->deliminator, $string);
                $this->numberOfChildren = count($array) - 1;
                $this->siteArray = array();
    
                for ($i = 0; $i <= $this->numberOfChildren + 1; $i++) {
                    if ($i === 0) {
                        $this->siteArray[$i] = $this->compressHTML($array[0]);
                    } else if ($i === $this->numberOfChildren + 1) {
                        // This value is hardcoded right now, it should change to be flexible for <php-include> tag in different spots of markup
                        $this->siteArray[$i] = $this->compressHTML($array[2]);
                    } else {
                        $this->siteArray[$i] = "";
                    }
                }

            } else {
                $this->onlyString = true;
                $this->siteString = $string;
            }

        }

    }

?>