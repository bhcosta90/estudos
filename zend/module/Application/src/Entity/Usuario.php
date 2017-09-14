<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 13/09/17
 * Time: 21:08
 */

namespace Application\Entity;

use Swagger\Annotations as SWG;

/*
 * @SWG\Definition()
 */
class Usuario
{
    /*
     * @var string
     *
     * @SWG\Property(
     *     description="Referencia do Usuário"
     * )
     */
    private $reference;

    /*
     * @var string
     *
     * @SWG\Property(
     *     property="_links",
     *     @SWG\Property(
     *         property="self",
     *         @SWG\Property(type="string", property="href")
     *     ),
     *     @SWG\Property(
     *         property="MyOtherModelLink",
     *         @SWG\Property(type="string", property="href")
     *     )
     * )
     */
    private $links;
}