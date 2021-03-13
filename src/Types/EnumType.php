<?php

namespace JaguarJack\MigrateGenerator\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type as DoctrineType;

class EnumType extends DoctrineType
{
    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    public function getName()
    {
        // TODO: Implement getName() method.
        return DbType::ENUM;
    }

    /**
     * @inheritDoc
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
            ['null', 'enum']
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
