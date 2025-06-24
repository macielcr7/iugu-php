<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Plans\CreatePlanUseCase;
use Iugu\Application\Plans\DeletePlanUseCase;
use Iugu\Application\Plans\GetPlanUseCase;
use Iugu\Application\Plans\ListPlansUseCase;
use Iugu\Application\Plans\UpdatePlanUseCase;
use Iugu\Application\Plans\Requests\CreatePlanRequest;
use Iugu\Application\Plans\Requests\UpdatePlanRequest;
use Iugu\Domain\Plans\Plan;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class PlanService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreatePlanRequest $request): Plan
    {
        return (new CreatePlanUseCase($this->client))->execute($request);
    }

    public function get(string $id): Plan
    {
        return (new GetPlanUseCase($this->client))->execute($id);
    }

    /**
     * @return Plan[]
     */
    public function list(): array
    {
        return (new ListPlansUseCase($this->client))->execute();
    }

    public function update(string $id, UpdatePlanRequest $request): Plan
    {
        return (new UpdatePlanUseCase($this->client))->execute($id, $request);
    }

    public function delete(string $id): Plan
    {
        return (new DeletePlanUseCase($this->client))->execute($id);
    }
} 