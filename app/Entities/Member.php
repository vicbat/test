<?php
/**
 * Created by PhpStorm.
 * User: _
 * Date: 26.01.2019
 * Time: 16:03
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="members")
 * @ORM\HasLifecycleCallbacks()
 */
class Member
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $full_name;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $state;

    /**
     * @ORM\Column(type="string")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string")
     */
    private $is_union;

    /**
     * @ORM\Column(type="string")
     */
    private $member_number;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    public function __construct($input)
    {
        $this->setFullName($input['full_name']);
        $this->setAddress($input['address']);
        $this->setCity($input['city']);
        $this->setState($input['state']);
        $this->setZipcode($input['zipcode']);
        $this->setIsUnion($input['is_union']);
        $this->setMemberNumber($input['member_number']);
        $this->setEmail($input['email']);
        $this->setPhone($input['phone']);
    }

    public function setId($id)
    {
        return $this->id=$id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFullName($full_name)
    {
        return $this->full_name=$full_name;
    }
    public function getFullName()
    {
        return $this->full_name;
    }
    public function setAddress($address)
    {
        return $this->address=$address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setCity($city)
    {
        return $this->city=$city;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setState($state)
    {
        return $this->state=$state;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setZipcode($zipcode)
    {
        return $this->zipcode=$zipcode;
    }
    public function getZipcode()
    {
        return $this->zipcode;
    }
    public function setIsUnion($is_union)
    {
        return $this->is_union=$is_union;
    }
    public function getIsUnion()
    {
        return $this->is_union;
    }
    public function setMemberNumber($member_number)
    {
        return $this->member_number=$member_number;
    }
    public function getMemberNumber()
    {
        return $this->member_number;
    }
    public function setEmail($email)
    {
        return $this->email=$email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setPhone($phone)
    {
        return $this->phone=$phone;
    }
    public function getPhone()
    {
        return $this->phone;
    }

}
