
<!-- SCRIPT JAVA -->


<script>

  // Fonction verifier si ISSET 

  function verifier()
  {
    let x = document.forms["formulaire"] ["idVisiteur"].value;

    if(x=="")
  {
    let str = ("Veuillez remplir le champ id")
    return str;
  }
  }
  document.write("hello");
</script>

<div id="accueil">
    <h1>Gestion des Frais</h1>
    <form   name ="formulaire" method="POST" action="index.php?uc=gestionFrais&action=gestionnaireFrais"
    onsubmit="return verifier()">


   
    <!-- Saisi -->
   <h3>Saisie</h3>
  <!-- Numéro Visiteur -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
       
        <!-- Numéro -->
      <label class="form-label" for="visiteur"> Visiteur Numéro : </label>
        <input type="text" id="NumeroV" name ="idVisiteur" class="form-control" />
      </div>
    </div>
    
  </div>

  <!-- Période d'engagement-->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="Periode">Periode d'engagement :</label>
   <!--Mois-->
    <br>Mois (2 chiffres)
    <input type="text" id="PeriodeM" name ="mois" class="form-control" />
     <!-- Année -->
    <label class="form-label" for="PeriodeA">Année ( 4 chiffres)</label>
    <input type="text" id="PeriodeA"  name = "annee"class="form-control" />    
  </div>

 
   <!-- Frais Forfait  -->
   <h3>Frais au Forfait</h3>
  
   <!--Repas Midi -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="RepasM">Repas Midi :  </label>
    <br>
    <?php if (!empty($rep)){echo($rep);}?>
    <input type="number" id="Repas" name ="REP" class="form-control" />
   </div>

   <!--Nuités -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Nuites">Nuités : </label>
    <br>
    <?php if (!empty($nui)){echo($nui);}?>
    <input type="number" id="Nuites" name ="NUI" class="form-control" />
   </div>

   <!--Etape -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Etape">Etape : </label>
    <br>
    <?php if (!empty($etp)){echo($etp);}?>
    <input type="number" id="Etape" name ="ETP" class="form-control" />
   </div>

     <!--Km -->
     <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Km">Km : </label>
    <br>
    <?php if (!empty($kmm)){echo($kmm);}?>
    <input type="number" id="Km" name = "KM" class="form-control" />
   </div>


  </div>

  <!-- Submit button -->
  <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Valider</button>
</form>



</div>
