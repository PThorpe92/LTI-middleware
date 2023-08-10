<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * Get a list of users from Canvas
     *
     * @return void
     */

    public function getUsers()
    {

        $baseUrl = env('CANVAS_API');
        $accessToken = env('CANVAS_API_KEY');

        $client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        $response = $client->get('accounts/self/users');

        $body = json_decode($response->getBody());

        return view('users.users', ['users' => $body]);
    }
    /**
     * Create a new user in Canvas
     *
     * @param Request $request
     * @return void
     *
     */

    public function createUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $terms = $request->input('terms_of_use');

        $userData = [
            'user' => [
                'name' => $name,
                'skip_registration' => true,
                'terms_of_use' => $terms
            ],
            'pseudonym' => [
                'unique_id' => $email,
                'send_confirmation' => false,
            ],
            'force_validations' => true,
        ];
        $canvasApi = env('CANVAS_API');
        $canvasApiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $canvasApiKey,
        ]);
        $response = $client->post("accounts/self/users/", $userData);
        if ($response->getStatusCode == 200) {
            $newUser = json_decode($response->getBody());
            $users = $this->getUsers(); // Get the list of users again after adding the new user
            return view('users.users', ['users' => $users, 'newUser' => $newUser]);
        } else {
            $error = $response->getReasonPhrase();
            return redirect()->route('canvas-users')->with('error', $error['errors'][0]['message']);
        }
    }


    /**
     * Store arbitrary custom data for a specific user
     * @param Request $request
     * @return void
     */
    public function listActivityStream(Request $request)
    {
        $user = $request->input('user');
    }

    /**
     * Delete arbitrary custom data for a specific user
     * @param Request $request
     * @return void
     */
    public function listCoursesForUser(Request $request)
    {
        $courseId = $request->input('course_id');
        $apiKey = env("CANVAS_API_KEY");
        $baseUrl = env("CANVAS_API");

        $client = new Client(["Authorization" => "Bearer" . $apiKey]);

        $response = $client->get($)
    }
    public function deleteCustomUserData(Request $request)
    {
        $sis_user_id = $request->input('sis_user_id');
        $scope = $request->input('scope');

        $canvasApi = env('CANVAS_API');
        $canvasApiKey = env('CANVAS_API_KEY');
        if (!$scope) {
            $client = new Client([
                'Authorization' => 'Bearer ' . $canvasApiKey,
            ]);
        $response = $client->delete("accounts/self/users/" . $sis_user_id);
            if ($response->getStatusCode() == 200) {
                return redirect()->route('canvas-users')->with('success', 'User deleted successfully');
            }
        } else {
            $client = new Client([
                'Authorization' => 'Bearer ' . $canvasApiKey,
            ]);
        $response = $client->delete("accounts/self/users/" . $sis_user_id . "/custom_data/" . $scope);
        }
    }
        public function courses()
    {
        $baseUrl = env('CANVAS_API');
        $accessToken = env('CANVAS_API_KEY');

        $client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        $response = $client->get('courses');
        if ($response->getStatusCode == 200) {
        $courses = json_decode($response->getBody(), true);

        // Fetch enrollments for each course
        foreach ($courses as &$course) {
            $courseId = $course['id'];
            $enrollmentsResponse = $client->get("courses/{$courseId}/enrollments");
            $enrollments = json_decode($enrollmentsResponse->getBody(), true);
            $course['enrollments'] = $enrollments;
        }
             return $courses
        } else {
            $error = $response->getReasonPhrase();
            return redirect()->route('canvas-courses')->with('error', $error['errors'][0]['message']);
        }
    }

}

