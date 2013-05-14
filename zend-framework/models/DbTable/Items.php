<?php

class Application_Model_DbTable_Items extends Zend_Db_Table_Abstract

{
    protected $_name = 'items';
    
    public function getItem($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = '.$id);
		if (!$row) {
			return false;
		}
		return $row->toArray();
	}
	
	public function ingresoItem($materia_asegurada, $asegurado_id)
	{
		$data = array(
			'materia_asegurada' =>	$materia_asegurada,
			'asegurado_id' 		=>	$asegurado_id
		);
		return $this->insert($data);
	}
	
	public function reingresoItem($id, $materia_asegurada, $asegurado_id)
	{
		$data = array(
			'id' 				=>	$id,
			'materia_asegurada' =>	$materia_asegurada,
			'asegurado_id' 		=>	$asegurado_id
		);
		$this->update($data);
	}
	
	public function addItem($id, $materia_asegurada, $direccion, $ocupacion, $comuna_id, $ubicacion, $uso, $tipo, $deducible, $unit_id, $asegurado_id)
	{
		$data = array(
			'id' 				=>	$id,
			'materia_asegurada' =>	$materia_asegurada,
			'direccion' 		=>	$direccion,
			'ocupacion' 		=>	$ocupacion,
			'comuna_id' 		=>	$comuna_id,
			'ubicacion'		    =>	$ubicacion,
			'uso' 				=>	$uso,
			'tipo' 				=>	$tipo,
			'deducible' 		=>	$deducible,
			'unit_id' 			=>	$unit_id,
			'asegurado_id' 		=>	$asegurado_id,
										

		);
		$this->insert($data);
	}
	
	public function updateItem($id, $materia_asegurada, $direccion, $ocupacion, $comuna_id, $ubicacion, $uso, $tipo, $deducible, $unit_id, $asegurado_id)
	{
		$data = array(
		'id' => $id,
			'id' 				=>	$id,
			'materia_asegurada' =>	$materia_asegurada ,
			'direccion' 		=>	$direccion,
			'ocupacion' 		=>	$ocupacion,
			'comuna_id' 		=>	$comuna_id,
			'ubicacion'		    =>	$ubicacion,
			'uso' 				=>	$uso,
			'tipo' 				=>	$tipo,
			'deducible' 		=>	$deducible,
			'unit_id' 			=>	$unit_id,
			'asegurado_id' 		=>	$asegurado_id,		
		);
		$this->update($data, 'id='.(int)$id);
	}
	
	public function deleteItem($id) {
		$this->delete('id='.$id);
	}

}
?>


	
	
	
	
    
    
    
    
    


    
}

