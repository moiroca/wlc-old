<?php 

Class Base {

	public $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Get All Data
	 *
	 * @param Array $columns
	 * @param Array $where
	 */
	public function getAll($columns = null, $where = null)
	{
		$sql = '';

		if ($columns) {
			$sql = 'SELECT '.implode(',', $columns).' FROM '.$this->table;

			if ($where) {

				$whereClause = [];
				$sql .= ' WHERE ';
				foreach ($where as $column => $value) {
					$whereClause[] = "`$this->table`.`$column`='$value'";
				}

				$sql .= ' '.implode(',', $whereClause);
			}
		} else {
			$sql = 'SELECT * FROM '.$this->table;
		}

		$data = $this->connection->query($sql);

		return $data;
	}

	/**
	 * Where Clause
	 *
	 * @param Array $parameters
	 *
	 * @return Array
	 */
	public function raw($sql)
	{
		return $this->connection->query($sql);// or die(mysqli_error($this->connection));
	}

	/**
	 * Update Function
	 *
	 * @param Array $set
	 * @param Array where
	 */
	public function update($set, $where)
	{
		$sql = "UPDATE $this->table SET ";

		$wherArray = [];
		$setArray = [];

		foreach ($set as $key => $value) {
			$setArray[] = "`$this->table`.`$key` = '".$value."' ";
		}

		$sql .= implode(', ', $setArray);
		$sql .= " WHERE ";

		foreach ($where as $key => $value) {
			$whereArray[] = "`$this->table`.`$key` = '".$value."' ";
		}

		$sql .= implode(', ', $whereArray);

		return $this->connection->query($sql) or die(mysqli_error($this->connection));
	}
}

?>