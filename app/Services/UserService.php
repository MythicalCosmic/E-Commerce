<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepository;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Transformers\UserTransformer;

class UserService
{
    protected $userRepository;
    protected Manager $fractal;

    public function __construct(UserRepository $userRepository, Manager $fractal)
    {
        $this->userRepository = $userRepository;
        $this->fractal = $fractal;
    }

    public function all(): array
    {
        $users = $this->userRepository->getAllPaginated();
        $resource = new Collection($users->items(), new UserTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($users));

        return $this->formatData($this->fractal->createData($resource)->toArray(), 'users');
    }


    public function show(User $user): array
    {
        $resource = new Item($user, new UserTransformer());

        return $this->formatData($this->fractal->createData($resource)->toArray(), 'user');
    }

    public function create(array $data): array
    {
        $user = $this->userRepository->create($data);
        return $this->show($user);
    }

    public function update(User $user, array $data): array
    {
        $this->userRepository->update($user->id, $data);
        return $this->show($user);
    }

    public function delete(User $user): ?bool
    {
        return $this->userRepository->delete($user->id);
    }

    private function formatData(array $data, string $key = 'data'): array
    {

        if (isset($data['data'])) {
            $data[$key] = $data['data'];
            unset($data['data']);
        }

        return $data;
    }
}
