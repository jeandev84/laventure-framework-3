<?php
namespace Laventure\Component\Database\ORM\Model;


use Laventure\Component\Database\Connection\Query\QueryHydrateInterface;
use Laventure\Component\Database\ORM\Model\Exception\ModelException;
use Laventure\Component\Database\ORM\Model\Query\Query;
use Laventure\Component\Database\ORM\Manager;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\QueryBuilder;


/**
 * AbstractModel
*/
abstract class AbstractModel  implements \ArrayAccess
{


      /**
       * @var self
      */
      private static $instance;



     /**
      * Model attributes
      *
      * @var array
     */
     protected $attributes = [];





     /**
      * Store attributes we can save
      *
      *
      * @var array
     */
     protected $fillable = [];





     /**
      * Guard columns
      *
      * @var string[]
     */
     protected $guarded = ['id'];




    /**
     * Primary Key
     *
     * @var string
     */
    protected $primaryKey = 'id';




    /**
     * Table name
     *
     * @var string
     */
    protected $table;




    /**
     * Define connection name
     *
     * @var string
     */
    protected $connection = '';



    /**
     * @var array
    */
    protected $wheres = [];




    /**
     * Order by
     *
     * @var array
    */
    protected $orderBy = [];




    /**
     * Model constructor
    */
    private function __construct()
    {
         $this->connection = self::getDB()->getConnectionName();
    }




    /**
     * @return Manager
    */
    protected static function getDB(): Manager
    {
         return Manager::make();
    }



    /**
     * @return QueryBuilder
    */
    public static function query(): QueryBuilder
    {
        $query = new Query(self::getTable(), get_called_class());

        $model = new static();

        if ($model->connection) {
            $query->connection($model->connection);
        }

        return $query->make();
    }



    /**
     * @param array $selects
     * @return Select
     */
    public static function select(array $selects = ['*']): Select
    {
         return self::query()->select($selects);
    }



    /**
     * @param array $attributes
     * @return false|self
     */
    public static function create(array $attributes)
    {
        if($lastId = self::query()->insert($attributes)) {
            return self::findOne($lastId);
        }

        return false;
    }




    /**
     * @param array $attributes
     * @return bool
     */
    public function update(array $attributes): bool
    {
        $wheres = [self::getPrimaryKey() => $this->getId()];

        return self::query()->update($attributes, $wheres)->execute();
    }




    /**
     * @param null $id
     * @return bool
    */
    public function delete($id = null): bool
    {
        $wheres = [self::getPrimaryKey() => ($id ?? $this->getId())];
        $queryBuilder = self::query();

        if ($this->wheres) {
            $wheres = [];
            foreach ($this->wheres as $where) {
                $wheres[] = [$where['column'] => $where['value']];
            }
        }

        return $queryBuilder->delete($wheres)->execute();
    }



    /**
     * @param array $wheres
     * @return QueryHydrateInterface
     */
    public static function find(array $wheres): QueryHydrateInterface
    {
        foreach ($wheres as $column => $value) {
            static::where($column, $value);
        }

        return (new static())->fetch();
    }



    /**
     * Find one or failed result
     *
     * @param $id
     * @return mixed
    */
    public static function findOne($id)
    {
        if (! $model = static::where(self::getPrimaryKey(), $id)->one()) {
             static::createModelException(
                 sprintf('Could not find %s with %s=%s', get_called_class(), self::getPrimaryKey(), $id)
             );
        }

        return $model;
    }




    /**
     * Find all record result
     *
     * @return mixed
    */
    public static function all()
    {
        return (new static())->fetch()->all();
    }



    /**
     * @return int
    */
    public function save(): int
    {
         $columns = $this->getTableColumns();
         $attributes = $this->mapAttributes($columns);

         if ($id = $this->getId()) {
              // Update data
              $this->update($attributes);
         } else {
             // Insert data
             $model = self::create($attributes);
             $id    = $model->{self::getPrimaryKey()};
         }

         return $id;
    }




    /**
     * @param array $columns
     * @return array
    */
    private function mapAttributes(array $columns): array
    {
          $attributes = [];

          foreach ($columns as $column) {
              if (! empty($this->fillable)) {
                  if (\in_array($column, $this->fillable)) {
                      $attributes[$column] = $this->{$column};
                  }
              } else {
                  $attributes[$column] = $this->{$column};
              }
          }

          if (! empty($this->guarded)) {
              foreach ($this->guarded as $guarded) {
                   if (isset($attributes[$guarded])) {
                        unset($attributes[$guarded]);
                   }
              }
          }

          return $attributes;
    }




    /**
     * @return array
    */
    private function getTableColumns(): array
    {
        return self::getDB()->schema()->showColumns(self::getTable());
    }



    /**
     * Get model id
     *
     * @return int|null
    */
    private function getId(): ?int
    {
        return (int) $this->getAttribute(self::getPrimaryKey());
    }



    /**
     * @param string $column
     * @param $value
     * @param string $operator
     * @return $this
    */
    public static function where(string $column, $value, string $operator = '='): self
    {
        $model = (new static());

        $model->wheres[] = compact('column', 'value', 'operator');

        return $model;
    }




    /**
     * @return mixed
     */
    public function get()
    {
        return $this->fetch()->all();
    }




    /**
     * @param int $perPage
     * @return void
     */
    public function paginate(int $perPage)
    {

    }



    /**
     * @return mixed
     */
    public function one()
    {
        return $this->fetch()->one();
    }



    /**
     * @return mixed
     */
    public function first()
    {
        return $this->get()[0] ?? null;
    }



    /**
     * @return QueryHydrateInterface
    */
    private function fetch(): QueryHydrateInterface
    {
        $queryBuilder = self::query()->select(['*']);

        if (! empty($this->wheres)) {
            foreach ($this->wheres as $where) {
                list($column, $value, $operator) = array_values($where);
                $queryBuilder->where("$column $operator :$column");
                $queryBuilder->setParameter($column, $value);
            }
        }

        return $queryBuilder->fetch();
    }




    /**
     * @return string
     */
    protected static function getTable(): string
    {
        return (new static())->table;
    }




    /**
     * @return string
     */
    protected static function getPrimaryKey(): string
    {
        return (new static())->primaryKey;
    }


     /**
      * @param $name
      * @param $value
      * @return void
     */
     public function setAttribute($name, $value)
     {
           $this->attributes[$name] = $value;
     }




    /**
     * Set attributes
     *
     * @param array $attributes
     * @return void
    */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $column => $value) {
            $this->setAttribute($column, $value);
        }
    }




    /**
     * @param string $column
     * @return bool
     */
    public function hasAttribute(string $column): bool
    {
        return isset($this->attributes[$column]);
    }



    /**
     * Remove attribute
     *
     * @param string $column
     * @return void
    */
    public function removeAttribute(string $column)
    {
        unset($this->attributes[$column]);
    }




    /**
     * Get attribute
     *
     * @param string $column
     * @return mixed|null
     */
    public function getAttribute(string $column)
    {
        return $this->attributes[$column] ?? null;
    }


    /**
     * @param $field
     * @param $value
     */
    public function __set($field, $value)
    {
        $this->setAttribute($field, $value);
    }



    /**
     * @param $field
     * @return mixed
    */
    public function __get($field)
    {
        return $this->getAttribute($field);
    }


    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }



    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }



    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }




    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->removeAttribute($offset);
    }




    /**
     * @param $message
     * @return ModelException
    */
    private static function createModelException($message): ModelException
    {
         return (function () use ($message) {
              throw new ModelException($message);
         })();
    }
}