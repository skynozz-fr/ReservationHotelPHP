<li class="nav-item dropdown me-2">
    <a class="nav-link dropdown-toggle me-3<?= $_SERVER['REQUEST_URI'] === '/hotels.php' ? 'active link-primary-color' : '' ?>"
       href="/hotels.php" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-hotel me-2 <?= $_SERVER['REQUEST_URI'] === '/hotels.php' ? 'fa-bounce' : '' ?>"></i>
        Nos Hôtels
    </a>
    <ul class="dropdown-menu">
        <?php
        $hotels = (new Hotels)->getAll();

        foreach ($hotels as $hotel) :
            $isHotelActive = $_SERVER['REQUEST_URI'] === '/hotel.php?id=' . $hotel["id"];
            ?>
            <li class="dropdown-item">
                <a href="/hotel.php?id=<?= $hotel["id"] ?>" class="link-primary-color link-offset-2">
                    <i class="fa-solid fa-hotel me-2 <?= $isHotelActive ? 'fa-bounce' : '' ?>"></i>
                    <?= $hotel["nom"] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</li>
