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
    private $customFields;
    private $tags;
    private $addresses;

    public function __construct(array $contactData) {
        $this->id = $this->getOptional("CONTACT_ID", $contactData, -1);
        $this->salution = $this->getOptional("SALUTATION", $contactData, "");
        $this->firstName = $this->getOptional("FIRSTNAME", $contactData, "");
        $this->lastName = $this->getOptional("LASTNAME", $contactData, "");
        $this->contactInfos = $this->getOptional("CONTACTINFOS", $contactData, array());
        $this->customFields = $this->getOptional("CUSTOMFIELDS", $contactData, array());
        $this->tags = $this->getOptional("TAGS", $contactData, array());
        $this->addresses = $this->getOptional("ADDRESSES", $contactData, array());
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

    public function getEmails() {
        return $this->getContactInfo(ContactInfo::EMAIL);
    }

    public function getPhones() {
        return $this->getContactInfo(ContactInfo::PHONE);
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