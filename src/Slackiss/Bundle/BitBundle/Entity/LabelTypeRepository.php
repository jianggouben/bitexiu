<?php

namespace Slackiss\Bundle\BitBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LabelTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LabelTypeRepository extends EntityRepository
{
    public function getSelectList()
    {

        $collocations = $this->createQueryBuilder('a')
            ->orderBy('a.sequence','desc')
            ->where('a.status = :status')
            ->andWhere('a.enabled = :enabled')
            ->setParameters(array('status'=>true,'enabled'=>true));

        return $collocations;
    }
}
