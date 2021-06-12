package com.concessionaria.repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.concessionaria.models.Marca;

public interface MarcaRepository extends JpaRepository<Marca, Long> {

}
