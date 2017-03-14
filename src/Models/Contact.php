<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 14/03/17
 * Time: 14:44
 */

namespace Insightly\Models;


class Contact
{

    const ROUTE = "/Contacts";

    private $id;
    private $salution;
    private $firstName;
    private $lastName;
    private $contactInfos;

    public function __construct(array $contactData) {
        $this->id = $this->carefullyGet("CONTACT_ID", $contactData, -1);
        $this->salution = $this->carefullyGet("SALUTATION", $contactData, "");
        $this->firstName = $this->carefullyGet("FIRSTNAME", $contactData, "");
        $this->lastName = $this->carefullyGet("LASTNAME", $contactData, "");
        $this->contactInfos = $this->carefullyGet("CONTACTINFOS", $contactData, array());
    }

    private function carefullyGet($key, $array, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
    }

}