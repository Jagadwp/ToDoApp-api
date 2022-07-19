<?php

namespace App\Services;

use App\Repositories\SectionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class SectionService
{
    /**
     * @var $sectionRepository
     */
    protected $sectionRepository;

    /**
     * SectionService constructor.
     *
     * @param SectionRepository $sectionRepository
     */
    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * Delete section by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        $userId = auth()->user()?->id;

        DB::beginTransaction();

        try {
            $section = $this->sectionRepository->delete($userId, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete section data');
        }

        DB::commit();

        return $section;

    }

    /**
     * Get all section.
     *
     * @return String
     */
    public function getAll()
    {
        $userId = auth()->user()?->id;

        return $this->sectionRepository->getAll($userId);
    }

    /**
     * Get all section with its checklists.
     *
     * @return String
     */
    public function getAllWithChecklist()
    {
        $userId = auth()->user()?->id;

        return $this->sectionRepository->getAllWithChecklist($userId);
    }
    
    /**
     * Get all section with its checklists.
     *
     * @return String
     */
    public function getByIdWithChecklist($id)
    {
        $userId = auth()->user()?->id;

        return $this->sectionRepository->getByIdWithChecklist($userId, $id);
    }

    /**
     * Get section by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        $userId = auth()->user()?->id;
        
        return $this->sectionRepository->getById($userId, $id);
    }

    /**
     * Update section data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateSection($data, $id)
    {
        $date = \strtotime($data["date"]);
        $data["day"] = date('l', $date);

        DB::beginTransaction();

        try {
            $section = $this->sectionRepository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update section data');
        }

        DB::commit();

        return $section;

    }

    /**
     * Validate section data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveSectionData($data)
    {
        $user = auth()->user();

        $date = \strtotime($data["date"]);
        $data["day"] = date('l', $date);
        $data["user_id"] = $user?->id;

        DB::beginTransaction();

        try {
            $result = $this->sectionRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update section data');
        }

        DB::commit();

        return $result;
    }
}
