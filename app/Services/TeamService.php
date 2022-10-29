<?php

namespace App\Services;

use App\Dtos\Extra\PageableDto;
use App\Dtos\Models\Team\CreateOrUpdateTeamDto;
use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;

class TeamService
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    /**
     * @param PageableDto|null $pageable
     * @return LengthAwarePaginator<Team>
     */
    public function list(?PageableDto $pageable): LengthAwarePaginator
    {
        $pageable = $pageable ?? PageableDto::default();
        return Team::paginate($pageable->rowsPerPage, ['*'], 'page', $pageable->page);
    }

    public function update(Team $team, CreateOrUpdateTeamDto $dto): Team
    {
        $team->name = $dto->name;
        $team->manager = $dto->manager;
        $team->location = $dto->location;
        $team->logo_id = $dto->logo_id;
        $team->city_id = $dto->city_id;
        $team->save();

        if ($dto->logo_id) {
            $this->imageService->createVersionIfDoesntExistFromId($dto->logo_id, 512, 512);
        }

        return $team;
    }

    public function create(CreateOrUpdateTeamDto $dto): Team
    {
        $team = new Team();
        return $this->update($team, $dto);
    }

    public function delete(Team $team): void
    {
        $team->delete();
    }
}
