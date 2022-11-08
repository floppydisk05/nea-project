<?php
class NoResultsException extends Exception {
    protected $details;

    public function __construct($details) {
        $this->details = $details;
        parent::__construct();
    }

    public function __toString() {
      return 'NoResultsException. More info: ' . $this->details;
    }
}
