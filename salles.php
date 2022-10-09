 

	<main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid">
	
<?php
			$req3 = $DB->query('SELECT * FROM bg_salles a, bg_droits b WHERE a.salle_id = b.salle_id AND id_client='.$iduser);
			while ($val = $req3->fetch(PDO::FETCH_ASSOC)) { 
					$etat=($val["etat"]=="actif") ? "on" : "off";
					$coul=($val["etat"]=="actif") ? "green" : "red";
			?> 

			<div class="mdl-cell mdl-cell--4-col mdl-card mdl-shadow--2dp">
			  <div class="mdl-card__title">
				<h2 class="mdl-card__title-text"><?php  echo $val["salle_nom"];  ?></h2>
			  </div>

			  
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			  <div class="mdl-tabs__tab-bar">
				  <a href="#infos" class="mdl-tabs__tab is-active">Infos</a>
				  <a href="#perms" class="mdl-tabs__tab">Permissions</a>
			  </div>
			  <div class="mdl-tabs__panel is-active" id="infos">
				<div class="mdl-card__supporting-text">
				  <img src="<?php  echo $val["logo_url"];  ?>" width="100px" height="65px" style="float:left; margin:5px;">
					<p>
						<b>ID salle:</b> <?php  echo $val["salle_id"];  ?><br>
						<b>Adresse:</b> <?php  echo $val["salle_adr"];  ?><br>		
						<b>Gérant:</b> <?php  echo $val["nom_gerant"];  ?><br>
						<b>Mail gérant:</b> <?php  echo $val["mail_gerant"];  ?>
					</p>
				</div>
			  </div>
			  
			  <div class="mdl-tabs__panel" id="perms">
						  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							  <tbody>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Accès gérant</td>
								  <td>
									<label data-val=<?php echo $val["salle_id"]; ?> for="read<?php echo $val["salle_id"]; ?>" class="mdl-switch mdl-js-switch mdl-js-ripple-effect">
									  <input type="checkbox" id="read<?php echo $val["salle_id"]; ?>" class="mdl-switch__input" <?php if($val["read1"]==1) echo "checked" ?>>
									  <span class="mdl-switch__label"></span>
									</label>
								  </td>
								  <td>Autorise le gérant à voir les permissions de sa structure</td>
								</tr>							  						  
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 1</td>
								  <td>
									<label id="per1" data-val=<?php echo $val["client_id"]; ?> for="perm1" class="mdl-radio mdl-js-radio mdl-js-ripple-effect">
									  <input type="radio" id="perm1" class="mdl-radio__button" value="off" <?php if($val["perm1"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 2</td>
								  <td>
									<label id="per2" data-val=<?php echo $val["client_id"]; ?> for="perm2" class="mdl-radio mdl-js-radio mdl-js-ripple-effect ">
									  <input type="radio" id="perm2" class="mdl-radio__button" <?php if($val["perm2"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 3</td>
								  <td>
									<label id="per3" data-val=<?php echo $val["client_id"]; ?> for="perm3" class="mdl-radio mdl-js-radio mdl-js-ripple-effect ">
									  <input type="radio" id="perm3" class="mdl-radio__button" <?php if($val["perm3"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 4</td>
								  <td>
									<label id="per4" data-val=<?php echo $val["client_id"]; ?> for="perm4" class="mdl-radio mdl-js-radio mdl-js-ripple-effect ">
									  <input type="radio" id="perm4" class="mdl-radio__button" <?php if($val["perm4"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 5</td>
								  <td>
									<label id="per5" data-val=<?php echo $val["client_id"]; ?> for="perm5" class="mdl-radio mdl-js-radio mdl-js-ripple-effect ">
									  <input type="radio" id="perm5" class="mdl-radio__button" <?php if($val["perm5"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
								<tr>
								  <td class="mdl-data-table__cell--non-numeric">Perm 6</td>
								  <td>
									<label id="per6" data-val=<?php echo $val["client_id"]; ?> for="perm6" class="mdl-radio mdl-js-radio mdl-js-ripple-effect ">
									  <input type="radio" id="perm6" class="mdl-radio__button" <?php if($val["perm6"]==1) echo "checked" ?> disabled>
									  <span class="mdl-radio__label"></span>
									</label>
								  </td>
								  <td>détails permission</td>
								</tr>
							  </tbody>
							</table>
			  
			  
			  </div>
			</div>			  

			  <div class="mdl-card__menu">
				<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
				  <i class="material-icons toggle-icon-<?php echo $coul ?>">toggle_<?php echo $etat ?></i>
				</button>
			  </div>
			</div>			
			<?php } ?>					

		  
          <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--8-col">
          </div>

        </div>
      </main>
 