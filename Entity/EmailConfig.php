<?php

declare(strict_types=1);

namespace MauticPlugin\MauticCarbonBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\CommonEntity;
use Mautic\EmailBundle\Entity\Email;
use function Symfony\Component\Translation\t;

class EmailConfig extends CommonEntity
{
    private ?int $id = null;
    private ?Email $email = null;
    private ?string $config = null;

    /**
     * @param ClassMetadata<self> $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('carbon_email_config')->setCustomRepositoryClass(EmailConfigRepository::class);

        $builder->addId();

        $builder
            ->createManyToOne('email', Email::class)
            ->addJoinColumn('email_id', 'id', false, true, 'CASCADE')
            ->build();

        $builder->createField('config', Types::JSON)->columnName('config')->build();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function setEmail(?Email $email): void
    {
        $this->email = $email;
    }

    public function getConfig(): ?string
    {
        return $this->config;
    }

    public function setConfig(?string $config): void
    {
        $this->config = $config;
    }
}
