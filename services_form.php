<!-- Début Formulaires CRUD Services -->
<div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Ajouter un service</h2>
                    <!--  le formulaire contient un file upload -->
                    <form action="services_crud.php" method="POST" enctype="multipart/form-data">
                        <div class="mt-2">
                            <label for="add_name_service" class="form-label">Nom du Service :</label>
                            <input type="text" id="add_name_service" name="add_name" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="add_description_service" class="form-label">Description :</label>
                            <textarea name="add_description" id="add_description_service" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_picture_service" class="form-label">Image :</label>
                            <input type="file" id="add_picture_service" name="add_picture" class="form-control" required>
                        </div>
                        <!-- Champ caché pour le token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button type="submit" name="add_service" class="btn btn-outline-light mt-2 btn-lg">Ajouter le Service</button>
                    </form>
                    
                    <h2 class="pt-5">Modifer / Supprimer un service</h2>
                    <?php foreach ($services as $service) { ?>
                        <div class="card mb-3 mt-3">
                            <img src="<?= htmlspecialchars($service['picture']) ?>" alt="Image du service" class="img-fluid">
                            <div class="card-body">
                                <form action="services_crud.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($service['name']) ?>" class="form-label fs-5">Nom du Service :</label>
                                        <input type="text" id="<?= htmlspecialchars($service['name']) ?>" name="ud_name" class="form-control" value="<?= htmlspecialchars($service['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($service['id']) ?>" class="form-label fs-5">Description :</label>
                                        <textarea name="ud_description" id="<?= htmlspecialchars($service['id']) ?>" class="form-control" required><?= htmlspecialchars_decode($service['description'], ENT_QUOTES) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($service['picture']) ?>" class="form-label fs-5">Image (laisser vide pour conserver l'actuelle) :</label>
                                        <input type="file" id="<?= htmlspecialchars($service['picture']) ?>" name="ud_picture" class="form-control">
                                    </div>
                                    <!-- Champ caché pour le token CSRF -->
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                    <button type="submit" name="update_service" class="btn btn-warning">Mettre à jour le Service</button>
                                    <button type="submit" name="delete_service" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">Supprimer le Service</button>
                                </form>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaires CRUD Services -->