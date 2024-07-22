<?php 

require "./template/header.php";
require "./lib/pdo.php";

// Récupère les lignes des trois tables nécessaires, puis les combine
$sql = "SELECT habitats.id AS habitat_id, habitats.name AS habitat_name, habitats.description AS habitat_description, habitats.picture AS habitat_picture,
            animals.id AS animal_id, animals.name AS animal_name, animals.race AS animal_race, animals.picture AS animal_picture,
            reports.state AS animal_state
    FROM habitats
    LEFT JOIN animals ON habitats.name = animals.habitat
    LEFT JOIN reports ON animals.id = reports.animal_id
    ORDER BY habitats.id, animals.id;";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation tableau données par habitat
$habitats = [];

foreach ($results as $row) {
    
    $habitat_id = $row['habitat_id'];
    // Données habitat, initialisation tableau vide pour animaux
    if (!isset($habitats[$habitat_id])) {
        
        $habitats[$habitat_id] = [
            'name' => $row['habitat_name'],
            'description' => $row['habitat_description'],
            'picture' => $row['habitat_picture'],
            'animals' => []
        ];
    }
    // Données animaux dans habitat correspondant
    if ($row['animal_id'] !== null) {
        
        $habitats[$habitat_id]['animals'][$row['animal_id']] = [
            'name' => $row['animal_name'],
            'race' => $row['animal_race'],
            'picture' => $row['animal_picture'],
            'state' => $row['animal_state']
        ];
    }
}

// Variables pour appliquer classes CSS
$habitatClass = '';
$accordclass = '';
$bodyClass = '';
$animalClass = '';

?>
<main>
    <!-- Bandeau page-->
    <section>
        <div class="presentation-habitats">
            <h1 class="text-center">Découvrez les habitats et leurs habitants</h1>
        </div>
    </section>
    <!--Cards habitats-->
    <section>
        <div class="container habitats">
            <div class="container-card text-center mt-5">
                <div class="row">
                    <?php foreach ($habitats as $habitat_id => $habitat) { ?>
                        
                        <?php if ($habitat['name'] == 'savane') { 
                                    $habitatClass = 'habitat-savane';
                                } else if ($habitat['name'] == 'marais') { 
                                    $habitatClass = 'habitat-marais'; 
                                } else if ($habitat['name'] == 'jungle') { 
                                    $habitatClass = 'habitat-jungle'; 
                                } else {
                                    $habitatClass = 'habitat-marais'; 
                                } ?>
                        <div class="col-12 my-4 d-flex justify-content-center" id="heading<?= $habitat_id ?>">
                            <!-- Début cards -->
                            <div class="card <?= $habitatClass ?>">
                                <img src="<?= htmlspecialchars($habitat['picture']) ?>" class="card-img-top image" alt="<?= htmlspecialchars($habitat['name']) ?>"  data-bs-toggle="collapse" data-bs-target="#collapse<?= $habitat_id ?>"  role="button" aria-controls="collapse<?= $habitat_id ?>" tabindex="0">
                                <div class="card-body ">
                                    <h2 class="card-title text-center"><?= htmlspecialchars($habitat['name']) ?></h2>
                                    <div class="collapse" id="collapse<?= $habitat_id ?>" aria-labelledby="heading<?= $habitat_id ?>" data-bs-parent="#accordionExample">
                                        <div class="collapse-habitats">
                                            <div class="container">
                                                <div class="fs-5">
                                                    <p class="habitats-text"><?= htmlspecialchars($habitat['description']) ?></p>
                                                </div>
                                                <div class="row">
                                                    <?php foreach ($habitat['animals'] as $animal_id => $animal) { ?>
                                                        
                                                        <?php if ($habitat['name'] == 'savane') { 
                                                                $accordclass = 'accordion-button-savane'; 
                                                                $bodyClass = 'savane-body'; 
                                                                $animalClass = 'animal-savane'; 
                                                            } else if ($habitat['name'] == 'marais') { 
                                                                $accordclass = 'accordion-button-marais'; 
                                                                $bodyClass = 'marais-body'; 
                                                                $animalClass = 'animal-marais'; 
                                                            } else if ($habitat['name'] == 'jungle') { 
                                                                $accordclass = 'accordion-button-jungle'; 
                                                                $bodyClass = 'jungle-body'; 
                                                                $animalClass = 'animal-jungle'; 
                                                            } else { 
                                                                $accordclass = 'accordion-button-marais'; 
                                                                $bodyClass = 'marais-body'; 
                                                                $animalClass = 'animal-marais'; 
                                                            } ?>
                                                        <div class="col-12 col-md-6 col-lg-4">
                                                            <div class="card <?= $animalClass ?>">
                                                                <img src="<?= htmlspecialchars($animal['picture']) ?>" class="card-img-top" alt="<?= htmlspecialchars($animal['race']) ?>">
                                                                <div class="card-body">
                                                                    <!-- Début accordéons animaux -->
                                                                    <div class="accordion" id="<?= 'accordion'.htmlspecialchars($animal['name']) ?>">
                                                                        <div class="accordion-item">
                                                                            <div class="accordion-header">
                                                                            <button class="accordion-button fs-2 <?= $accordclass ?>" data-animal-id="<?= $animal_id ?>" data-bs-toggle="collapse" data-bs-target="<?= '#collapse'.htmlspecialchars($animal['name']) ?>" aria-expanded="true" aria-controls="collapseAnimals" type="button" tabindex="0">
                                                                            <?= htmlspecialchars($animal['name']) ?>
                                                                            </button>
                                                                        </div>
                                                                            <div id="<?= 'collapse'.htmlspecialchars($animal['name']) ?>" class="accordion-collapse collapse" data-bs-parent="<?= '#accordion'.htmlspecialchars($animal['name']) ?>">
                                                                                <div class="accordion-body <?= $bodyClass ?>">
                                                                                    <ul class="text-start">
                                                                                        <li>
                                                                                            <p>Race : <?= htmlspecialchars($animal['race']) ?></p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <p>Etat de l'animal : <?= htmlspecialchars($animal['state']) ?></p>
                                                                                        </li>
                                                                                        
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Fin accordéons animaaux -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Fin card -->
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Enregistrer clics animaux -->
<script>
document.querySelectorAll('.accordion-button').forEach(button => {
    button.addEventListener('click', () => {
        const animalId = button.getAttribute('data-animal-id');
        const animalName = button.textContent.trim();

        // Envoi une requête HTTP à 'register_click.php'
        fetch('register_click.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            // Corps de la requête, conversion en chaîne JSON
            body: JSON.stringify({ animal_id: animalId, animal_name: animalName })
        })
        .then(response => response.json())
    });
});
</script>
<?php require "/template/footer.php"; ?>