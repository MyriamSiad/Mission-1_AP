<?php $idVisiteur = $_SESSION['idVisiteur']?>;
<div id="accueil">
    <h1>Gestion des Frais Hors Forfait</h1>
    <form   name ="formulaire" method="POST" action="index.php?uc=gestionhorsfrais&action=gestionnairehorsfrais"
    onsubmit="validerFormulaire(event)">


   
    <!-- Saisi -->
   <h3>Saisie</h3>
  <!-- Numéro Visiteur -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
       
        <!-- Numéro -->
      <label class="form-label" for="visiteur"> Visiteur Numéro : </label>
        <input readonly id="NumeroV" name ="idVisiteur" class="form-control"  value="<?php echo($idVisiteur);?>" />
      </div>
    </div>
    
  </div>

  <!-- Période d'engagement-->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="Periode">Periode d'engagement :</label>
   <!--Mois-->
    <br>Mois (2 chiffres)
    <input type="text"  required = "required" id="PeriodeM" name ="mois" class="form-control" />
    <p id="erreur-message"></p>
     <!-- Année -->
    <label class="form-label" for="PeriodeA">Année ( 4 chiffres)</label>
    <input readonly id="PeriodeA"  name = "annee"class="form-control" value ="<?= date("Y") ?>"  />    
  </div>

 
   <!-- Frais Forfait  -->
   <h3>Frais au Hors Forfait</h3>
  
   <!--Repas Midi -->
<select name ="libelle" >
    <?php foreach ($libelle as $lib): ?>
        <option value="<?= htmlspecialchars($lib['libelle']); ?>">
            <?= htmlspecialchars($lib['libelle']); ?>
        </option>
    <?php endforeach; ?>
</select>
 
   


   <!--Nuités -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Nuites">Montant </label>
    <br>
    <?php if (!empty($montant)){echo($montant);}?>
    <input type="number" id="montant" name ="montant" class="form-control"  value=0  />
   </div>

  </div>

  <!-- Submit button -->
  <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Valider</button>
</form>

</div>

</div>
