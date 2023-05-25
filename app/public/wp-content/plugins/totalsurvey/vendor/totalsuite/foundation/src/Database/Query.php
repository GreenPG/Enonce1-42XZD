<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Database;
! defined( 'ABSPATH' ) && exit();


use BadMethodCallException;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Concerns\QueryHelpers;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\BaseQuery;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Delete;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Exists;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Expression;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Insert;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Pagination;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Select;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Update;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class Table
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Database
 */
class Query
{
    use QueryHelpers;

    /**
     * @var Connection
     */
    protected static $connection;

    /**
     * @var string|Expression|Select
     */
    protected $table;

    /**
     * @var BaseQuery
     */
    protected $builder;

    /**
     * @var Model|string
     */
    protected $model;

    /**
     * Table constructor.
     *
     * @param            $table
     *
     * @throws DatabaseException
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->builder = (new Select(static::$connection))->table($table);
    }

    /**
     * @param Connection $connection
     */
    public static function setConnection(Connection $connection)
    {
        static::$connection = $connection;
    }

    /**
     * @param $value
     *
     * @return Expression
     */
    public static function raw($value)
    {
        return new Expression($value);
    }

    /**
     * @param array $columns
     *
     * @return Query|Select
     * @throws DatabaseException
     */
    public function select($columns = [])
    {
        $this->builder = new Select(static::$connection);
        $this->builder->table($this->table);
        $this->builder->columns($columns);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return Query
     * @throws DatabaseException
     */
    public function insert(array $values = [])
    {
        $this->builder = new Insert(static::$connection);
        $this->builder->table($this->table)->values($values);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return Query|Update
     * @throws DatabaseException
     */
    public function update(array $values = [])
    {
        $this->builder = new Update(static::$connection);
        $this->builder->table($this->table)->set($values);

        return $this;
    }

    /**
     * @return Query|Delete
     * @throws DatabaseException
     */
    public function delete()
    {
        $this->builder = new Delete(static::$connection);
        return $this->builder->table($this->table);
    }

    /**
     * @param callable $callback
     * @param bool $exists
     *
     * @return Query|Exists
     * @throws DatabaseException
     */
    public function exists(callable $callback, $exists = true)
    {
        $this->builder = new Exists(static::$connection);
        $this->builder->exists($callback, $exists);
        return $this->builder->table($this->table);
    }

    /**
     * @return Collection
     */
    public function get()
    {
        $results = $this->builder->execute();

        return $this->map(Collection::create($results));
    }

    /**
     * @param $data
     *
     * @return Collection|TableModel
     */
    public function map($data)
    {
        if ($data instanceof Collection) {
            return $data->map([$this, 'map']);
        }

        if (empty($data)) {
            return null;
        }

        if ($this->model) {
            return $this->model::from($data)->setExists(true);
        }

        return $data;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        $this->limit(1);
        $results = $this->execute();

        if (empty($results)) {
            return null;
        }

        return $this->map(reset($results));
    }

    /**
     * @param $perPage
     * @param $current
     *
     * @return Pagination
     */
    public function paginate($perPage, $current)
    {
        if (!$this->builder instanceof Select) {
            throw new BadMethodCallException(sprintf('Cannot call paginate on %s', get_class($this->builder)));
        }

        return Pagination::fromQuery($this, (int)$perPage, (int)$current);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->builder, $name)) {
            throw new BadMethodCallException(
                sprintf('Invalid method %s called on %s object', $name, get_class($this->builder))
            );
        }

        $result = $this->builder->$name(...$arguments);

        if (!$result instanceof BaseQuery) {
            return $result;
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return Query
     * @throws DatabaseException
     */
    public function setModel(string $class)
    {
        if (!class_exists($class)) {
            throw new DatabaseException("Model {$this->model} not found");
        }

        if (!is_subclass_of($class, TableModel::class)) {
            throw new DatabaseException('Model must be an instance of ' . TableModel::class);
        }

        $this->model = $class;
        return $this;
    }
}