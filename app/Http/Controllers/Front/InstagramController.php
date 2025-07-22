<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\InstagramData;

class InstagramController extends Controller
{
public function fetchAndStoreInstagramPosts()
{
    $accessToken = 'IGAARcSE6ZBZBB1BZAE9mN0xMTWU3OTgzODY1NXJCbTFEOExrZA29VSVpTVlFldmROM09aSzRwZAEdhVkRmc2tMWS1DbUlFR0lIU0syVGxvM1dlNkFETWNNMmp1NnlfeXp0WWFsV01JU29hREFNdVVfNGpld1JtVGVva0VNZAXFSTzY0UQZDZD';
    $endpoint = "https://graph.instagram.com/me/media";
    $fields = "id,caption,media_type,media_url,permalink,timestamp,username";
    $url = "{$endpoint}?fields={$fields}&access_token={$accessToken}";

    $response = Http::get($url);
    //   dd($response->json());
    if ($response->successful()) {
        $data = $response->json()['data'] ?? [];

        // Limit to only 50 items
        $limitedPosts = array_slice($data, 0, 50);

        foreach ($limitedPosts as $post) {
            InstagramData::updateOrCreate(
                ['insta_id' => $post['id']],
                [
                    'link' => $post['permalink'] ?? null,
                    'image_url' => $post['media_url'] ?? null,
                    'alt' => substr($post['caption'] ?? '', 0, 150),
                    'title' => $post['caption'] ?? null,
                    'media_type' => $post['media_type'] ?? null,
                    'insta_timestamp' => $post['timestamp'] ?? null,
                    'username' => $post['username'] ?? null,
                    'status' => 1,
                ]
            );
        }

        return response()->json(['message' => 'Latest 50 Instagram posts updated successfully']);
    } else {
        return response()->json(['error' => 'Failed to fetch data from Instagram'], 500);
    }
}

    // Optional: Fetch posts from DB to use in frontend
    // public function getInstagramPosts()
    // {
    //     $posts = InstagramData::where('status', 1)
    //         ->orderBy('insta_timestamp', 'desc')
    //         ->limit(6)
    //         ->get();

    //     return response()->json($posts);
    // }



// public function storePostsFromClient(Request $request)
// {
//     $posts = $request->input('posts');

//     if (!is_array($posts)) {
//         return response()->json(['error' => 'Invalid data format'], 400);
//     }

//     $savedPosts = [];

//     foreach (array_slice($posts, 0, 50) as $post) {
//         // Only store IMAGE or CAROUSEL_ALBUM
//         if ($post['media_type'] !== 'VIDEO') {
//             $saved = InstagramData::updateOrCreate(
//                 ['insta_id' => $post['id']],
//                 [
//                     'link' => $post['permalink'] ?? null,
//                     'image_url' => $post['media_url'] ?? null,
//                     'alt' => substr($post['caption'] ?? '', 0, 150),
//                     'title' => $post['caption'] ?? null,
//                     'media_type' => $post['media_type'] ?? null,
//                     'insta_timestamp' => $post['timestamp'] ?? null,
//                     'username' => $post['username'] ?? null,
//                     'status' => 1,
//                 ]
//             );

//             $savedPosts[] = $saved;
//         }
//     }

//     return response()->json(['message' => 'Posts saved successfully', 'count' => count($savedPosts)]);
// }

}
