<?php

namespace App\Repositories\Contracts;

use LaraParse\Repositories\Contracts\ParseRepository;

/**
 * Class Ticket
 *
 * @method \{{rootNamespace}}ParseClasses\Ticket[] all()
 * @method \{{rootNamespace}}ParseClasses\Ticket[] paginate($perPage = 1);
 * @method \{{rootNamespace}}ParseClasses\Ticket   create(array $data)
 * @method \{{rootNamespace}}ParseClasses\Ticket   update($id, array $data)
 * @method \{{rootNamespace}}ParseClasses\Ticket   delete($id)
 * @method \{{rootNamespace}}ParseClasses\Ticket   find($id)
 * @method \{{rootNamespace}}ParseClasses\Ticket   findBy($field, $value)
 * @method \{{rootNamespace}}ParseClasses\Ticket[] near($column, $latitude, $longitude, $limit = 10)
 * @method \{{rootNamespace}}ParseClasses\Ticket[] within($column, $latitude, $longitude, $distance)
 * @method \{{rootNamespace}}ParseClasses\Ticket[] withinBox($column, $swLatitude, $swLongitude, $neLatitude, $neLongitude)
 */
interface TicketRepository extends ParseRepository
{
    //
}
