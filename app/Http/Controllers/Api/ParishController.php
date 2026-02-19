<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    /**
     * Get all unique parishes from sub-administrators with pagination and search
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'sub-administrator')
            ->whereNotNull('parish_name');

        // Apply search filter if provided
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('parish_name', 'like', "%{$searchTerm}%")
                  ->orWhere('parish_address', 'like', "%{$searchTerm}%");
            });
        }

        // Get paginated results (5 per page as requested)
        $parishes = $query->orderBy('parish_name', 'asc')
            ->paginate(5);

        // Transform the results
        $transformedParishes = $parishes->getCollection()->map(function ($user) {
            return [
                'id' => $user->id,
                'value' => $this->generateSlug($user->parish_name),
                'name' => $user->parish_name,
                'address' => $user->parish_address ?? ''
            ];
        });

        return response()->json([
            'data' => $transformedParishes,
            'current_page' => $parishes->currentPage(),
            'last_page' => $parishes->lastPage(),
            'per_page' => $parishes->perPage(),
            'total' => $parishes->total(),
            'has_more_pages' => $parishes->hasMorePages()
        ]);
    }

    /**
     * Generate a URL-friendly slug from parish name
     */
    private function generateSlug($parishName)
    {
        return strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\s-]/', '', $parishName)));
    }
}
