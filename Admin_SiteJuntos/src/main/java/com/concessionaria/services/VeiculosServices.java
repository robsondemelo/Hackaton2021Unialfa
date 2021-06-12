package com.concessionaria.services;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.concessionaria.models.Veiculo;
import com.concessionaria.repository.VeiculoRepository;

@Service
public class VeiculosServices {
	
	@Autowired
	private VeiculoRepository repo;
	
	public List<Veiculo> listAll(){
		return repo.encontrar(6);
	}
	
	
	

}
