<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 14/03/17
 * Time: 14:44
 */

namespace Insightly\Models;

class Contact extends AbstractModel
{

    const ROUTE = "/Contacts";

    private $id;
    private $salution;
    private $firstName;
    private $lastName;
    private $contactInfos;

    public function __construct(array $contactData) {
        $this->id = $this->getOptional("CONTACT_ID", $contactData, -1);
        $this->salution = $this->getOptional("SALUTATION", $contactData, "");
        $this->firstName = $this->getOptional("FIRSTNAME", $contactData, "");
        $this->lastName = $this->getOptional("LASTNAME", $contactData, "");
        $this->contactInfos = $this->getOptional("CONTACTINFOS", $contactData, array());

    }

}