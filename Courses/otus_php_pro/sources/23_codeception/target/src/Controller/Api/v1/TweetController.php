<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\BadRequestDTO;
use App\DTO\ForbiddenDTO;
use App\DTO\SuccessDTO;
use App\DTO\TweetsDTO;
use App\Service\SubscriptionService;
use App\Service\TweetService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2020, raptor_MVK
 *
 * @Annotations\Route("/api/v1/tweet")
 */
final class TweetController extends AbstractFOSRestController
{
    /** @var int */
    private const DEFAULT_FEED_SIZE = 20;

    /** @var TweetService */
    private $tweetService;
    /** @var SubscriptionService */
    private $subscriptionService;

    public function __construct(TweetService $tweetService, SubscriptionService $subscriptionService)
    {
        $this->tweetService = $tweetService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * @Annotations\Post("")
     *
     * @OA\Post(
     *     tags={"Твиты"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="authorId", type="integer", description="ID автора", example="123"),
     *                 @OA\Property(property="text", type="string", description="Текст твита", example="My tweet"),
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
     * @RequestParam(name="text")
     */
    public function postTweetAction(int $authorId, string $text): View
    {
        $success = $this->tweetService->saveTweet($authorId, $text);
        $code = $success ? 200 : 400;

        return View::create(['success' => $success], $code);
    }

    /**
     * @Annotations\Get("/feed")
     *
     * @OA\Get(
     *     tags={"Твиты"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="query",
     *         description="ID пользователя",
     *         example="111",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="Размер ленты",
     *         example="5",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authors found",
     *         @Model(type=TweetsDTO::class)
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
     * @QueryParam(name="userId", requirements="\d+")
     * @QueryParam(name="count", requirements="\d+", nullable=true)
     */
    public function getFeedAction(int $userId, ?int $count = null): View
    {
        $count = $count ?? self::DEFAULT_FEED_SIZE;
        $authorIds = $this->subscriptionService->getAuthorIds($userId);
        $tweets = $this->tweetService->getFeed($authorIds, $count);
        $result = new TweetsDTO($tweets);

        return View::create($result, $result->getCode());
    }
}