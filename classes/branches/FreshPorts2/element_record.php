<?php
	#
	# $Id: element_record.php,v 1.1.2.1 2003-09-24 16:43:29 dan Exp $
	#
	# Copyright (c) 1998-2003 DVL Software Limited
	#


// base class used for resolving URI
class ElementRecord {

	var $dbh;

	var $id;
	var $name;
	var $type;
	var $status;
	var $iscategory;
	var $isport;

	var	$element_pathname;

	function ElementRecord($dbh) {
		$this->dbh = $dbh;
	}

	function PopulateValues($myrow) {
		$this->id			= $myrow['id'];
		$this->name			= $myrow['name'];
		$this->type			= $myrow['type'];
		$this->status		= $myrow['status'];
		$this->iscategory	= $myrow['iscategory'];
		$this->isport		= $myrow['isport'];
	}

	function FetchByName($Name) {
		if (IsSet($Name)) {
			$this->element_pathname = $Name;
			UnSet($this->id);
		}
		$sql = "select * from elementGet('$Name')";

		$result = pg_exec($this->dbh, $sql);
		if ($result) {
			$numrows = pg_numrows($result);
			if ($numrows == 1) {
				$myrow = pg_fetch_array ($result, 0);
				$this->PopulateValues($myrow);
			}
		}

		return $this->id;
	}
}
