<?php

namespace App\Repositories;

use App\Models\Checklist;

class ChecklistRepository
{
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
    public function getAll()
    {
        return $this->checklist
            ->get();
    }

    /**
     * Get checklist by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->checklist
            ->where('id', $id)
            ->get();
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

        $checklist->title = $data['title'];
        $checklist->description = $data['description'];

        $checklist->save();

        return $checklist->fresh();
    }

    /**
     * Update Checklist
     *
     * @param $data
     * @return Checklist
     */
    public function update($data, $id)
    {
        
        $checklist = $this->checklist->find($id);

        $checklist->title = $data['title'];
        $checklist->description = $data['description'];

        $checklist->update();

        return $checklist;
    }

    /**
     * Update Checklist
     *
     * @param $data
     * @return Checklist
     */
    public function delete($id)
    {
        
        $checklist = $this->checklist->find($id);
        $checklist->delete();

        return $checklist;
    }

}
