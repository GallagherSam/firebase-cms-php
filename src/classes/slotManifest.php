<?php

    class SlotManifest {

        public $numberOfSlots;
        public $hasSlots;
        public $activeSlot;

        private $originalSlotConfig;
        private $currentPointer = 1;


        public function __construct($slotConfig) {

            $this->originalSlotConfig = $slotConfig;

            if ($this->originalSlotConfig->hasSlots) {

                $this->hasSlots = true;

                $index = 1;
                while ($this->originalSlotConfig->{"slot_" . $index}) {
                    ++$index;
                }
                // Not sure why we need to -1 here
                $this->numberOfSlots = $index - 1;
            }

        }

        public function getSlot($i) {

            return $this->originalSlotConfig->{"slot_{$i}"};

        }
    }

?>