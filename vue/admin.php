<div class="container-admin">

    <div class="box-admin">
        <h2>Liste des hotels</h2>
        <ul>
            <?php foreach ($hotels as $hotel) : ?>
                <li><?php echo $hotel['name'] . ' - Nombre de chambre : ' . $Dbm->readNbHotel($hotel['id']) ?> </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="box-admin">
        <h2>Liste des réservations</h2>
        <?php
        $reservations = $Dbm->readBooking();
        ?>
        <?php if (!empty($reservations)) : ?>
            <table border="1">
                <tr>
                    <th>Numéro de réservation</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Date</th>
                    <th>Personne</th>
                    <th>Chambre</th>
                    <th>Hotel</th>
                </tr>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['id'] ?></td>
                        <td><?php echo $reservation['debut'] ?></td>
                        <td><?php echo $reservation['fin'] ?></td>
                        <td><?php echo $reservation['date'] ?></td>
                        <td><?php echo $Dbm->readNameByid($reservation['pers']) ?></td>
                        <td><?php echo $Dbm->readNum_chamByid($reservation['numero_cham']) ?></td>
                        <td><?php echo $Dbm->readHotelByid($reservation['id_hotel']) ?></td>
                    </tr>

                <?php endforeach ?>
            </table>
        <?php else : ?>
            <li class="nodata">Aucune réservation pour le moment

            </li>
        <?php endif ?>

    </div>
</div>