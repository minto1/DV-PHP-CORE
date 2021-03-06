<?php

namespace Devless\RulesEngine;

trait tableActions
{
    /**
     * Check if table is being queried.
     *
     * @return $this
     */
    public function onQuery()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->actionType == 'GET');

        return $this;
    }
    /**
     * Check if data is being updated on table.
     *
     * @return $this
     */
    public function onUpdate()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->actionType == 'PATCH');

        return $this;
    }
    /**
     * Check if data is being added to table.
     *
     * @return $this
     */
    public function onCreate()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->actionType == 'POST');

        return $this;
    }
    /**
     * Check if data is being deleted from table.
     *
     * @return $this
     */
    public function onDelete()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->actionType == 'DELETE');

        return $this;
    }
    /**
     * Check if table is about to be queried.
     *
     * @return $this
     */
    public function beforeQuerying()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'before' && $this->actionType == 'GET');

        return $this;
    }
    /**
     * Check if data is about to be added.
     *
     * @return $this
     */
    public function beforeCreating()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'before' && $this->actionType == 'POST');

        return $this;
    }
    /**
     * Check if table data is about to be updated.
     *
     * @return $this
     */
    public function beforeUpdating()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'before' && $this->actionType == 'PATCH');

        return $this;
    }
    /**
     * Check if data is about to be deleted from table.
     *
     * @return $this
     */
    public function beforeDeleting()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'before' && $this->actionType == 'DELETE');

        return $this;
    }

     /**
     * Check if table has been queried.
     *
     * @return $this
     */
    public function afterQuerying()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'after' && $this->actionType == 'GET');

        return $this;
        
    }
    /**
     * Check if data has been added.
     *
     * @return $this
     */
    public function afterCreating()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'after' && $this->actionType == 'POST');

        return $this;
    }
    /**
     * Check if table has been updated.
     *
     * @return $this
     */
    public function afterUpdating()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'after' && $this->actionType == 'PATCH');

        return $this;
    }
    /**
     * Check if data has been deleted
     *
     * @return $this
     */
    public function afterDeleting()
    {
        $this->execOrNot = $this->isCurrentDBAction = ($this->request_phase == 'after' && $this->actionType == 'DELETE');

        return $this;
    }

    /**
     * Run irrespective of table action
     *
     * @return $this
     */
    public function onAnyRequest()
    {
        $this->execOrNot = $this->isCurrentDBAction = true;
        return $this;
    }

}
