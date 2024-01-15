<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nos hôtels</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col text-center">
            <h2 class="mb-4">
                Nos hôtels
                <i class="fas fa-hotel ml-2"></i>
            </h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        (new Bookings)->clearOldReservations();
        $hotels = (new Chambres)->trierHotelsParChambresDisponibles((new Hotels)->getAll());

        foreach ($hotels as $hotel):
            $photoHotel = $hotel["photo"];
            $photoHotel = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', urldecode($photoHotel));
            $chambresDisponibles = (new Chambres)->countChambresDisponiblesByHotelId($hotel["id"]);
            ?>
            <div class="col mb-4">
                <div class="card border-dark">
                    <img src="../images/hotels/<?= $photoHotel ?>" class="card-img-top img-fluid"
                         alt="Photo de <?= $hotel['nom'] ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3"><?= $hotel['nom'] ?></h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><?= $hotel['adresse'] ?></li>
                            <li class="list-group-item"><?= $hotel['code_postal'] . ' ' . $hotel['ville'] ?></li>
                            <?php if ($chambresDisponibles === 0): ?>
                                <li class="list-group-item">
                                    <p class="card-text text-danger">Aucune chambre disponible</p>
                                </li>
                            <?php else: ?>
                                <li class="list-group-item">
                                    <p class="card-text text-success"><strong><?= $chambresDisponibles ?></strong>
                                        chambre<?= ($chambresDisponibles > 1) ? 's' : '' ?>
                                        disponible<?= ($chambresDisponibles > 1) ? 's' : '' ?></p>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php if ($chambresDisponibles > 0): ?>
                            <a href="/hotel.php?id=<?= $hotel["id"] ?>" class="btn btn-outline-dark mt-2">
                                Réserver une chambre
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-danger mt-2 disabled">Aucune chambre disponible
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
