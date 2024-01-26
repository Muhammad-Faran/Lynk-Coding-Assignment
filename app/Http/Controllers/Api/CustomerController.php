<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();

        return new CustomerCollection($customers);
    }
}
