package com.concessionaria.repository;


import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import com.concessionaria.models.Veiculo;

public interface VeiculoRepository extends JpaRepository<Veiculo, Long> {
	
	List<Veiculo> findByTipo(String tipo);
	
	
	
	@Query(nativeQuery = true, value ="SELECT * FROM Veiculo order by rand() limit :limit")
	 List<Veiculo> encontrar(@Param("limit") int limit);
	

	

	
}
