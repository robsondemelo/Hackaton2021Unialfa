package com.concessionaria.controllers;




import javax.websocket.server.PathParam;

import org.springframework.beans.factory.annotation.Autowired;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import com.concessionaria.repository.VeiculoRepository;
import com.concessionaria.services.VeiculosServices;

@Controller
public class IndexController {
	
	@Autowired
	private VeiculosServices services;
	
	@Autowired
	private VeiculoRepository repo;
	
	@RequestMapping("/")
	public String index(Model model) {
		model.addAttribute("listVeiculos", services.listAll());
		return "index";
	}
	
	@RequestMapping("sobre")
	public String sobre() {
		return "/main/sobre";
	}
	
	@RequestMapping("/main/{tipo}")
	public String dinamic(@PathVariable String tipo , Model model) {
		model.addAttribute("listVeiculos", repo.findByTipo(tipo)); 
		model.addAttribute("tipo", tipo);
		
		return "main/type";
	}
	
	@RequestMapping("/obj")
	public String detalhes(@PathParam(value = "id") Long id, Model model) {
		model.addAttribute("obj", repo.getById(id));

		return "main/detalhes";
	}
}	
