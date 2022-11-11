<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Contract;


interface SqlQueryBuilderInterface
{


    /**
     * Select records
     *
     * @param array $selects
     * @param string $table
     * @return mixed
    */
    public function select(array $selects, string $table);





    /**
     * Insert record
     *
     * @param array $attributes
     * @param string $table
     * @return mixed
    */
    public function insert(array $attributes, string $table);





    /**
     * Update records
     *
     * @param array $attributes
     * @param string $table
     * @return mixed
    */
    public function update(array $attributes, string $table);






    /**
     * Delete records
     *
     * @param $table
     * @return mixed
    */
    public function delete($table);
}
