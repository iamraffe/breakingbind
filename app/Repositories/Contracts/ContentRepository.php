<?php

namespace App\Repositories\Contracts;

use LaraParse\Repositories\Contracts\ParseRepository;

/**
 * Class Content
 *
 * @method \{{rootNamespace}}ParseClasses\Content[] all()
 * @method \{{rootNamespace}}ParseClasses\Content[] paginate($perPage = 1);
 * @method \{{rootNamespace}}ParseClasses\Content   create(array $data)
 * @method \{{rootNamespace}}ParseClasses\Content   update($id, array $data)
 * @method \{{rootNamespace}}ParseClasses\Content   delete($id)
 * @method \{{rootNamespace}}ParseClasses\Content   find($id)
 * @method \{{rootNamespace}}ParseClasses\Content   findBy($field, $value)
 * @method \{{rootNamespace}}ParseClasses\Content[] near($column, $latitude, $longitude, $limit = 10)
 * @method \{{rootNamespace}}ParseClasses\Content[] within($column, $latitude, $longitude, $distance)
 * @method \{{rootNamespace}}ParseClasses\Content[] withinBox($column, $swLatitude, $swLongitude, $neLatitude, $neLongitude)
 */
interface ContentRepository extends ParseRepository
{
    //
}
