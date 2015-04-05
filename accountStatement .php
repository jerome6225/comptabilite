<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/js/includeMorris.php" ?>
<?php include dirname(__FILE__)."/controllers/accountStatementController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>
<!--<link rel="stylesheet" type="text/css" href="css/style.chartinator.css">-->
<script type="text/javascript" src="js/chartinator.min.js" ></script>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Synth&egrave;se des comptes</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($bilanUsersTotal as $key => $bilan){ ?>
			<?php $k = explode("*", $key); ?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $k[0] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>

	<div class="tab-content"><br /><br />
		<?php $classContent = '' ?>
		<?php $v = 0 ?>
		<?php foreach ($bilanUsersTotal as $key => $bilan){ ?>
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
								<section id="section_cat_<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>" class="col charts">
									<div class="wrapper">
								        <div class="col">
								            <table id="cat_<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>" class="pieChart data-table">
								                <caption>Pourcentage par cat&eacute;gorie</caption>
								                <tr>
								                    <th scope="col" data-type="string">Cat&eacute;gorie</th>
								                    <th scope="col" data-type="number">%</th>
								                </tr>
								                <tr>
								                    <td></td>
								                    <td align="right"></td>
								                </tr>
								            </table>
								        </div>
								        <div class="col">
								            <div id="columnChart" class="columnChart chart"></div>
								        </div>
								    </div>
								</section>
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
							<section id="section_credit_<?php echo $k[1] ?>_<?php echo $v ?>" class="col charts">
								<div class="wrapper">
							        <div class="col">
							            <table id="credit_<?php echo $k[1] ?>_<?php echo $v ?>" class="pieChart data-table">
							                <caption>Pourcentage Revenu</caption>
							                <tr>
							                    <th scope="col" data-type="string">Utilisateur</th>
							                    <th scope="col" data-type="number">%</th>
							                </tr>
							                <tr>
							                    <td></td>
							                    <td align="right"></td>
							                </tr>
							            </table>
							        </div>
							        <div class="col">
							            <div id="columnChart" class="columnChart chart"></div>
							        </div>
							    </div>
							</section>
						</div>
						<div class="col-sm-6">
							<section id="section_debit_<?php echo $k[1] ?>_<?php echo $v ?>" class="col charts">
								<div class="wrapper">
							        <div class="col">
							            <table id="debit_<?php echo $k[1] ?>_<?php echo $v ?>" class="pieChart data-table">
							                <caption>Pourcentage D&eacute;pense</caption>
							                <tr>
							                    <th scope="col" data-type="string">Utilisateur</th>
							                    <th scope="col" data-type="number">%</th>
							                </tr>
							                <tr>
							                    <td></td>
							                    <td align="right"></td>
							                </tr>
							            </table>
							        </div>
							        <div class="col">
							            <div id="columnChart" class="columnChart chart"></div>
							        </div>
							    </div>
							</section>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(function(){
					<?php foreach ($bilan as $j => $b){ ?>
						$('#cat_<?php echo $j ?>_<?php echo $k[1] ?>_<?php echo $v ?>').chartinator({
			                rows: [
			                    <?php foreach ($categoriesPercent[$key][$j] as $i => $c){ ?>
				    				["<?php echo utf8_decode(html_entity_decode($i)) ?>", <?php echo $c['percent'] ?>],
						    	<?php } ?>
						    	],
			                chartType: 'PieChart',
			                chartHeightRatio: 0.75,
			                pieChart: {
			                    width: 250,
			                    height: 250,
			                    chartArea: {
			                        left: "10%",
			                        top: 20,
			                        width: "100%",
			                        height: "100%"
			                    },
			                    fontSize: 'body',
			                    fontName: 'Roboto',
			                    title: '',

			                    titleTextStyle: {
			                        fontSize: 'h3'
			                    },
			                    legend: {
			                        position: 'in'
			                    },
			                    colors: [
				                    <?php foreach ($categoriesPercent[$key][$j] as $i => $c){ ?>
							    		"<?php echo $c['color'] ?>",
							    	<?php } ?>
						    	],
			                    is3D: true,
			                    tooltip: {
			                        trigger: 'focus'
			                    }
			                }
			            });

					<?php } ?>

					$('#credit_<?php echo $k[1] ?>_<?php echo $v ?>').chartinator({
			                rows: [
			                    <?php foreach ($bilan as $b){ ?>
					    			<?php if (!is_null ($b['name_user_account'])){ ?>
				    					["<?php echo $b['name_user_account'] ?>", <?php echo $b['percent_credit'] ?>],
						    		<?php } ?>
						    	<?php } ?>
						    	],
			                chartType: 'PieChart',
			                chartHeightRatio: 0.75,
			                pieChart: {
			                    width: 250,
			                    height: 250,
			                    chartArea: {
			                        left: "10%",
			                        top: 20,
			                        width: "100%",
			                        height: "100%"
			                    },
			                    fontSize: 'body',
			                    fontName: 'Roboto',
			                    title: '',

			                    titleTextStyle: {
			                        fontSize: 'h3'
			                    },
			                    legend: {
			                        position: 'in'
			                    },
			                    colors: [
				                    <?php foreach ($bilan as $b){ ?>
						     			<?php if (!is_null ($b['name_user_account'])){ ?>
							    			"<?php echo isset($b['color']) ? $b['color'] : '#000000' ?>",
							    		<?php } ?>
							    	<?php } ?>
						    	],
			                    is3D: true,
			                    tooltip: {
			                        trigger: 'focus'
			                    }
			                }
			            });

					$('#debit_<?php echo $k[1] ?>_<?php echo $v ?>').chartinator({
			                rows: [
			                    <?php foreach ($bilan as $b){ ?>
						    		["<?php echo (is_null($b['name_user_account'])) ? 'Tous' : $b['name_user_account'] ?>", <?php echo $b['percent_debit'] ?>],
						    	<?php } ?>
						    	],
			                chartType: 'PieChart',
			                chartHeightRatio: 0.75,
			                pieChart: {
			                    width: 250,
			                    height: 250,
			                    chartArea: {
			                        left: "10%",
			                        top: 20,
			                        width: "100%",
			                        height: "100%"
			                    },
			                    fontSize: 'body',
			                    fontName: 'Roboto',
			                    title: '',

			                    titleTextStyle: {
			                        fontSize: 'h3'
			                    },
			                    legend: {
			                        position: 'in'
			                    },
			                    colors: [
				                    <?php foreach ($bilan as $b){ ?>
							    		"<?php echo $b['color'] ?>",
							    	<?php } ?>
						    	],
			                    is3D: true,
			                    tooltip: {
			                        trigger: 'focus'
			                    }
			                }
			            });

				});
				</script>
			<?php $v++ ?>
		<?php } ?>
	</div>
</div>
<?php include "footer.php" ?>