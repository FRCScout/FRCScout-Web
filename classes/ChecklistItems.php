<?php

class ChecklistItems extends Table
{
    public $Id;
    public $Title;
    public $Description;

    protected static $TABLE_NAME = 'checklist_items';

    /**
     * Overrides parent::delete() method
     * Attempts to delete checklist item completion records before deleting this record
     * @return bool
     */
    function delete()
    {
        $resultDeleteSuccess = true;

        //delete all results before deleting master record
        foreach($this->getResults() as $checklistItemResult)
            $resultDeleteSuccess = $checklistItemResult->delete();


        if($resultDeleteSuccess)
            return parent::delete();

        return false;
    }

    /**
     * Gets the results for this checklist item
     * @param Matches | null $match if specified, filters by match
     * @return ChecklistItemResults[]
     */
    public function getResults($match = null)
    {
        require_once(ROOT_DIR . '/classes/ChecklistItemResults.php');

        //create the sql statement
        $sql = "SELECT * FROM ! WHERE ! = ?";
        $cols[] = ChecklistItemResults::$TABLE_NAME;
        $cols[] = 'ChecklistItemId';
        $args[] = $this->Id;

        if(!empty($match))
        {
            $sql .= " AND ! = ? ";

            $cols[] = 'MatchId';
            $args[] = $match->Key;
        }

        $rows = self::query($sql, $cols, $args);

        foreach ($rows as $row)
            $response[] = ChecklistItemResults::withProperties($row);

        return $response;
    }

    /**
     * Returns the object once converted into HTML
     * @return string
     */
    public function toHtml()
    {
        $html =
            '<div class="mdl-layout__tab-panel is-active" id="overview">
                <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                    <div class="mdl-card mdl-cell mdl-cell--12-col">
                        <div class="mdl-card__supporting-text">
                            <h4>' . $this->toString() . '</h4>
                            ' . $this->Description . '<br><br>
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
        return $this->Title;
    }

}

?>