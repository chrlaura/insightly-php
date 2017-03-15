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

    public function getAllContactInfo() {
        return $this->apiObject["CONTACTINFOS"];
    }

    public function setAllContactInfo($allContactInfo) {
        $this->apiObject["CONTACTINFOS"] = $allContactInfo;
        return $this;
    }

    /**
     * Return an array of ContactInfo assoc arrays with a specific type
     *
     * @param $type
     * @return array
     */
    public function getContactInfo($type) {
        $infoWithType = array();
        foreach ($this->getAllContactInfo() as $contactInfo) {
            if ($contactInfo[ContactInfo::TYPE] === $type) {
                $infoWithType[] = $contactInfo;
            }
        }
        return $infoWithType;
    }

    public function addEmail($address, $label) {
        $infoObj = ContactInfo::createObject(ContactInfo::EMAIL, $label, $address);
        $contactInfo = $this->getAllContactInfo();
        $contactInfo[] = $infoObj;
        $this->setAllContactInfo($contactInfo);
        return $this;
    }

    public function updateEmail($emailObject) {
        // Abort if object does not have id
        if (!isset($emailObject[ContactInfo::ID])) {
            return $this;
        }

        $contactInfos = $this->getAllContactInfo();
        foreach ($contactInfos as $index => $contactInfo) {
            if (isset($contactInfo[ContactInfo::ID]) && $contactInfo[ContactInfo::ID] == $emailObject[ContactInfo::ID]) {
                $contactInfos[$index] = $emailObject;
                break;
            }
        }
        $this->setAllContactInfo($contactInfos);
        return $this;
    }

    public function deleteEmail($emailObject) {
        // Abort if object does not have id
        if (!isset($emailObject[ContactInfo::ID])) {
            return $this;
        }

        $contactInfos = $this->getAllContactInfo();
        foreach ($contactInfos as $index => $contactInfo) {
            if (isset($contactInfo[ContactInfo::ID]) && $contactInfo[ContactInfo::ID] == $emailObject[ContactInfo::ID]) {
                unset($contactInfos[$index]);
            }
        }
        // Reorder keys after unsetting - otherwise Insightly API will have trouble unserializing the array
        $contactInfos = array_values($contactInfos);
        $this->setAllContactInfo($contactInfos);
        return $this;
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

    public static function createObject($type, $label, $detail) {
        $obj = [
            self::TYPE => $type,
            self::LABEL => $label,
            self::DETAIL => $detail
        ];
        return $obj;
    }
}