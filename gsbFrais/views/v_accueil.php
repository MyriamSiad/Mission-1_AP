
<!-- SCRIPT JAVA -->


<script>

  // Fonction verifier si ISSET 

  function verifier()
  {
    // Ici on empêche l'envoie du Formulaire tant que ces champs 
    // ne sont pas remplis, pour empecher toute erreur
 
    function validerFormulaire(event) {
            // Récupérer les champs du formulaire
            const mois = document.getElementById('PeriodeM').value;
           
            const messageErreur = document.getElementById('erreur-message');

            // Réinitialiser le message d'erreur
            messageErreur.innerHTML = '';
            messageErreur.style.color = 'red';

            // Valider si les champs ne sont pas vides
            if (mois === '') {
                // Empêcher l'envoi du formulaire
                event.preventDefault();
                // Afficher un message d'erreur
                messageErreur.innerHTML = 'Veuillez remplir tous les champs obligatoires !';
                return false; // On empêche l'envoi
            }

            // Si tout est bon, laisser le formulaire s'envoyer
            return true;
        }
      }
    </script>
    

<!-- j'ai décidé de mettre les inputs Visiteur et Année en readonly, pour 
 empeché que une personne se fasse passé pour une autre 
 et rendre le formulaire plus rapide à l'utilisation avec des 
 champs pré-enregistrer et une année qui correspond que à l'année actuel 
 avec la fonction date("y")-->
<div id="accueil">
    <h1>Gestion des Frais</h1>
    <form   name ="formulaire" method="POST" action="index.php?uc=gestionFrais&action=gestionnaireFrais"
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
   <h3>Frais au Forfait</h3>
  
   <!--Repas Midi -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="RepasM">Repas Midi :  </label>
    <br>
    <?php if (!empty($rep)){echo($rep);}?>
    <input type="number" id="Repas" name ="REP" class="form-control" value=0 />
   </div>

   <!--Nuités -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Nuites">Nuités : </label>
    <br>
    <?php if (!empty($nui)){echo($nui);}?>
    <input type="number" id="Nuites" name ="NUI" class="form-control"  value=0  />
   </div>

   <!--Etape -->
   <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Etape">Etape : </label>
    <br>
    <?php if (!empty($etp)){echo($etp);}?>
    <input type="number" id="Etape" name ="ETP" class="form-control"  value=0  />
   </div>

     <!--Km -->
     <div data-mdb-input-init class="form-outline mb-4">
    <label class="form-label" for="Km">Km : </label>
    <br>
    <?php if (!empty($kmm)){echo($kmm);}?>
    <input type="number" id="Km" name = "KM" class="form-control"  value=0  />
   </div>


  </div>

  <!-- Submit button -->
  <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Valider</button>
</form>



</div>
