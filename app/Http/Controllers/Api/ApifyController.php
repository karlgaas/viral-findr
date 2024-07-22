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
        $username = $request->input('username');
        set_time_limit(36000); // 10 hours
        // Define the path to your Node.js script and arguments
        $scriptPath = base_path('scripts/fetchInstagramData.js');
        $command = "node $scriptPath $username";

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


        //data
        //     65 => array:23 [▼
        //     "inputUrl" => "https://www.instagram.com/lrakwarren/"
        //     "id" => "948617922305272609"
        //     "type" => "Image"
        //     "shortCode" => "0qKvlukysh"
        //     "caption" => "chix kaau ug tiil whahah :3 . pra naa ma post xD"
        //     "hashtags" => []
        //     "mentions" => []
        //     "url" => "https://www.instagram.com/p/0qKvlukysh/"
        //     "commentsCount" => 2
        //     "firstComment" => "Haha!"
        //     "latestComments" => array:2 [▶]
        //     "dimensionsHeight" => 640
        //     "dimensionsWidth" => 640
        //     "displayUrl" => "
        // https://scontent.cdninstagram.com/v/t51.2885-15/10986255_831869300212242_897546132_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent.cdninstagram.com&_nc_cat=106&_nc_ohc=Ls
        //  ▶
        // "
        //     "images" => []
        //     "alt" => "Photo by Karl Warren on March 25, 2015."
        //     "likesCount" => 2
        //     "timestamp" => "2015-03-25T17:21:30.000Z"
        //     "childPosts" => []
        //     "ownerFullName" => "Karl Warren"
        //     "ownerUsername" => "lrakwarren"
        //     "ownerId" => "1774341225"
        //     "isSponsored" => false
        //   ]
        //     68 => array:28 [▼
        //     "inputUrl" => "https://www.instagram.com/lrakwarren/"
        //     "id" => "1158704502867700551"
        //     "type" => "Video"
        //     "shortCode" => "BAUi5s1EytH"
        //     "caption" => "😂😂😂😂😂"
        //     "hashtags" => []
        //     "mentions" => []
        //     "url" => "https://www.instagram.com/p/BAUi5s1EytH/"
        //     "commentsCount" => 0
        //     "firstComment" => ""
        //     "latestComments" => []
        //     "dimensionsHeight" => 640
        //     "dimensionsWidth" => 640
        //     "displayUrl" => "
        // https://scontent-atl3-1.cdninstagram.com/v/t51.2885-15/12547593_211740102498555_1573037746_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-atl3-1.cdninstagram.com&_nc_cat
        //  ▶
        // "
        //     "images" => []
        //     "videoUrl" => "
        // https://scontent-atl3-2.cdninstagram.com/o1/v/t16/f1/m84/294E991DC003023D689251586F1DE892_video_dashinit.mp4?efg=eyJxZV9ncm91cHMiOiJbXCJpZ193ZWJfZGVsaXZlcnlfdnR
        //  ▶
        // "
        //     "alt" => null
        //     "likesCount" => 10
        //     "videoViewCount" => 0
        //     "videoPlayCount" => null
        //     "timestamp" => "2016-01-09T14:06:02.000Z"
        //     "childPosts" => []
        //     "ownerFullName" => "Karl Warren"
        //     "ownerUsername" => "lrakwarren"
        //     "ownerId" => "1774341225"
        //     "productType" => "feed"
        //     "videoDuration" => 15.015
        //     "isSponsored" => false
        //   ]
        //         48 => array:23 [▼
        //     "inputUrl" => "https://www.instagram.com/lrakwarren/"
        //     "id" => "1956651313181854573"
        //     "type" => "Sidecar"
        //     "shortCode" => "BsnbACngYtt"
        //     "caption" => "#Onepiece ⚓⛵"
        //     "hashtags" => array:1 [▶]
        //     "mentions" => []
        //     "url" => "https://www.instagram.com/p/BsnbACngYtt/"
        //     "commentsCount" => 3
        //     "firstComment" => "gondzoo 🙌"
        //     "latestComments" => array:3 [▶]
        //     "dimensionsHeight" => 1080
        //     "dimensionsWidth" => 1080
        //     "displayUrl" => "
        // https://scontent.cdninstagram.com/v/t51.2885-15/49339187_986037351596751_7022186862487976739_n.jpg?stp=dst-jpg_e35&_nc_ht=scontent.cdninstagram.com&_nc_cat=103&
        //  ▶
        // "
        //     "images" => array:2 [▼
        //   0 => array:19 [ …19]
        //   1 => array:19 [ …19]
        // ]
        //     "alt" => "Photo by Karl Warren on January 14, 2019."
        //     "likesCount" => 9
        //     "timestamp" => "2019-01-14T13:03:54.000Z"
        //     "childPosts" => array:2 [▶]
        //     "ownerFullName" => "Karl Warren"
        //     "ownerUsername" => "lrakwarren"
        //     "ownerId" => "1774341225"
        //     "isSponsored" => false
        //   ]
        // Pass the data to the Blade view
        // Pass the data to the Blade view
        return view('research', ['data' => $data]);
    }
}
