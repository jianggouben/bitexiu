<?php

namespace Slackiss\Bundle\BitBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LabelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LabelRepository extends EntityRepository
{
    public function getSelectList()
    {

        $collocations = $this->createQueryBuilder('a')
            ->orderBy('a.modified','desc')
            ->where('a.status = :status')
            ->andWhere('a.enabled = :enabled')
            ->setParameters(array('status'=>true,'enabled'=>true));

        return $collocations;
    }
}
