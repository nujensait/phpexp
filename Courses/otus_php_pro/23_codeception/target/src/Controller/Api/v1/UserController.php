<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\BadRequestDTO;
use App\DTO\ForbiddenDTO;
use App\DTO\UserCreatedDTO;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2020, raptor_MVK
 *
 * @Annotations\Route("/api/v1/user")
 */
final class UserController extends AbstractFOSRestController
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Annotations\Post("")
     *
     * @OA\Post(
     *     tags={"Пользователи"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="login", type="string", description="Логин пользователя", example="my_user"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @Model(type=UserCreatedDTO::class)
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Fail",
     *         @Model(type=BadRequestDTO::class)
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied",
     *         @Model(type=ForbiddenDTO::class)
     *     )
     * )
     *
     * @RequestParam(name="login")
     */
    public function addUserAction(string $login): View
    {
        $userId = $this->userService->saveUser($login);
        $result = $userId === null ? new ForbiddenDTO() : new UserCreatedDTO($userId);

        return View::create($result, $result->getCode());
    }
}