<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 14/03/17
 * Time: 14:44
 */

namespace Insightly\Models;

class Contact {

    const ROUTE = "/Contacts";

    private $apiObject;

    public function __construct(array $apiObject) {
        $this->apiObject = $apiObject;
    }

    /**
     * Return an array of ContactInfo assoc arrays with a specific type
     *
     * @param $type
     * @return array
     */
    public function getContactInfo($type) {
        $infoWithType = array();
        foreach ($this->apiObject["CONTACTINFOS"] as $contactInfo) {
            if ($contactInfo[ContactInfo::TYPE] === $type) {
                $infoWithType[] = $contactInfo;
            }
        }
        return $infoWithType;
    }

    public function setSalutation($salutation) {
        $this->apiObject["SALUTATION"] = $salutation;
        return $this;
    }

    public function getSalutation() {
        return $this->apiObject["SALUTATION"];
    }

    public function setFirstName($firstName) {
        $this->apiObject["FIRST_NAME"] = $firstName;
        return $this;
    }

    public function getFirstName() {
        return $this->apiObject["FIRST_NAME"];
    }

    public function setLastName($lastName) {
        if(!empty($lastName)) {
            $this->apiObject["LAST_NAME"] = $lastName;
        }
        return $this;
    }

    public function getLastName() {
        return $this->apiObject["LAST_NAME"];
    }

    public function getEmails() {
        return $this->getContactInfo(ContactInfo::EMAIL);
    }

    public function getPhones() {
        return $this->getContactInfo(ContactInfo::PHONE);
    }

    public function getAddresses() {
        return $this->apiObject["ADRESSES"];
    }

    public function getTags() {
        return $this->apiObject["TAGS"];
    }

    public function getCustomFields() {
        return $this->apiObject["CUSTOMFIELDS"];
    }

    public function getApiObject() {
        return $this->apiObject;
    }

}

class ContactInfo  {
    // Keys
    const ID = "CONTACT_INFO_ID";
    const TYPE = "TYPE";
    const LABEL = "LABEL";
    const DETAIL = "DETAIL";
    // Valid values for type
    const EMAIL = "EMAIL";
    const PHONE = "PHONE";
    // Valid values for label
    const WORK = "WORK";
    const PERSONAL = "PERSONAL";
    const HOME = "HOME";
}