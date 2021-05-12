<?php

namespace app\dgomUtils\responses;

class ListResponse{

    public $responseCode = 0;
    public $operation = "";
    public $message = "";
    
    public $errors = [];
    public $count;
    public $page =1;
    public $maxPage = 1;
    public $pageSize = 1000;
    public $errorMessages = [];

    public $results = [];
}