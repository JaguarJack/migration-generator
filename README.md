<h1 align="center">Migration Generator-逆向迁移文件生成</h1>
<p align="center">
如果你还未使用或者正想使用数据库迁移功能，但又不并不想自己写迁移文件的话，这个工具可以很好的帮助实现文件迁移，
目前提供了 Laravel5.5+ 和 Thinkphp6+ 的迁移文件的生成。
</p>

## 安装
```sh
composer require jaguarjack/migration-generator:dev-master
```

## 平台支持
#### laravel
```shell
php artisan migration:generate
```

#### ThinkPHP
```
php think migration:generate
```
#### 注意
> 包中提供的命令如果不能完全满足你的需求，那么你可以根据实际自定义需求。

### 定义新类型

- 继承 \Doctrine\DBAL\Types\Type
```php
class newType extend \Doctrine\DBAL\Types\Type{} 
```
- 主要实现两个方法

```php
public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
{
    return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
}

public function getName()
{
    return 'TypeName';
}
```

- 注入

```php
$generator = new MigrateGenerator('thinkphp');
$generator->registerNewType([
    'TypeName' => TypeClass
]);
```

### 新增类型解析
> 就是对应框架 migration 的格式

- 继承实现
```php
classType extend JaguarJack\MigrateGenerator\Migration\Columns\AbstractType
{}
```
  
> 继承这个基类可以获取两个信息
    - 获取当前 `column` 的所有信息
    - 整个表结构的原始信息 这里可以得到 `DBAL` 不会提供的信息
    
- 必须实现的两个方法
> 因为现在就支持了 laravel 和 thinkphp 所有就定义了这两个方法

```php
    public function laravelMigrationColumn():string

    public function thinkphpMigrationColumn():string
```

- 注入

```php
$generator = new MigrateGenerator('thinkphp');
$generator->registerNewTypeParse([
    'TypeClassName' => ParseTypeClass
]);
```
> `TypeClassName` 指的就是新类型的类的名称
`ParseTypeClass` 也必须和 `TypeClass` 相同，这是约定，方便更好的解析。


### 其他

除了提供的自定义的命令外，通过两个对外接口自己生成文件
```php
$generator->getDatabase;
```
> 这个方法可以获取表信息以及字段信息等等

```php
$generator->getMigrationContent;
```
> 这个方法可以获取解析后 migration 文件内容

