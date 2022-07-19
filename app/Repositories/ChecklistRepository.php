<?php

namespace App\Repositories;

use App\Models\Checklist;
use App\Traits\ApiResponse;

class ChecklistRepository
{
    use ApiResponse;
    /**
     * @var Checklist
     */
    protected $checklist;

    /**
     * ChecklistRepository constructor.
     *
     * @param Checklist $checklist
     */
    public function __construct(Checklist $checklist)
    {
        $this->checklist = $checklist;
    }

    /**
     * Get all checklists.
     *
     * @return Checklist $checklist
     */
    public function getAll($sectionId)
    {
        return $this->checklist
            ->where('section_id', $sectionId)
            ->get();
    }

    /**
     * Get checklist by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($sectionId, $checklistId)
    {
        return $this->checklist
            ->where('id', $checklistId)
            ->where('section_id', $sectionId)
            ->first();
    }

    /**
     * Save Checklist
     *
     * @param $data
     * @return Checklist
     */
    public function save($data)
    {
        $checklist = new $this->checklist;
        $checklist = $checklist->create($data);

        return $checklist->fresh();
    }

    /**
     * Update Checklist
     *
     * @param $data
     * @return Checklist
     */
    public function update($data, $sectionId, $checklistId)
    {
        $checklist = $this->checklist
                ->where('id', $checklistId)
                ->where('section_id', $sectionId)
                ->first();

        if (!$checklist) {
            return null;
        }
        
        $checklist->update($data);

        return $checklist;
    }

    /**
     * Update Checklist
     *
     * @param $data
     * @return Checklist
     */
    public function delete($sectionId, $checklistId)
    {
        $checklist = $this->checklist
                ->where('id', $checklistId)
                ->where('section_id', $sectionId)
                ->first();

        if (!$checklist) {
            return null;
        }

        $checklist->delete();

        return $checklist;
    }

}
