package com.concessionaria.controllers;




import javax.websocket.server.PathParam;

import org.springframework.beans.factory.annotation.Autowired;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import com.concessionaria.repository.CorRepository;
import com.concessionaria.repository.MarcaRepository;
import com.concessionaria.repository.VeiculoRepository;
import com.concessionaria.services.VeiculosServices;

@Controller
public class IndexController {
	
	@Autowired
	private VeiculosServices services;
	
	@Autowired
	private VeiculoRepository repo;
	
	@Autowired
	private CorRepository corRepo;
	
	@Autowired
	private MarcaRepository marcaRepo;
	
	@RequestMapping("/")
	public String index(Model model) {
		model.addAttribute("listVeiculos", services.listAll());
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());
		return "index";
	}
	
	@RequestMapping("sobre")
	public String sobre(Model model) {
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());
		return "/main/sobre";
	}
	
	@RequestMapping("/main/{type}")
	public String dinamic(@PathVariable String type , Model model) {
		model.addAttribute("listVeiculos", repo.porTipo(type)); 
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());
		
		
		return "main/type";
	}
	
	@RequestMapping("/obj")
	public String detalhes(@PathParam(value = "id") Long id, Model model) {
		model.addAttribute("obj", repo.getById(id));
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());

		return "main/detalhes";
	}
	@RequestMapping("/cv")
	public String porcor(@PathParam(value="id")Long id, Model model) {
		model.addAttribute("cv", repo.porCor(id));
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());
		
		return "main/veiculoCor";
	}
	
	@RequestMapping("/mv")
	public String pormarca(@PathParam(value="id")Long id, Model model) {
		model.addAttribute("mv", repo.porMarca(id));
		model.addAttribute("listCor", corRepo.findAll());
		model.addAttribute("listMarca", marcaRepo.findAll());
		
		return "main/veiculoMarca";
	}
}	
