<?php 

require "./template/header.php"; 
require "./lib/pdo.php";

$sql = 'SELECT * FROM services';
try {
    $stmtServices = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$services = $stmtServices->fetchAll();

?>
    <main>
        <!-- Bandeau page-->
        <section>
            <div class="presentation-habitats">
                <h1 class="text-center">Découvrez tous les services proposés</h1>
            </div>
        </section>
        <!-- Début cards services-->
        <div class="container">
            <div class="container-card text-center mt-5">
                <div class="row">
                    <?php foreach ($services as $service) { ?>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="card h-100 card-services" style="width: 100%;">
                                <img src="<?= htmlspecialchars($service['picture']) ?>" class="card-img-top h-100" alt="Image du service">
                                <div class="card-body">
                                    <h2 class="text-center h3"><?= htmlspecialchars($service['name']) ?></h2>
                                    <p><?= htmlspecialchars_decode($service['description'], ENT_QUOTES) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div> 
            </div>
        </div>
        <!-- Fin cards services -->
    </main>
    <?php require "./template/footer.php" ?>