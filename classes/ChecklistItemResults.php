<?php

class ChecklistItemResults extends Table implements Status
{
    public $Id;
    public $ChecklistItemId;
    public $MatchId;
    public $Status;
    public $CompletedBy;
    public $CompletedDate;

    public static $TABLE_NAME = 'checklist_item_results';

    /**
     * Returns the object once converted into HTML
     * @return string
     */
    public function toHtml()
    {
        require_once(ROOT_DIR . '/classes/ChecklistItems.php');

        //get the checklist item
        $checklistItem = ChecklistItems::withId($this->ChecklistItemId);

        //create the status html with colors
        if($this->Status == Status::COMPLETE)
            $statusHtml = '<span class="good" style="font-weight: bold">' . Status::COMPLETE . '</span>';

        else if($this->Status == Status::INCOMPLETE)
            $statusHtml = '<span class="bad" style="font-weight: bold">' . Status::INCOMPLETE . '</span>';

        $html =
            '<div class="mdl-layout__tab-panel is-active" id="overview">
                    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                        <div class="mdl-card mdl-cell mdl-cell--12-col">
                            <div class="mdl-card__supporting-text">
                                <h4>' . $checklistItem->Title . '</h4>
                                ' . 'Current Status - ' . $statusHtml . '<br><br>
                                ' . $checklistItem->Description . '<br><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input disabled class="mdl-textfield__input" type="text" value="' . $this->CompletedBy . '">
                                    <label class="mdl-textfield__label" >Completed By</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input disabled class="mdl-textfield__input" type="text" value="' . $this->CompletedDate . '">
                                    <label class="mdl-textfield__label" >Completed On</label>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
        
        return $html;
    }

    /**
     * Compiles the name of the object when displayed as a string
     * @return string
     */
    public function toString()
    {
        require_once(ROOT_DIR . '/classes/ChecklistItems.php');
        return ChecklistItems::withId($this->ChecklistItemId)->Title;
    }

}

interface Status
{
    const COMPLETE = 'COMPLETE';
    const INCOMPLETE = 'INCOMPLETE';
}

?>