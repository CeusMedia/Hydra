<?php
class Model_ModuleSource{

	protected $data;
	protected $fileName;

	public function __construct( $env ){
		$this->env		= $env;
		$this->fileName	= 'config/modules/sources.json';

		if( !file_exists( dirname( $this->fileName ) ) ){
			FS_Folder_Editor::createFolder( dirname( $this->fileName ), 0770 );
		}
		if( !file_exists( $this->fileName ) ){
			touch( $this->fileName );
			chmod( $this->fileName, 0770 );
		}
		$json		= FS_File_Reader::load( $this->fileName );
		$this->data	= json_decode( $json, TRUE );
	}

	public function add( $data ){
		if( empty( $data['id'] ) || !strlen( trim( $data['id'] ) ) )
			throw new InvalidArgumentException( 'Source data is missing an source ID' );
		$id		= trim( $data['id'] );
		unset( $data['id'] );
		$this->data[$id]	 = $data;
		$this->save();
		return $id;
	}

	public function changeId( $from, $to ){
		$data	= $this->data[$from];
		unset( $this->data[$from] );
		$this->data[$to]	= $data;
		return (boolean) $this->save();
	}

	public function count(){
		return count( $this->data );
	}
	
	public function edit( $id, $data ){
		$old		= $this->data[$id];
		foreach( $data as $key => $value )
			$this->data[$id][$key]	= $value;
		if( $old != $this->data[$id] )
			return (boolean) $this->save();
		return FALSE;
	}

	public function get( $id ){
		if( !$this->has( $id ) )
			return NULL;
		$data	= $this->data[$id];
		return (object) $data;
	}

	public function getAll( $activeOnly = TRUE ){
		$list		= array();
		foreach( $this->data as $id => $data ){
			if( !$activeOnly || !empty( $data['active'] ) )
				$list[$id]	= (object) $this->data[$id];
		}
		return $list;
	}

	public function has( $id, $key = NULL ){
		if( !isset( $this->data[$id] ) )
			return FALSE;
		if( $key )
			return isset( $this->data[$id][$key] );
		return TRUE;
	}

	public function remove( $id ){
		unset( $this->data[$id] );
		$this->save();
	}

	protected function save(){
		$json	= ADT_JSON_Formater::format( json_encode( $this->data ) );
		return FS_File_Writer::save( $this->fileName, $json );
	}
}
?>