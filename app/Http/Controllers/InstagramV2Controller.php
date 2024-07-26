<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Log;
use Illuminate\Support\Facades\Http;


class InstagramV2Controller extends Controller
{

  public function fetchInstagramDataFromNode(Request $request)
  {
    $username = $request->username;
    Log::info("Fetching Instagram data for username: $username");

    $response = Http::timeout(60)->get("http://localhost:3000/fetchInstagramData", [
      'username' => $username,
    ]);

    if ($response->ok()) {
      $output = $response->json();

        return view('research', ['data' => $output]);
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
