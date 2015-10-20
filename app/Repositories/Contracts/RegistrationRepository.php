<?php

namespace App\Repositories\Contracts;

use LaraParse\Repositories\Contracts\ParseRepository;

/**
 * Class Registration
 *
 * @method \{{rootNamespace}}ParseClasses\Registration[] all()
 * @method \{{rootNamespace}}ParseClasses\Registration[] paginate($perPage = 1);
 * @method \{{rootNamespace}}ParseClasses\Registration   create(array $data)
 * @method \{{rootNamespace}}ParseClasses\Registration   update($id, array $data)
 * @method \{{rootNamespace}}ParseClasses\Registration   delete($id)
 * @method \{{rootNamespace}}ParseClasses\Registration   find($id)
 * @method \{{rootNamespace}}ParseClasses\Registration   findBy($field, $value)
 * @method \{{rootNamespace}}ParseClasses\Registration[] near($column, $latitude, $longitude, $limit = 10)
 * @method \{{rootNamespace}}ParseClasses\Registration[] within($column, $latitude, $longitude, $distance)
 * @method \{{rootNamespace}}ParseClasses\Registration[] withinBox($column, $swLatitude, $swLongitude, $neLatitude, $neLongitude)
 */
interface RegistrationRepository extends ParseRepository
{
    //
}
