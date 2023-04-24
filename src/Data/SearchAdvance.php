<?php

namespace App\Data;

class SearchAdvance {

    /**
     * @var string
     */
    public $q ='';

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $thematique;
    
    /**
     * @var string
     */
    public $langue;

    /**
     * @var string
     */
    public $partenaire;

    /**
     * @var date
     */
    public $date_ins_d;

    /**
     * @var date
     */
    public $date_ins_f;

    /**
     * @var date
     */
    public $date_start;

    /**
     * @var date
     */
    public $date_end;
}