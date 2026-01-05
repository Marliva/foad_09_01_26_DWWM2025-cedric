<?php

function calculatePrice($price_per_day, $start_date, $end_date)
{
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    // Calcul du nombre de jours en faisant la différence entre la date de fin de location et la date de début de location
    $days = $start->diff($end)->days;

    // Minimum 1 jour pour éviter des locations de 0 jour
    if ($days < 1) {
        $days = 1;
    }

    return $days * $price_per_day; // simple calcul pour avoir le prix total par réservation
}
