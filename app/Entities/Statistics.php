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
 * @ORM\Table(name="statistics")
 * @ORM\HasLifecycleCallbacks()
 */
class Statistics
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
    private $filename;

    /**
     * @ORM\Column(type="string")
     */
    private $members_all;

    /**
     * @ORM\Column(type="string")
     */
    private $members_add;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="string")
     */
    private $error;

    public function __construct($input)
    {
        if (isset($input['filename'])) {
            $this->setFileName($input['filename']);
        }
        if (isset($input['members_all'])) {
            $this->setMembersAll($input['members_all']);
        }
        if (isset($input['members_add'])) {
            $this->setMembersAdd($input['members_add']);
        }
        if (isset($input['status'])) {
            $this->setStatus($input['status']);
        }
        if (isset($input['error'])) {
            $this->setError($input['error']);
        }
    }

    public function setId($id)
    {
        return $this->id=$id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFileName($filename)
    {
        return $this->filename=$filename;
    }
    public function getFileName()
    {
        return $this->filename;
    }
    public function setMembersAll($members_all)
    {
        return $this->members_all=$members_all;
    }
    public function getMembersAll()
    {
        return $this->members_all;
    }
    public function setMembersAdd($members_add)
    {
        return $this->members_add=$members_add;
    }
    public function getMembersAdd()
    {
        return $this->members_add;
    }
    public function setStatus($status)
    {
        return $this->status=$status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setError($error)
    {
        return $this->error=$error;
    }
    public function getError()
    {
        return $this->error;
    }
}
