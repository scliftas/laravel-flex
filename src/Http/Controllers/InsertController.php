<?php

namespace Shaunclift\Flex\Http\Controllers;

use Shaunclift\Flex\Managers\DatabaseManager;

class InsertController extends AbstractController
{
    public function index()
    {
        $manager = new DatabaseManager('mysql');
        dd($manager->create('test_db5'));
    }
}