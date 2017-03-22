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

    public function getId() {
        return $this->apiObject["CONTACT_ID"];
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

    public function getLinks() {
        return $this->apiObject["LINKS"];
    }

    public function setLinks($links) {
        $this->apiObject["LINKS"] = $links;
        return $this;
    }

    public function getBackground() {
        return $this->apiObject["BACKGROUND"];
    }

    public function setBackground($background) {
        $this->apiObject["BACKGROUND"] = $background;
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

    private function addContactInfo($contactInfo) {
        $allContactInfo = $this->getAllContactInfo();
        $allContactInfo[] = $contactInfo;
        $this->setAllContactInfo($allContactInfo);
        return $this;
    }

    private function replaceContactInfo($new) {
        // Abort if object does not have id
        if (!isset($new[ContactInfo::ID])) {
            return $this;
        }

        $allInfo = $this->getAllContactInfo();
        foreach ($allInfo as $index => $current) {
            if (isset($current[ContactInfo::ID]) && $current[ContactInfo::ID] == $new[ContactInfo::ID]) {
                $allInfo[$index] = $new;
                break;
            }
        }
        $this->setAllContactInfo($allInfo);
        return $this;
    }

    private function deleteContactInfo($contactInfo) {
        // Abort if object does not have id
        if (!isset($contactInfo[ContactInfo::ID])) {
            return $this;
        }

        $allInfo = $this->getAllContactInfo();
        foreach ($allInfo as $index => $current) {
            if (isset($current[ContactInfo::ID]) && $current[ContactInfo::ID] == $contactInfo[ContactInfo::ID]) {
                unset($allInfo[$index]);
            }
        }
        // Reorder keys after unsetting - otherwise Insightly API will have trouble unserializing the array
        $allInfo = array_values($allInfo);
        $this->setAllContactInfo($allInfo);
        return $this;
    }

    public function addEmail($address, $label) {
        $infoObj = ContactInfo::create(ContactInfo::EMAIL, $label, $address);
        $this->addContactInfo($infoObj);
        return $this;
    }

    public function updateEmail($emailObject) {
        $this->replaceContactInfo($emailObject);
        return $this;
    }

    public function deleteEmail($emailObject) {
        $this->deleteContactInfo($emailObject);
        return $this;
    }

    public function getEmails() {
        return $this->getContactInfo(ContactInfo::EMAIL);
    }

    public function getEmailsWithLabel($label) {
        $emails = $this->getEmails();
        $emailsWithLabel = [];
        foreach ($emails as $email) {
            if ($email[ContactInfo::LABEL] == $label) {
                $emailsWithLabel[] = $email;
            }
        }
        return $emailsWithLabel;
    }

    public function addPhone($number, $label) {
        $infoObj = ContactInfo::create(ContactInfo::PHONE, $label, $number);
        $this->addContactInfo($infoObj);
        return $this;
    }

    public function updatePhone($phoneObject) {
        $this->replaceContactInfo($phoneObject);
        return $this;
    }

    public function deletePhone($phoneObject) {
        $this->deleteContactInfo($phoneObject);
        return $this;
    }

    public function getPhones() {
        return $this->getContactInfo(ContactInfo::PHONE);
    }

    public function addAddress($type, $street, $city = null, $state = null, $postcode = null, $country = null) {
        $addrObj = Address::create($type, $street, $city, $state, $postcode, $country);
        $addresses = $this->getAddresses();
        $addresses[] = $addrObj;
        $this->setAddresses($addresses);
        return $this;
    }

    public function updateAddress($newAddressObject) {
        // Abort if object does not have id
        if (!isset($newAddressObject[Address::ID])) {
            return $this;
        }

        $addresses = $this->getAddresses();
        foreach ($addresses as $index => $current) {
            if (isset($current[Address::ID]) && $current[Address::ID] == $newAddressObject[Address::ID]) {
                $addresses[$index] = $newAddressObject;
                break;
            }
        }
        $this->setAddresses($addresses);
        return $this;
    }

    public function deleteAddress($addressObject) {
        // Abort if object does not have id
        if (!isset($addressObject[Address::ID])) {
            return $this;
        }

        $addresses = $this->getAddresses();
        foreach ($addresses as $index => $current) {
            if (isset($current[Address::ID]) && $current[Address::ID] == $addressObject[Address::ID]) {
                unset($addresses[$index]);
            }
        }
        // Reorder keys after unsetting - otherwise Insightly API will have trouble unserializing the array
        $addresses = array_values($addresses);
        $this->setAddresses($addresses);
        return $this;
    }

    public function getAddresses() {
        return $this->apiObject["ADDRESSES"];
    }

    public function setAddresses($addresses) {
        $this->apiObject["ADDRESSES"] = $addresses;
        return $this;
    }

    public function hasTag($tagName) {
        return $this->getTag($tagName) !== null;
    }

    public function getTag($tagName) {
        $tags = $this->getTags();
        foreach ($tags as $tag) {
            if (isset($tag[Tag::NAME]) && $tag[Tag::NAME] == $tagName) {
                return $tag;
            }
        }
        return null;
    }

    public function addTag($tagName) {
        $tag = Tag::create($tagName);
        $tags = $this->getTags();
        $tags[] = $tag;
        $this->setTags($tags);
        return $this;
    }

    public function removeTag($tag) {
        if (is_string($tag)) {
            // In case a string with tag name is used as reference, convert to a Tag object
            $tag = Tag::create($tag);
        }

        $tags = $this->getTags();
        foreach ($tags as $index => $currentTag) {
            if (isset($currentTag[Tag::NAME]) && $currentTag[Tag::NAME] == $tag[Tag::NAME]) {
                unset($tags[$index]);
            }
        }
        // Reorder keys after unsetting - otherwise Insightly API will have trouble unserializing the array
        $tags = array_values($tags);
        $this->setTags($tags);
        return $this;
    }

    public function setTags($tags) {
        $this->apiObject["TAGS"] = $tags;
        return $this;
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

    public static function create($type, $label, $detail) {
        $obj = [
            self::TYPE => $type,
            self::LABEL => $label,
            self::DETAIL => $detail
        ];
        return $obj;
    }
}

class Address {
    // Keys
    const ID = "ADDRESS_ID";
    const TYPE = "ADDRESS_TYPE";
    const STREET = "STREET";
    const CITY = "CITY";
    const STATE = "STATE";
    const POSTCODE = "POSTCODE";
    const COUNTRY = "COUNTRY";
    // Valid values for type
    const WORK = "WORK";
    const HOME = "HOME";

    public static function create($type, $street, $city = null, $state = null, $postcode = null, $country = null) {
        $obj = [
            self::TYPE => $type,
            self::STREET => $street,
            self::CITY => $city,
            self::STATE => $state,
            self::POSTCODE => $postcode,
            self::COUNTRY => $country
        ];
        return $obj;
    }
}

class Tag {
    // Keys
    const NAME = "TAG_NAME";

    public static function create($tagName) {
        $obj = [
            self::NAME => $tagName
        ];
        return $obj;
    }
}

class Link {
    const ID = "LINK_ID";
    const CONTACT_ID = "CONTACT_ID";
    const OPPORTUNITY_ID = "OPPORTUNITY_ID";
    const ORGANISATION_ID = "ORGANISATION_ID";
    const PROJECT_ID = "PROJECT_ID";
    const SECOND_PROJECT_ID = "SECOND_PROJECT_ID";
    const SECOND_OPPORTUNITY_ID = "SECOND_OPPORTUNITY_ID";
    const ROLE = "ROLE";
    const DETAILS = "DETAILS";
}