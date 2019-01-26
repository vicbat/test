<?php
/**
 * Created by PhpStorm.
 * User: _
 * Date: 26.01.2019
 * Time: 16:21
 */

namespace App\Repository;

use App\Entities\Member;
use Doctrine\ORM\EntityManager;
class MemberRepo
{

    /**
     * @var string
     */
    private $class = 'App\Entities\Member';
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function create(Member $member)
    {
        $this->em->persist($member);
        $this->em->flush();
    }

    public function update(Member $member, $data)
    {
        $member->setFullName($data['full_name']);
        $member->setAddress($data['address']);
        $member->setCity($data['city']);
        $member->setState($data['state']);
        $member->setZipcode($data['zipcode']);
        $member->setIsUnion($data['is_union']);
        $member->setMemberNumber($data['member_number']);
        $member->setEmail($data['email']);
        $member->setPhone($data['phone']);
        $this->em->persist($member);
        $this->em->flush();
    }

    public function memberOfId($id)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'id' => $id
        ]);
    }

    public function delete(Member $member)
    {
        $this->em->remove($member);
        $this->em->flush();
    }

    /**
     * create Member
     * @return Member
     */
    public function perpareData($data)
    {
        return new Member($data);
    }
}
