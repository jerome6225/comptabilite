<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/js/includeMorris.php" ?>
<?php include dirname(__FILE__)."/controllers/prelevementMensuelController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<legend>D&eacute;pense mensuel</legend>
	<legend>Saisissez une somme pour les d&eacute;penses communes <span id="btn_form_prelevement" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
	<form class="sr-only" name="form_prelevement" id="form_prelevement" method="POST" action="prelevementMensuel.php">
		<div class="form-group has-feedback" id="div_somme">
	    	<label for="somme">Somme : </label>
			<input type="text" placeholder="Somme" class="form-control" name="somme" id="somme" />
			<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_somme"></span>
		</div>
		<button type="submit" class="btn btn-primary btn-sm" name="submit_form_prelevement" id="submit_form_prelevement"><span class="glyphicon glyphicon-credit-card"></span> Calculer</button>
	</form>
	<script type="text/javascript">
		$(function(){
			toggleForm('form_prelevement');
		});
	</script>
	<br /><br />
	<legend>D&eacute;pense mensuel par compte</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($categories as $key => $categorie){ ?>
			<?php $k = explode("*", $key); ?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $k[0] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<?php $classContent = '' ?>
		<?php $v = 0 ?>
		<?php foreach ($categories as $key => $categorie){ ?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="table-responsive tab-pane <?php echo $classContent ?>" id="<?php echo $v ?>">
				<br /><br />
				<table class="table table-hover">
					<tr>
						<th>&nbsp;</th>
						<th>Total des revenus</th>
						<th>Poucentage des revenus du compte</th>
						<th>Total des d&eacute;penses personnel</th>
						<th>Total des d&eacute;penses cumul&eacute;</th>
						<th>Total restant</th>
						<th>Total des d&eacute;penses</th>
						<th>Total somme en commun</th>
					</tr>
					<?php foreach ($categorie as $j => $c) { ?>
						<?php if ($j != 0){ ?>
							<tr>
								<td><?php echo (isset($c[0]['total_category_movement']['name'])) ? $c[0]['total_category_movement']['name'] : $c[1]['total_category_movement']['name'] ?></td>
								<td><?php echo $c[0]['total_category_movement']['amount'] ?> &euro;</td>
								<td><?php echo $c[0]['total_category_movement']['percent'] ?> %</td>
								<td><?php echo $c[1]['total_category_movement']['amount'] ?> &euro;</td>
								<td><?php echo $c[0]['total_category_movement']['totalPaid'] ?> &euro;</td>
								<td><?php echo $c[0]['total_category_movement']['rest'] ?> &euro;</td>
								<td>-</td>
								<td><?php echo (isset($c[0]['total_category_movement']['sommeCommun'])) ? $c[0]['total_category_movement']['sommeCommun'].' &euro;' : '-'; ?></td>
							</tr>
						<?php }else { ?>
							<tr>
								<td>Total en commun</td>
								<td><?php echo $c[0]['total_category_movement']['amount'] ?> &euro;</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td class="<?php if($c[0]['total_category_movement']['amount'] > $c[1]['total_category_movement']['amount']){ ?>text-success<?php }else{ ?>text-danger<?php } ?>"><?php echo $c[1]['total_category_movement']['amount'] ?> &euro;</td>
								<td><?php echo (isset($c[0]['total_category_movement']['totalCommun'])) ? $c[0]['total_category_movement']['totalCommun'].' &euro;' : '-'; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>
			</div>
			<?php $v++ ?>
		<?php } ?>
	</div>
</div>
<?php include "footer.php" ?>
