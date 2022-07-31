<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\AuthorsDTO;
use App\DTO\BadRequestDTO;
use App\DTO\FollowersDTO;
use App\DTO\ForbiddenDTO;
use App\DTO\SuccessDTO;
use App\Service\SubscriptionService;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2020, raptor_MVK
 *
 * @Annotations\Route("/api/v1/subscription")
 */
final class SubscriptionController
{
    /** @var SubscriptionService */
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * @Annotations\Get("/list-by-author")
     *
     * @OA\Get(
     *     tags={"Подписки"},
     *     @OA\Parameter(
     *         name="authorId",
     *         in="query",
     *         description="ID автора",
     *         example="111",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Followers found",
     *         @Model(type=FollowersDTO::class)
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
     * @QueryParam(name="authorId", requirements="\d+")
     */
    public function listSubscriptionByAuthorAction(int $authorId): View
    {
        $followers = $this->subscriptionService->getFollowers($authorId);
        $result = new FollowersDTO($followers);

        return View::create($result, $result->getCode());
    }

    /**
     * @Annotations\Get("/list-by-follower")
     *
     * @OA\Get(
     *     tags={"Подписки"},
     *     @OA\Parameter(
     *         name="followerId",
     *         in="query",
     *         description="ID фолловера",
     *         example="111",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authors found",
     *         @Model(type=AuthorsDTO::class)
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
     * @QueryParam(name="followerId", requirements="\d+")
     */
    public function listSubscriptionByFollowerAction(int $followerId): View
    {
        $authors = $this->subscriptionService->getAuthors($followerId);
        [$code, $data] = empty($authors) ? [204, ''] : [200, ['authors' => $authors]];

        return View::create($data, $code);
    }

    /**
     * @Annotations\Post("")
     *
     * @OA\Post(
     *     tags={"Подписки"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="authorId", type="integer", description="ID автора", example="111"),
     *                 @OA\Property(property="followerId", type="integer", description="ID подписчика", example="222")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @Model(type=SuccessDTO::class)
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
     * @RequestParam(name="authorId", requirements="\d+")
     * @RequestParam(name="followerId", requirements="\d+")
     */
    public function subscribeAction(int $authorId, int $followerId): View
    {
        $success = $this->subscriptionService->subscribe($authorId, $followerId);
        $result = $success ? new SuccessDTO() : new BadRequestDTO();

        return View::create($result, $result->getCode());
    }
}