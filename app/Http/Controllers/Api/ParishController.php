<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    /**
     * Get all unique parishes from sub-administrators
     */
    public function index()
    {
        $parishes = User::where('role', 'sub-administrator')
            ->whereNotNull('parish_name')
            ->distinct()
            ->pluck('parish_name')
            ->map(function ($parishName) {
                return [
                    'value' => $this->generateSlug($parishName),
                    'name' => $parishName
                ];
            })
            ->values();

        return response()->json($parishes);
    }

    /**
     * Generate a URL-friendly slug from parish name
     */
    private function generateSlug($parishName)
    {
        return strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\s-]/', '', $parishName)));
    }
}
