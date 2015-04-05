<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/synthesisController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Relev&eacute; des comptes</legend>
	<form class="form-inline" name="form_synthesis_date" id="form_synthesis_date" method="POST" action="synthesis.php">
		<legend>S&eacute;lectionnez vos dates de relev&eacute;</legend>
		<div class="form-group has-feedback" id="div_date_begin">
	    	<label for="date_begin">D&eacute;but : </label>
			<input type="text" placeholder="D&eacute;but" class="form-control" name="date_begin" id="date_begin" />
			<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_begin"></span>
		</div>
		<div class="form-group has-feedback" id="div_date_end">
	    	<label for="date_end">Fin : </label>
			<input type="text" placeholder="Fin" class="form-control" name="date_end" id="date_end" />
			<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_end"></span>
		</div>
		<button type="submit" class="btn btn-primary btn-sm" name="submit_new_customer_info" id="submit_new_customer_info"><span class="glyphicon glyphicon-calendar"></span> Voir</button>
	</form>
	<br /><br />
	<legend>Relev&eacute; de compte</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($movements as $key => $movement) {?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $key ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<?php $classContent = '' ?>
		<?php $j = 0 ?>
		<?php foreach ($movements as $key => $movement) {?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="table-responsive tab-pane <?php echo $classContent ?>" id="<?php echo $j ?>">
				<br /><br />
				<table class="table table-hover">
					<tr>
						<th>Date</th>
						<th>Utilisateur</th>
						<th>Intitul&eacute;</th>
						<th>Cat&eacute;gorie</th>
						<th>Montant</th>
						<th colspan="2">&nbsp;</th>
					</tr>
					<?php $total = 0 ?>
					<?php foreach ($movement as $m) { ?>
						<tr class="text-left" id="tr_<?php echo $m['id_movement'] ?>">
							<td>
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="date_<?php echo $m['id_movement'] ?>"><?php echo $m['date_movement'] ?></span>
								<?php if($m['monthly']){ ?>
									<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?> input_monthly" id="modify_date_begin_<?php echo $m['id_movement'] ?>" value="<?php echo $m['date_begin'] ?>" />
									<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?> input_monthly" id="modify_date_end_<?php echo $m['id_movement'] ?>" value="<?php echo $m['date_end'] ?>" />
								<?php }else { ?>
									<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_date_<?php echo $m['id_movement'] ?>" value="<?php echo $m['date_movement'] ?>" />
								<?php } ?>
							</td>
							<td class="text-left" <?php if (isset($m['color'])){ ?>style="background-color: <?php echo $m['color'] ?>"<?php } ?>>
								<span class="span_modify_user_<?php echo $m['id_movement'] ?>" id="user_<?php echo $m['id_movement'] ?>"><?php echo $m['name_user_account'] ?></span>
								<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_user_<?php echo $m['id_movement'] ?>" value="<?php echo $m['name_user_account'] ?>" />
							</td>
							<td class="text-left">
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="name_<?php echo $m['id_movement'] ?>"><?php echo $m['name_movement'] ?></span>
								<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_name_<?php echo $m['id_movement'] ?>" value="<?php echo $m['name_movement'] ?>" />
							</td>
							<td class="text-right">
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="category_<?php echo $m['id_movement'] ?>"><?php echo $m['movement_category'] ?></span>
								<select class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_category_<?php echo $m['id_movement'] ?>">
									<?php foreach ($categoryMovement as $c) echo '<option value="'.$c['id_category_movement'].'">'.$c['name_category_movement'].'</option>' ?>
								</select>
							</td>
							<td class="text-right <?php echo $m['color_debit'] ?>">
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="amount_<?php echo $m['id_movement'] ?>"><?php echo $m['amount'] ?></span>
								<input type="text" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_amount_<?php echo $m['id_movement'] ?>" value="<?php echo $m['amount'] ?>" />
							</td>
							<td class="cursor_pointer" id="modifier_<?php echo $m['id_movement'] ?>">
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" onclick="showModifyMovement('<?php echo $m['id_movement'] ?>');"><img src="img/modifier.png" width="16"/></span>
								<input type="button" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_valid_<?php echo $m['id_movement'] ?>" value="Valider" onclick="validModify('<?php echo $m['id_movement'] ?>', '<?php echo $m['monthly'] ?>');" />
							</td>
							<td class="cursor_pointer" id="supprimer_<?php echo $m['id_movement'] ?>">
								<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" onclick="deleteMovement('<?php echo $m['id_movement'] ?>');"><img src="img/supprimer.png" width="16" /></span>
								<input type="button" class="input_hidden input_hidden_<?php echo $m['id_movement'] ?>" id="modify_cancel_<?php echo $m['id_movement'] ?>" value="Annuler" onclick="cancelModify('<?php echo $m['id_movement'] ?>');" />
							</td>
						</tr>
						<script type="text/javascript">
							$(function() {
								 $(function() {
									$("#modify_date_begin_<?php echo $m['id_movement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });
								});
								 $(function() {
									$("#modify_date_end_<?php echo $m['id_movement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });
								});
								 $(function() {
									$("#modify_date_<?php echo $m['id_movement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });
								});
							});
						</script>
						<?php $total = ($m['debit'] == "1") ? (float)$total - (float)$m['calc_amount'] : (float)$total + (float)$m['calc_amount'] ?>
					<?php } ?>
				
					<tr>
						<td class="text-right" colspan="4">TOTAL DES MOUVEMENTS</td>
						<td class="text-right <?php if ((float)$total > 0){ ?>text-success<?php }else{ ?>text-danger<?php } ?>"><?php echo $total ?></td>
					</tr>
				</table>
			</div>
			<?php $j++ ?>
		<?php } ?>
	</div>
<script type="text/javascript">
	$(function() {
		 $(function() {
			$("#date_begin").datepicker();
		});
		 $(function() {
			$("#date_end").datepicker();
		});
	});
</script>
<?php include "footer.php" ?>