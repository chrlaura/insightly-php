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
    private $salutation;
    private $firstName;
    private $lastName;
    private $contactInfos;
    private $tags;
    private $addresses;
    private $customFields;

    public function __construct(array $contactData) {
        $this->id = $this->getOptional("CONTACT_ID", $contactData, -1);
        $this->salutation = $this->getOptional("SALUTATION", $contactData, "");
        $this->firstName = $this->getOptional("FIRSTNAME", $contactData, "");
        $this->lastName = $this->getOptional("LASTNAME", $contactData, "");
        $this->contactInfos = $this->getOptional("CONTACTINFOS", $contactData, array());
        $this->tags = $this->getOptional("TAGS", $contactData, array());
        $this->addresses = $this->getOptional("ADDRESSES", $contactData, array());
        $this->customFields = $this->getOptional("CUSTOMFIELDS", $contactData, array());
    }

    /**
     * Return an array of ContactInfo assoc arrays with a specific type
     *
     * @param $type
     * @return array
     */
    public function getContactInfo($type) {
        $infoWithType = array();
        foreach ($this->contactInfos as $contactInfo) {
            if ($contactInfo[ContactInfo::TYPE] === $type) {
                $infoWithType[] = $contactInfo;
            }
        }
        return $infoWithType;
    }

    public function getSalutation() {
        return $this->salutation;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getEmails() {
        return $this->getContactInfo(ContactInfo::EMAIL);
    }

    public function getPhones() {
        return $this->getContactInfo(ContactInfo::PHONE);
    }

    public function getAddresses() {
        return $this->addresses;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getCustomFields() {
        return $this->customFields;
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