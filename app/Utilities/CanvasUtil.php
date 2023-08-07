<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CanvasUtil extends Util
{
    /**
     * Get a list of users from Canvas
     *
     * @param? string
     * @returns JSON decoded
     * @throws \Exception
     */
    public static function listUsers($accountId = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $accessToken = env('CANVAS_API_KEY');

        $client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        try {
            $response = $client->get('accounts/' . $accountId . 'users');

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {

                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }

    /* Get details for a specific user in Canvas
     *
     * @param int $userId
     * @return JSON decoded
     * @throws \Exception
     */
    public static function showUserDetails($userId)
    {
        $baseUrl = env('CANVAS_API');
        $accessToken = env('CANVAS_API_KEY');

        $client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);
        try {
            $response = $client->get('users/' . $userId);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {

            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }

    /**
     * Create a new user in Canvas
     *
     * @param string $name
     * @param string $email
     * @param? boolean $terms (defaults true)
     * @return JSON decoded
     * @throws \Exception
     */

    public function createUser(string $name, string $email, bool $terms = true)
    {

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
        try {
            $response = $client->post($canvasApi . "accounts/self/users/", $userData);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * List Activity Stream
     *
     * @param? string $account (default self)
     * @return JSON decoded
     * @throws \Exception
     */
    public static function listActivityStream($account = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' . $account . '/activity_stream');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * List Activity Stream Summary from Canvas
     * @param? string $account (default self)
     * @return JSON decoded
     * @throws \Exception
     */
    public static function getActivityStreamSummary($account = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' .  $account . '/activity_stream/summary');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * List Todo Items from Canvas
     * @param? string $account (default self)
     * @return JSON decoded
     * @throws \Exception
     */
    public static function listTodoItems($account = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' .  $account . '/todo');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }
    /**
     * Get Todo Items Count from Canvas
     * @param? string $account (default self)
     * @return JSON decoded
     *
     */
    public static function getTodoItemsCount($account = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' .  $account . '/todo_item_count');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * List Upcoming Assignments from Canvas
     * @param? string $account (default self)
     * @return JSON decoded
     * @throws \Exception
     */

    public static function listUpcomingAssignments($userId = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' .  $userId . '/upcoming_events');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * List Missing Submissions from Canvas
     * @param? string $account (default self)
     * @return JSON decoded
     * @throws \Exception
     */
    public static function listMissingSubmissions($userId)
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' .  $userId . '/missing_submissions');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }
    /**
     * List Courses from Canvas
     * @return JSON decoded
     * @throws \Exception
     **/
    public static function listCourses()
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'courses');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }
    public static function listCoursesForUser($userId)
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'users/' . $userId . '/courses');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }
    /**
     * List Course Assignments from Canvas
     *
     * @param string $userId (default self)
     * @param string $courseId
     * @return JSON decoded
     * @throws \Exception
     *
     * Canvas Docs:
     * "You can supply self as the user_id to query your own progress
     * in a course. To query another user’s progress, you must be a
     * teacher in the course, an administrator, or a linked observer of the user."
     * */
    public static function getUserCourseProgress($userId = 'self/', $courseId)
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');
        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->get($baseUrl . 'courses/' . $courseId . '/users/' . $userId . 'progress');
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }

    /**
     * Create new course in Canvas
     * @param Course $course
     * @return JSON decoded
     * @throws \Exception
     *
     * There are too many required parameters to accept anything
     * but a Course object already instantiated with all the required
     * fields.
     *
     * */

    public function createNewCourse(CanvasCourse $course, $accountId = 'self/')
    {
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->post($baseUrl . 'accounts/' . $accountId . 'courses/' . $course->toJson());

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw new \Exception('API request failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $error) {
            throw new \Exception('API request failed: ' . $error->getMessage());
        }
    }
}
