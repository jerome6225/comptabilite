<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/js/includeMorris.php" ?>
<?php include dirname(__FILE__)."/controllers/synthesisController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>
<!--<link rel="stylesheet" type="text/css" href="css/style.chartinator.css">-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/attc.googleCharts.js" ></script>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Synth&egrave;se des comptes</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($bilanUsers as $key => $bilan){ ?>
			<?php $k = explode("*", $key); ?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $k[0] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>

	<div class="tab-content"><br /><br />
		<?php $classContent = '' ?>
		<?php $v = 0 ?>
		<?php foreach ($bilanUsers as $key => $bilan){ ?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="tab-pane <?php echo $classContent ?>" id="<?php echo $v ?>">
				<?php foreach ($bilan as $j => $b) { ?>
					<div class="row">
						<div class="table-responsive col-sm-6">
							<table class="table table-hover">
								<tr>
									<th colspan="2" <?php if (!is_null($b['color'])){echo 'style="color: '.$b['color'].';"';} ?>>
										<?php if (is_null($b['name_user_account'])){ echo 'tous les utilisateurs';} else {echo 'utilisateur '.$b['name_user_account'];} ?>
									</th>
								</tr>
								<tr>
									<td>Total d&eacute;bit </td>
									<td class="<?php if ((float)$b['total_debit'] < 0){ ?>text-danger<?php }else{ ?>text-success<?php } ?>"><?php echo $b['total_debit'] ?></td>
								</tr>
								<tr>
									<td>Total cr&eacute;dit </td>
									<td class="<?php if ((float)$b['total_credit'] < 0){ ?>text-danger<?php }else{ ?>text-success<?php } ?>"><?php echo $b['total_credit'] ?></td>
								</tr>
								<tr>
									<td>Total des mouvements </td>
									<td class="<?php if ((float)$b['total_amount'] < 0){ ?>text-danger<?php }else{ ?>text-success<?php } ?>"><?php echo $b['total_amount'] ?></td>
								</tr>
							</table>
						</div>
						<?php if ((float)$b['total_debit'] < 0){ ?>
							<div class="col-sm-6">
								<div id="cat_<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>" ></div>
							</div>
						<?php } ?>
					</div><br /><br />
				<?php } ?>
				<div class="row col-sm-12">
					<div class="table-responsive row col-sm-7">
						<table class="table table-hover">
							<!--<tr>
								<td>Solde au <?php //echo date("d-m-Y") ?></td>
								<td class="<?php //echo ((float)$accountsBalance[$k[1]]['current_balance'] < 0) ? 'text-danger' : 'text-success' ?>"><?php //echo $accountsBalance[$k[1]]['current_balance']; ?></td>
							</tr>-->
							<tr>
								<td>Solde &agrave; la fin du mois</td>
								<td class="<?php echo ((float)$accountsBalance[$k[1]]->balance_total < 0) ? 'text-danger' : 'text-success' ?>"><?php echo $accountsBalance[$k[1]]->balance_total; ?></td>
							</tr>
						</table>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div id="credit_<?php echo $k[1] ?>_<?php echo $v ?>"></div>
						</div>
						<div class="col-sm-6">
							<div id="debit_<?php echo $k[1] ?>_<?php echo $v ?>"></div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(function(){
					<?php foreach ($bilan as $j => $b){ ?>
						google.setOnLoadCallback(drawChart<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>);
						function drawChart<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>() {
							var data = google.visualization.arrayToDataTable([
								['Task', 'CATEGORIES'],
								<?php foreach ($categoriesPercent[$key][$j] as $i => $c){ ?>
									["<?php echo utf8_decode(html_entity_decode($i)) ?>", <?php echo $c['percent'] ?>],
								<?php } ?>
							]);

							var options = {
								title: 'DEPENSES PAR CATEGORIES',
								width: 450,
								height: 280,
								colors:[
								<?php foreach ($categoriesPercent[$key][$j] as $i => $c){ ?>
									"<?php echo $c['color'] ?>",
								<?php } ?>
								],
								is3D: true,
								legend: 'none',
								chartArea:{left:0,width:'85%',height:'85%'},
							};

		        			var chart = new google.visualization.PieChart(document.getElementById('cat_<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>'));

		        			chart.draw(data, options);
  						}
      				<?php } ?>
					
      				google.setOnLoadCallback(drawChart<?php echo $k[1] ?>_<?php echo $v ?>);
					function drawChart<?php echo $k[1] ?>_<?php echo $v ?>() {
						var data = google.visualization.arrayToDataTable([
							['Task', 'RECETTE'],
							<?php foreach ($bilan as $b){ ?>
								["<?php echo (is_null($b['name_user_account'])) ? 'Tous' : $b['name_user_account'] ?>", <?php echo $b['graph_credit'] ?>],
							<?php } ?>
						]);

						var options = {
							title: 'RECETTE',
							width: 450,
							height: 280,
							colors:[
							<?php foreach ($bilan as $b){ ?>
								"<?php echo (is_null($b['color'])) ? '#848484' : $b['color'] ?>",
							<?php } ?>
							],
							is3D: true,
							legend: 'none',
							chartArea:{left:0,width:'85%',height:'85%'},
						};

	        			var chart = new google.visualization.PieChart(document.getElementById('credit_<?php echo $k[1] ?>_<?php echo $v ?>'));

	        			chart.draw(data, options);
					}

					google.setOnLoadCallback(drawChart_<?php echo $k[1] ?>_<?php echo $v ?>);
					function drawChart_<?php echo $k[1] ?>_<?php echo $v ?>() {
						var data = google.visualization.arrayToDataTable([
							['Task', 'DEPENSE'],
							<?php foreach ($bilan as $b){ ?>
								["<?php echo (is_null($b['name_user_account'])) ? 'Tous' : $b['name_user_account'] ?>", <?php echo $b['graph_debit'] ?>],
							<?php } ?>
						]);

						var options = {
							title: 'DEPENSE',
							titleTextStyle: {align: 'center'},
							width: 450,
							height: 280,
							colors:[
							<?php foreach ($bilan as $b){ ?>
								"<?php echo (is_null($b['color'])) ? '#848484' : $b['color'] ?>",
							<?php } ?>
							],
							is3D: true,
							legend: 'none',
							chartArea:{left:0,width:'85%',height:'85%'},
						};

	        			var chart = new google.visualization.PieChart(document.getElementById('debit_<?php echo $k[1] ?>_<?php echo $v ?>'));

	        			chart.draw(data, options);
						}
				});
				</script>
			<?php $v++ ?>
		<?php } ?>
	</div>
</div>
<?php include "footer.php" ?>