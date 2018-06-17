<?php 
	include_once '../../app/connection/Connection.php';
	include_once '../../app/funcoes.php';
	include_once '../../app/models/Aluno.php';
	include_once '../../app/models/Curso.php';

	//Não permite que usário entrem na página sem fazer login
	include_once '../templates/includes/header.php'; 

	$permissoes = ['admin', 'professor', 'coordenador'];

	verificarAcesso($permissoes);

	
	$cursos = listarCursos();

	if(isset($_POST['btnProcurar'])){
		
		$nome = filter_input(INPUT_POST, 'nome');
		$curso = filter_input(INPUT_POST, 'curso');

		if($curso != 0){
			@$alunos = buscarAlunoCurso($nome, $curso);
		}else{
			@$alunos = buscarAlunoNome($nome);
		}

	}else{
		$alunos = listarAlunos();
	}


?>

<h1>Alunos</h1>

<form method="POST" action="">
	<input type="text" name="nome" placeholder="Nome Do Aluno" size="50px">

	<select name="curso">
		<option value="">Selecione um Curso(Não é obrigatório)</option>
		<?php foreach($cursos as $curso){ ?>
			<option value="<?= $curso['id'] ?>"><?= $curso['nome'] ?></option>
		<?php } ?>
	</select>

	<button type="submit" name="btnProcurar">Procurar</button>
</form>

<p></p>

<hr>

<table border="1" cellspacing="0" width="100%">
	
	<thead>
		<tr>
			<th width="15%">Matrícula</th>
			<th>Nome</th>
			<th>Curso</th>
			<th>Turno</th>
			<th>Ações</th>
		</tr>
	</thead>


	<tbody>
		<?php 
			if(!empty($alunos)){
				foreach($alunos as $aluno){
		?>

			<tr>
				<td align="center"><?= $aluno['matricula'] ?></td>
				<td align="center"><?= $aluno['nome'] ?></td>
				<td align="center"><?= traduzirId($aluno['id_curso']) ?></td>
				<td align="center"><?= $aluno['turno'] ?></td>
				<td align="center" width="30%">
					<?= ($_SESSION['usuario_logado']['nv_acesso'] != "professor") ? "<a href='dados-aluno.php?id=".$aluno['id']."'>Ver Mais</a> |" : "" ?>
					<a href="#">Adicionar Nota</a> 
					<?= ($_SESSION['usuario_logado']['nv_acesso'] != "professor") ? "| <a href='#'>Boletim</a> |" : "" ?>
					<?= ($_SESSION['usuario_logado']['nv_acesso'] != "professor") ? "<a href='novo-editar-aluno.php?id=".$aluno['id']."'>Editar</a> |" : "" ?>

					<?php if($_SESSION['usuario_logado']['nv_acesso'] != "professor"){ ?>
						<a href="#" onclick="confirmDelete()">Excluir</a>
						<form method="POST" action="../../app/routes.php" id="formDelete">
							<input type="hidden" name="acao" value="apagar-aluno">
							<input type="hidden" name="id" value="<?= $aluno['id'] ?>">
						</form>
					<?php } ?>
				</td>
			</tr>

		<?php } }else{ ?>

			<tr>
				<th colspan="5">Nenhum Aluno Cadastrado</th>
			</tr>

		<?php } ?>
	</tbody>

	<tfoot>
		<tr>
			<?php if($_SESSION['usuario_logado']['nv_acesso'] == "admin" || $_SESSION['usuario_logado']['nv_acesso'] == "coordenador"){ ?>
				<td align="center" colspan="5"><a href="novo-editar-aluno.php">Novo Aluno</a></td>
				
			<?php } ?>
		</tr>
	</tfoot>


</table>

<script type="text/javascript">
	function confirmDelete(){

		var msg = confirm("Realmente deseja apagar os dados desse aluno?");

		if(msg){
			document.getElementById("formDelete").submit();
		}
	}
</script>


<?php include_once '../templates/includes/footer.php'; ?>