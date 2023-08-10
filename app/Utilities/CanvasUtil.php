<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\LtiController;

class CanvasUtil extends ProviderUtil
{
    /*
   * From Canvas, we get this information, this will be useful
   * because even though we are not speaking to canvas via LTI, we
   * will be modeling our providers after the LTI model.
   ***********************************************************
  the ID of the Account object
  "id": 2,
   The display name of the account
  "name": "Canvas Account",
   The UUID of the account
  "uuid": "WvAHhY5FINzq5IyRIJybGeiXyFkG3SqHUPb7jZY5",
   The account's parent ID, or null if this is the root account
  "parent_account_id": 1,
   The ID of the root account, or null if this is the root account
  "root_account_id": 1,
   The state of the account. Can be 'active' or 'deleted'.
  "workflow_state": "active"
}
*/
    public function __construct()
    {
        $controller = new LtiController();
        $info = $controller->getCanvasLtiAccount();
        $this->ltiAccount = $info['root_account_id'];
        $this->providerId = $info['id'];
        $this->providerName = $info['name'];
    }

    /**
     * Get a list of users from Canvas
     *
     * @param? string
     * @returns JSON decoded
     * @throws \Exception
     *
     * AccountId can be accessed via the field in the class,
     * but it seems most of the time it will be self.
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
            $response = $client->get($baseUrl . 'accounts/' . $accountId . 'users');

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
            $response = $client->get($baseUrl . 'users/' . $userId);

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
        $baseUrl = env('CANVAS_API');
        $apiKey = env('CANVAS_API_KEY');

        $client = new Client([
            'Authorization' => 'Bearer ' . $apiKey,
        ]);
        try {
            $response = $client->post($baseUrl . "accounts/self/users/", $userData);

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
     **/
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
    /**
     * List Courses from Canvas per User
     * @param string $userId
     * @return JSON decoded
     * @throws \Exception
     **/
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
}
