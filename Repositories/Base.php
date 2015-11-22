<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';

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

				foreach ($where as $column => $value) {
					$whereClause[] = "`$column`=$value";
				}

				$sql .= ' '.implode(',', $whereClause);
			}
		} else {
			$sql = 'SELECT * FROM '.$this->table;
		}

		$data = $this->connection->query($sql) or die(mysqli_error($this->connection));

		return $data->fetch_assoc();
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
		return $this->connection->query($sql);
	}
}

?>