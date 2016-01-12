<?php

class RequisitionCommentService
{
	public $connection;

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Requisition Comment
	 *
	 * @param Array $data
	 */
	public function saveComment($data)
	{
		$sql = "
			INSERT
				INTO
					`requisition_comments`
					(`user_id`, `requisition_id`, `comment`, `datetime_added`)
				VALUES
					(".$data['user_id'].",".$data['requisition_id'].", '".$data['comment']."', '".$data['datetime_added']."')
		";

		$this->connection->query($sql);

		return mysqli_insert_id($this->connection);
	}

}

?>