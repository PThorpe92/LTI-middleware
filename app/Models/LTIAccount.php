<?php
// This is a model for an LTI account as defined by the Canvas API
use Http\Controllers\LtiController\getLtiAccount;

class Provider
{
    private $id;
    private $name;
    private $uuid;
    private $parentAccountId;
    private $rootAccountId;
    private $workflowState;

    public function __construct($id, $name, $uuid, $parentAccountId, $rootAccountId, $workflowState)
    {
        $this->id = $id;
        $this->name = $name;
        $this->uuid = $uuid;
        $this->parentAccountId = $parentAccountId;
        $this->rootAccountId = $rootAccountId;
        $this->workflowState = $workflowState;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getParentAccountId()
    {
        return $this->parentAccountId;
    }

    public function getRootAccountId()
    {
        return $this->rootAccountId;
    }

    public function getWorkflowState()
    {
        return $this->workflowState;
    }
}
