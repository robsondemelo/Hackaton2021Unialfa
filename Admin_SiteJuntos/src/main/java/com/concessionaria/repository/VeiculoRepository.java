package com.concessionaria.repository;


import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import com.concessionaria.models.Veiculo;

public interface VeiculoRepository extends JpaRepository<Veiculo, Long> {
	
	
	
	
	@Query(nativeQuery = true, value ="SELECT * FROM Veiculo order by rand() limit :limit")
	 List<Veiculo> encontrar(@Param("limit") int limit);
	
	@Query(nativeQuery = true, value ="SELECT * FROM Veiculo where cor_id = :id")
	 List<Veiculo> porCor(@Param("id") Long id);
	
	@Query(nativeQuery = true, value ="SELECT * FROM Veiculo where tipo = :tipo")
	 List<Veiculo> porTipo(@Param("tipo") String tipo);

	@Query(nativeQuery = true, value ="SELECT * FROM Veiculo where marca_id = :id")
	 List<Veiculo> porMarca(@Param("id") Long id);

}
