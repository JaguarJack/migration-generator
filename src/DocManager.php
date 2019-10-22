<?php

namespace JaguarJack\MigrateGenerator;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver as MysqlDriver;
use Doctrine\DBAL\Driver\PDOPgSql\Driver as PgSqlDriver;
use Doctrine\DBAL\Driver\PDOOracle\Driver as OracleDriver;
use Doctrine\DBAL\Driver\PDOSqlite\Driver as SqliteDriver;
use Doctrine\DBAL\Driver\SQLSrv\Driver as SQLSrvDriver;
use Doctrine\DBAL\Types\Type as DoctrineType;
use JaguarJack\MigrateGenerator\Exceptions\EmptyInDatabaseException;
use JaguarJack\MigrateGenerator\Types\DbType;
use JaguarJack\MigrateGenerator\Types\CharType;
use JaguarJack\MigrateGenerator\Types\EnumType;
use JaguarJack\MigrateGenerator\Types\GeometryType;
use JaguarJack\MigrateGenerator\Types\GeometrycollectionType;
use JaguarJack\MigrateGenerator\Types\LinestringType;
use JaguarJack\MigrateGenerator\Types\MediumIntType;
use JaguarJack\MigrateGenerator\Types\MultipointType;
use JaguarJack\MigrateGenerator\Types\MultipolygonType;
use JaguarJack\MigrateGenerator\Types\PointType;
use JaguarJack\MigrateGenerator\Types\PolygonType;
use JaguarJack\MigrateGenerator\Types\YearType;
use JaguarJack\MigrateGenerator\Types\DoubleType;
use JaguarJack\MigrateGenerator\Types\MultilinestringType;
use JaguarJack\MigrateGenerator\Types\TimestampType;
use think\helper\Str;
use think\Model;

class DocManager
{
    protected $doctrineManager = null;

    protected $frame;

    protected $doctrineConnection = null;

    private $types = [
        DbType::CHAR                => CharType::class,
        DbType::ENUM                => EnumType::class,
        DbType::GEOMETRY            => GeometryType::class,
        DbType::GEOMETRY_COLLECTION => GeometrycollectionType::class,
        DbType::LINESTRING          => LinestringType::class,
        DbType::MEDIUMINT           => MediumIntType::class,
        DbType::MULTIPOINT          => MultipointType::class,
        DbType::MULTIPOLYGON        => MultipolygonType::class,
        DbType::POINT               => PointType::class,
        DbType::POLYGON             => PolygonType::class,
        DbType::YEAR                => YearType::class,
        DbType::DOUBLE              => DoubleType::class,
        DbType::MULTILINESTRING     => MultilinestringType::class,
        DbType::TIMESTAMP           => TimestampType::class,
    ];

    /**
     * DocManager constructor.
     * @param $config
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct($frame)
    {
        $this->frame = strtolower($frame);

        $this->registerNewType();

        $this->registerDoctrineTypeMapping();
    }

    /**
     * get doctrine manager
     *
     * @time 2019年10月20日
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager|\Doctrine\DBAL\Schema\MySqlSchemaManager|\Doctrine\DBAL\Schema\OracleSchemaManager|\Doctrine\DBAL\Schema\PostgreSqlSchemaManager|\Doctrine\DBAL\Schema\SqliteSchemaManager|\Doctrine\DBAL\Schema\SQLServerSchemaManager
     * @throws EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getDoctrineManage()
    {
        if (!$this->doctrineManager) {
            $this->doctrineManager =  $this->getDoctrineDriver()->getSchemaManager($this->getDoctrineConnection());
        }

        return $this->doctrineManager;
    }

    /**
     * get
     *
     * @time 2019年10月20日
     * @throws \Doctrine\DBAL\DBALException
     * @return \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected function getDatabasePlatform(): \Doctrine\DBAL\Platforms\AbstractPlatform
    {
        return $this->getDoctrineManage()->getDatabasePlatform();
    }

    /**
     * get doctrine connection
     *
     * @time 2019年10月20日
     * @return Connection
     * @throws EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function getDoctrineConnection(): Connection
    {
        if (!$this->doctrineConnection) {
            if ($this->isLaravel()) {
                return $this->getLaravelDoctrineConnection();
                //return $this->getThinkPhpDoctrineConnection();
            }

            if ($this->isThinkPHP()) {
                return $this->getThinkPhpDoctrineConnection();
            }

            throw new \Exception('unsupported connection');
        }

        return $this->doctrineConnection;
    }

    /**
     * get Laravel Doctrine connection
     *
     * @time 2019年10月20日
     * @return mixed
     */
    protected function getLaravelDoctrineConnection()
    {
        return \Illuminate\Support\Facades\DB::connection()->getDoctrineSchemaManager();
    }

    /**
     * get doctrine connection
     *
     * @time 2019年10月20日
     * @throws EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     * @return Connection
     */
    protected function getThinkPhpDoctrineConnection(): Connection
    {
        return new Connection([
            'pdo' => $this->ThinkPHPPdoObject(),
        ], $this->getDoctrineDriver());
    }

    /**
     * get doctrine driver
     *
     * @time 2019年10月20日
     * @throws \Exception
     */
    protected function getDoctrineDriver()
    {
        switch (config('database.default')) {
            case 'mongo':
                throw new \Exception('not support mongo database yet');
            case 'mysql':
                return new MysqlDriver();
            case 'oracle':
                return new OracleDriver();
            case 'pgsql':
                return new PgSqlDriver();
            case 'sqlite':
                return new  SqliteDriver();
            case 'sqlsrv':
                return new SQLSrvDriver();
        }
    }

    /**
     * GET thinkphp Pdo Object
     *
     * @time 2019年10月20日
     * @throws EmptyInDatabaseException
     * @return mixed
     */
    protected function ThinkPHPPdoObject()
    {
        $tables = \think\facade\Db::getConnection()->getTables();

        if (empty($tables)) {
           throw new EmptyInDatabaseException();
        }

        return \think\facade\Db::table($tables[0])->getConnection()->getPdo();
    }

    /**
     * register new type
     *
     * @time 2019年10月20日
     * @throws \Doctrine\DBAL\DBALException
     * @return void
     */
    protected function registerNewType()
    {
        foreach ($this->types as $dbType => $class) {
            DoctrineType::addType($dbType, $class);
        }
    }

    /**
     * register map
     *
     * @time 2019年10月20日
     * @throws \Doctrine\DBAL\DBALException
     * @return void
     */
    protected function registerDoctrineTypeMapping()
    {
        foreach ($this->types as $dbType => $class) {
            $this->getDatabasePlatform()->registerDoctrineTypeMapping($dbType, $dbType);
        }
    }

    /**
     * is laravel
     *
     * @time 2019年10月20日
     * @return bool
     */
    protected function isLaravel(): bool
    {
        return $this->frame === 'laravel';
    }

    /**
     * is thinkphp
     *
     * @time 2019年10月20日
     * @param $name
     * @return bool
     */
    protected function isThinkPHP()
    {
        return $this->frame === 'thinkphp';
    }
}
