<?php
/**
 * Created by PhpStorm.
 * User: _
 * Date: 26.01.2019
 * Time: 16:21
 */

namespace App\Repository;

use App\Entities\Statistics;
use Doctrine\ORM\EntityManager;
class StatisticsRepo
{

    /**
     * @var string
     */
    private $class = 'App\Entities\Statistics';
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function create(Statistics $statistics)
    {
        $this->em->persist($statistics);
        $this->em->flush();
    }

    public function update(Statistics $statistics, $data)
    {
        if (isset($data['filename'])) {
            $statistics->setFileName($data['filename']);
        }
        if (isset($data['members_all'])) {
            $statistics->setMembersAll($data['members_all']);
        }
        if (isset($data['members_add'])) {
            $statistics->setMembersAdd($data['members_add']);
        }
        if (isset($data['status'])) {
            $statistics->setStatus($data['status']);
        }
        if (isset($data['error'])) {
            $statistics->setError($data['error']);
        }
        $this->em->persist($statistics);
        $this->em->flush();
    }

    public function statisticsOfId($id)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'id' => $id
        ]);
    }

    public function statisticsOfFileName($filename)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'filename' => $filename
        ]);
    }

    public function delete(Statistics $statistics)
    {
        $this->em->remove($statistics);
        $this->em->flush();
    }

    /**
     * create Statistics
     * @return Statistics
     */
    public function perpareData($data)
    {
        return new Statistics($data);
    }
}
