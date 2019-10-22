<?php

namespace JaguarJack\MigrateGenerator\Types;

use DateTime;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * TimestampType type for the Doctrine 2 ORM
 */
class TimestampType extends Type
{
    /**
     *
     * @time 2019年10月21日
     * @return string
     */
    public function getName(): string
    {
        return DbType::TIMESTAMP;
    }

    /**
     * @inheritDoc
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @inheritDoc
     * @throws
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof DateTime) {
            return $value->getTimestamp();
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', 'DateTime']
        );
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $dt = new DateTime();
        $dt->setTimestamp($value);

        return $dt;
    }
}
