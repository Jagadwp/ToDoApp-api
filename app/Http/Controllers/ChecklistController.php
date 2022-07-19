<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChecklistRequest;
use App\Services\ChecklistService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    use ApiResponse;
    
    /**
     * @var checklistService
     */
    protected $checklistService;

    /**
     * ChecklistController Constructor
     *
     * @param ChecklistService $checklistService
     *
     */
    public function __construct(ChecklistService $checklistService)
    {
        $this->checklistService = $checklistService;
    }

    public function test() {
        return "ok";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sectionId)
    {
        try {
            $result = $this->checklistService->getAll($sectionId);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        return $this->sendData($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChecklistRequest $request, $sectionId)
    {
        $data = $request->validated();

        try {
            $result = $this->checklistService->saveChecklistData($data, $sectionId);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        return $this->sendCreated($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($sectionId, $checklistId)
    {
        try {
            $result = $this->checklistService->getById($sectionId, $checklistId);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }
        
        return $this->sendData($result);
    }

    /**
     * Update checklist.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreChecklistRequest $request, $sectionId, $checklistId)
    {
        $data = $request->validated();

        try {
            $result = $this->checklistService->updateChecklist($data, $sectionId, $checklistId);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }

        return $this->sendUpdated($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sectionId, $checklistId)
    {
        try {
            $result = $this->checklistService->deleteById($sectionId, $checklistId);
        } catch (Exception $e) {
            return $this->handleException($e);
        }

        if(is_null($result)) {
            return $this->sendNotFound();
        }

        return $this->sendDeleted($result);
    }
}
