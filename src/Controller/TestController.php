<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1')]
class TestController extends AbstractController
{
    private static array $Users=[
        [
            'id'    => '1',
            'email' => 'zipzk241@gmail.com',
            'name'  => 'Nastya'],
        [
            'id'    => '2',
            'email' => 'dashas@gmail.com',
            'name'  => 'Darya'],
        [
            'id'    => '3',
            'email' => 'andrew12@gmail.com',
            'name'  => 'Andrew'],
    ];
    #[Route('/users', name: 'app_collection_users', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function getCollection(): JsonResponse
    {
        return new JsonResponse([
            'data' => self::$Users
        ], Response::HTTP_OK);
    }


    #[Route('/users/{id}', name: 'app_item_users', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $userData=$this->findUserById($id);

        return new JsonResponse([
            'data' => $userData
        ], Response::HTTP_OK);
    }

    #[Route('/users', name: 'app_create_users', methods: ['POST'])]
    public function createItem(Request $request): JsonResponse
    {
        $requestData=json_decode($request->getContent(),true);

        if(!isset($requestData['email'], $requestData['name']))
        {
            throw new UnprocessableEntityHttpException("Name and email are required!");
        }
        if (!filter_var($requestData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new UnprocessableEntityHttpException("Invalid email format!");
        }

        $countOfUsers=count(self::$Users);
        $newUser=[
          'id'   => $countOfUsers+1,
          'name' => $requestData['name'],
          'email' => $requestData['email']
        ];

        self::$Users[] = $newUser;
        return new JsonResponse([
            'data' => $newUser
        ], Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'app_delete_users', methods: ['DELETE'])]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteItem(string $id): JsonResponse
    {
        $userIndex = null;
        foreach (self::$Users as $index => $user) {
            if ($user['id'] == $id) {
                $userIndex = $index;
                break;
            }
        }
        if ($userIndex !== null) {
            unset(self::$Users[$userIndex]);
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    #[Route('/users/{id}', name: 'app_update_users', methods: ['PATCH'])]
    #[IsGranted("ROLE_ADMIN")]
    public function updateItem(string $id, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        if (!isset($requestData['name'])) {
            throw new UnprocessableEntityHttpException("Name is required!");
        }

        $userIndex = null;
        foreach (self::$Users as $index => $user) {
            if ($user['id'] == $id) {
                $userIndex = $index;
                break;
            }
        }

        if ($userIndex !== null) {
            self::$Users[$userIndex]['name'] = $requestData['name'];
            return new JsonResponse(['data' => self::$Users[$userIndex]], Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    public function findUserById(string $id)
    {
        $userData=null;
        foreach(self::$Users as $user) {
            if (!isset($user['id']))
            {continue;}
            if($user['id']==$id)
            {
                $userData=$user;
                break;
            }
        }
        if(!$userData){
            throw new NotFoundHttpException("User with id ".$id." not found");
        }

        return $userData;
    }
}