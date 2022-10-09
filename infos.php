
     <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
		<?php
		while ($val = $req2->fetch(PDO::FETCH_ASSOC)) { 
			$etat=($val["etat"]=="actif") ? "checked" : "";
			$coul=($val["etat"]=="actif") ? "green" : "red";
			$idperms=$val["perms_id"];
		?>
		  
            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
			
				<div class="mdl-card__menu">
					<label id="tt1" data-src="client" data-val=<?php echo $val["client_id"]; ?> for="etat" class="mdl-checkbox mdl-js-checkbox">
					  <input type="checkbox" name="etat" id="etat" class="mdl-checkbox__input" <?php echo $etat ?> disabled>
					  <span class="mdl-checkbox__label">Actif?</span>						  
					</label>
				</div>
				
			  <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text"><?php  echo $val["client_nom"];  ?></h2>
              </div>
			  
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
					  <span class="mdl-card__subtitle-text">
					  <img src="<?php  echo $val["logo_url"];  ?>" width="250px" height="175px" style="float:left; margin:5px;">
					  
					  </span>
						<ul class="demo-list-item mdl-list">
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  Directeur: <?php  echo $val["dpo"];  ?>
							</span>
						  </li>
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  Commercial: <?php  echo $val["comm"];  ?>
							</span>
						  </li>
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  Technicien: <?php  echo $val["tech"];  ?>
							</span>
						  </li>
						</ul>
						<p>En résumé : <?php  echo $val["resume"]; ?></p>
						<p>En détails: <?php  echo $val["description"];  ?></p>							

              </div>
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Voir plus</a>
              </div>
            </div>


            <div class="demo-options mdl-card mdl-color--deep-purple-500 mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--6-col-desktop">
              <div class="mdl-card__supporting-text mdl-color-text--blue-grey-50">
                <h5>Mes permissions par défaut:</h5>
				
						  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							  <tbody>
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

              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-grey-50">Changer</a>
                <div class="mdl-layout-spacer"></div>
                <i class="material-icons">location_on</i>
              </div>
            </div>
			
			<div class="demo-options mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--6-col-desktop">
			    <div class="mdl-card__supporting-text ">
					<h5>Infos techniques :</h5>
					
						<ul class="demo-list-control mdl-list">
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  <i class="material-icons  mdl-list__item-avatar">public</i>
							  <?php  echo $val["site_url"];  ?>
							</span>
							<span class="mdl-list__item-secondary-action">
								<button class="mdl-button mdl-js-button mdl-button--primary">
								  changer
								</button>
							</span>
						  </li>
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  <i class="material-icons  mdl-list__item-avatar">person</i>
							  <?php  echo $val["client_mail"];  ?>
							</span>
							<span class="mdl-list__item-secondary-action">
								<button class="mdl-button mdl-js-button mdl-button--primary">
								  changer
								</button>
							</span>
						  </li>
						  <li class="mdl-list__item">
							<span class="mdl-list__item-primary-content">
							  <i class="material-icons  mdl-list__item-avatar">key</i>
							  Changer mon mot de passe:
							</span>
							<span class="mdl-list__item-secondary-action">
								<button class="mdl-button mdl-js-button mdl-button--primary">
								  changer
								</button>
							</span>
						  </li>
						</ul>
			</div>
          </div>
        </div>
					<?php } ?>	
      </main>
    </div>
 