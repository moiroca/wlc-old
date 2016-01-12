<?php

class RequisitionComments extends Base
{
	
	/**
	 * Get All Requisition Comments By Requisition Id
	 *
	 * @param Int $id
	 */
	public function getAllRequisitionCommentsByRequisitionId($id)
	{
		$sql = "
			SELECT 
				`requisition_comments`.`comment` as requisition_comment,
				`requisition_comments`.`datetime_added` as comment_datetime_added,
				`users`.`firstname` as user_firstname,
				`users`.`lastname` as user_lastname
			FROM
				`requisition_comments`
			JOIN
				`users`
			ON
				`users`.`id` = `requisition_comments`.`user_id`
			WHERE
				`requisition_comments`.`requisition_id` = $id
		";

		return $this->raw($sql);
	}
}

?>