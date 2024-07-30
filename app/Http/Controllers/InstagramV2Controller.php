<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Log;
use Illuminate\Support\Facades\Http;


class InstagramV2Controller extends Controller
{
    public $data = [];

    public function fetchInstagramDataFromNode(Request $request)
    {
        $username = $request->username;
        Log::info("Fetching Instagram data for username: $username");

        $response = Http::timeout(3600)->get("http://localhost:3000/fetchInstagramData", [
            'username' => $username,
        ]);

        if ($response->ok()) {
            $outputs = $response->json();
            $this->data = collect();
            foreach ($outputs as $key => $output) {
                if (isset($output['type'])) {
                    if ($output['type']=='Video') {
                        $this->data->push($output);
                    }
                }

            }
            return view('research', ['data' => $this->data]);
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }

    private function checkNodeServerStatus()
    {
        try {
            $response = Http::timeout(3600)->get("http://localhost:3000/fetchInstagramData?username=test");

            if ($response->successful()) {
                // Node.js server is running
                return true;
            } else {
                // Node.js server is not running
                return false;
            }
        } catch (\Exception $e) {
            // Handle the exception (e.g., server not reachable)
            return false;
        }
    }
}
