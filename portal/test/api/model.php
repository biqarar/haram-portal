<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {

		// DB table to use
		$table = 'branch';

		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case object
		// parameter names
		$columns = array(
			array( 'db' => 'id',  'dt' => 'id' ),
			array( 'db' => 'name',   'dt' => 'name' ),
			array( 'db' => 'gender',     'dt' => 'gender' ),
			array(
				'db'        => 'id',
				'dt'        => 'id',
				'formatter' => function( $d, $row ) {
					return date( 'jS M y', strtotime($d));
				}
			),
			array(
				'db'        => 'id',
				'dt'        => 'id',
				'formatter' => function( $d, $row ) {
					return '$'.number_format($d);
				}
			)
		);

		// SQL server connection information
		$sql_details = array(
			'user' => 'root',
			'pass' => 'root',
			'db'   => 'quran_hadith',
			'host' => 'localhost'
		);


		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		 * server-side, there is no need to edit below this line.
		 */

		require( 'ssp.class.php' );
		// var_dump( $_POST, $sql_details, $table, $primaryKey, $columns );
		// var_dump(SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns ));
		// var_dump(2);
		// exit();
		// var_dump( $_POST, $sql_details, $table, $primaryKey, $columns );
		// echo json_encode(
		// 	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
		// );
		$ret =  json_encode(
			SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
		);
		echo $ret;
// debug_lib::msg($ret);
	}
}
 ?>