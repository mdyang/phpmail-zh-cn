<?php

interface AbstractPersistence{
	
	public function create($entity);
	
	public function update($entity);
	
	public function delete($tid);
	
	public function find($tid);
	
	public function findAll();
	
}

?>