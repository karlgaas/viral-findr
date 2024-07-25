<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ApifyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('research');
    }

    public function search(Request $request)
    {
      try {
        $username = $request->input('username');
        set_time_limit(36000); // 10 hours
        // Define the path to your Node.js script and arguments
        $scriptPath = base_path('scripts/fetchInstagramData.js');
        $command = "node $scriptPath $username 2>&1";

        // Execute the command
        $output = [];
        $returnValue = 0;
        exec($command, $output, $returnValue);

        // Handle the result
        if ($returnValue !== 0) {
            Log::error("Error executing Node.js script: " . implode("\n", $output));
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
        $data = [];
        foreach ($output as $data) {
            // Convert JSON string to array
            $data = json_decode($data, true);

            // Make sure $data is an array
            if (is_array($data)) {
                // Push new elements if needed
                array_push($data, ['newKey' => 'newValue']);
            } else {
                // Handle the case where $data is not an array
                return response()->json(['error' => 'Invalid data format'], 400);
            }
        }
        return view('research', ['data' => $data]);

      } catch (\Throwable $th) {
        dd($th);
      }
    }
}
