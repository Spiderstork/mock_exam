<?php
class validate_details {
    function __construct($card_number, $expiry_month, $expiry_year, $cvv, $email) {
        $this->card_number = $card_number;
        $this->expiry_month = $expiry_month;
        $this->expiry_year = $expiry_year;
        $this->cvv = $cvv;
        $this->email = $email;
    }
    function validate_card_number() {
        return preg_match('/^\d{15,16}$/', $this->card_number);
    }
    function validate_expiry() {
        return preg_match('/^(0[1-9]|1[0-2])$/', $this->expiry_month) && preg_match('/^\d{2}$/', $this->expiry_year);
    }
    function validate_cvv() {
        return preg_match('/^\d{3}$/', $this->cvv);
    }
    function validate_email() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
}