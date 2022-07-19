<?php

namespace App\Services;

use App\Repositories\ChecklistRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ChecklistService
{
    /**
     * @var $checklistRepository
     */
    protected $checklistRepository;

    /**
     * ChecklistService constructor.
     *
     * @param ChecklistRepository $checklistRepository
     */
    public function __construct(ChecklistRepository $checklistRepository)
    {
        $this->checklistRepository = $checklistRepository;
    }

    /**
     * Delete checklist by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($sectionId, $checklistId)
    {

        DB::beginTransaction();

        try {
            $checklist = $this->checklistRepository->delete($sectionId, $checklistId);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete checklist data');
        }

        DB::commit();

        return $checklist;

    }

    /**
     * Get all checklist.
     *
     * @return String
     */
    public function getAll($sectionId)
    {
        return $this->checklistRepository->getAll($sectionId);
    }

    /**
     * Get checklist by id.
     *
     * @param $id
     * @return String
     */
    public function getById($sectionId, $checklistId)
    {
        
        return $this->checklistRepository->getById($sectionId, $checklistId);
    }

    /**
     * Update checklist data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateChecklist($data, $sectionId, $checklistId)
    {
        $data["done"] = $data["status"] == 'Completed' ? 1 : 0;

        DB::beginTransaction();

        try {
            $checklist = $this->checklistRepository->update($data, $sectionId, $checklistId);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update checklist data');
        }

        DB::commit();

        return $checklist;

    }

    /**
     * Validate checklist data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveChecklistData($data, $sectionId)
    {
        $data["done"] = $data["status"] == 'Completed' ? 1 : 0;
        $data["section_id"] = $sectionId;

        DB::beginTransaction();

        try {
            $result = $this->checklistRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update checklist data');
        }

        DB::commit();

        return $result;
    }
}
