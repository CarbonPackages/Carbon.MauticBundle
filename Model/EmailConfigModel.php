<?php

namespace MauticPlugin\MauticCarbonBundle\Model;

use Mautic\CoreBundle\Model\AbstractCommonModel;
use Mautic\EmailBundle\Entity\Email;
use MauticPlugin\MauticCarbonBundle\Entity\EmailConfig;

class EmailConfigModel extends AbstractCommonModel
{
    public function getRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->em->getRepository(EmailConfig::class);
    }

    public function getEntityByEmail(Email $email = null): ?EmailConfig
    {
        if (null === $email) {
            return new EmailConfig();
        }

        return $this->getRepository()->findOneBy(['email' => $email]) ?? new EmailConfig();
    }
}
