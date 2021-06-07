<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listagem de Veiculos:</h3>

        <div class="float-right">
        	<a href="cadastros/veiculos" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/veiculos" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="card-body">
        <p>Resultados:</p>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="20%">Modelo</td>
                    <td width="10%">Marca</td>
                    <td width="10%">Cor</td>
                    <td width="10%">Ano Fabricação</td>
                    <td width="10%">Ano Modelo</td>
                    <td width="10%">Valor</td>
                    <td width="10%">Imagem</td>
                    <td width="10%">Opções</td>
                </tr>      
            </thead>
            <tbody>
                <?php

                    $sql = "select v.id, v.modelo, m.marca, c.cor, v.anofabricacao, v.anomodelo, v.valor, v.fotoDestaque 
                        from veiculo v
                        inner join cor c on ( c.id = v.cor_id )
                        inner join marca m on ( m.id = v.marca_id ) 
                        order by v.modelo";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                        $valor  = number_format( $dados->valor,2, ',' , '.' );
                        
                        $imagem = "../produtos/{$dados->fotoDestaque}p.jpg"; 
                        $imagemg = "../produtos/{$dados->fotoDestaque}g.jpg";

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->modelo?></td>
                            <td><?=$dados->marca?></td>
                            <td><?=$dados->cor?></td>
                            <td><?=$dados->anofabricacao?></td>
                            <td><?=$dados->anomodelo?></td>
                            <td><?=$valor?></td>
                            <td>
                                <a href="<?=$imagemg?>" data-lightbox="foto" title="<?=$dados->fotoDestaque?>">
                                    <img src="<?=$imagem?>" alt="<?=$dados->modelo?>" width="100px">
                                </a>
                            </td>
                            <td>
                                <a href="cadastros/veiculos/<?=$dados->id?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php

                    }
                ?>

            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function excluir(id) {

        Swal.fire({
          title: 'Deseja realmente excluir este registro?',
          showCancelButton: true,
          confirmButtonText: `Sim`,
          cancelButtonText: `Não`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            //enviar para excluir
            location.href='excluir/veiculos/'+id;
          } 
        })
    }
</script>
<script src="js/dataTable.js"></script>