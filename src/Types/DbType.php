<?php

namespace JaguarJack\MigrateGenerator\Types;

abstract class DbType
{
    public const TINY_INT = 'tinyint';

    public const INTEGER = 'int';

    public const SMALLINT = 'smallint';

    public const BIG_INT = 'bigint';

    public const MEDIUMINT = 'mediumint';

    public const VARCHAR = 'varchar';

    public const CHAR = 'char';

    public const TINY_TEXT = 'tinytext';

    public const TEXT = 'text';

    public const MEDIUM_TEXT = 'mediumtext';

    public const LONG_TEXT = 'longtext';

    public const TINY_BLOB = 'tinyblob';

    public const BLOB = 'blob';

    public const MEDIUM_BLOB = 'mediumblob';

    public const LONG_BLOB = 'longblob';

    public const DATE = 'date';

    public const DATETIME = 'datetime';

    public const TIMESTAMP = 'timestamp';

    public const JSON = 'json';

    public const DOUBLE = 'double';

    public const DECIMAL = 'decimal';

    public const FLOAT = 'float';

    public const ENUM = 'enum';

    public const GEOMETRY = 'geometry';

    public const GEOMETRY_COLLECTION = 'geometry_collection';

    public const LINESTRING = 'linestring';

    public const MULTILINESTRING = 'multilinestring';

    public const POINT = 'point';

    public const POLYGON = 'polygon';

    public const YEAR = 'year';

    public const MULTIPOINT = 'multipoint';

    public const MULTIPOLYGON = 'multipolygon';

    /**
     * length for text and blob
     */
    public const TINY_LENGTH = 255;

    public const LENGTH = 65535;

    public const MEDIUM_LENGTH = 1663535;

    public const LONG_LENGTH = 0;

}