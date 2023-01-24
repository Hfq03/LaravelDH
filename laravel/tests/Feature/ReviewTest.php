<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase; 
use Illuminate\Http\UploadedFile; 
use Laravel\Sanctum\Sanctum; 
use App\Models\User;
use App\Http\Controllers\Api\ReviewController;


class ReviewTest extends TestCase
{
    public static User $testUser;
    public static array $validData = [];
    public static array $invalidData = [];
    public static int $placeId = 24;

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
        // Creem usuari/a de prova
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);
    
        // TODO Omplir amb dades vàlides
        self::$validData = [
            'review' => 'Es un sitio espectacular, muy recomendable!',
            'stars'    => '2'
        ];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [
            'review' => 38,
            'stars'    => 'asdfsdf'
        ];
    }
 
    public function test_myresource_first()
    {
        // Desem l'usuari al primer test
        self::$testUser->save();
        // Comprovem que s'ha creat
        $this->assertDatabaseHas('users', [
            'email' => self::$testUser->email,
        ]);
    }

    public function test_review_list()
    {
        // List all files using API web service
        $response = $this->getJson("/api/places/" . self::$placeId . "/reviews");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
    }

    public function test_review_create() : object
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->postJson("/api/places/" . self::$placeId ."/reviews", self::$validData);
        // Check OK response
        $this->_test_ok($response, 201);
        // Check validation errors
        $response->assertValid(["review", "stars"]);
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }

    public function test_review_create_error()
    {
        Sanctum::actingAs(self::$testUser);
        // Cridar servei web de l'API
        $response = $this->postJson("/api/places/" . self::$placeId ."/reviews", self::$invalidData);
        // TODO Revisar errors de validació
        $params = ['review','stars'];
        $response->assertInvalid($params);
    }

    /**
     * @depends test_review_create
     */

    public function test_review_delete(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->deleteJson("/api/places/{$review->place_id}/reviews/{$review->id}");
        $this->_test_ok($response);
    }

    /**
     * @depends test_review_create
     */

    public function test_review_delete_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->deleteJson("/api/places/". self::$placeId ."/reviews/{$id}");
        $this->_test_notfound($response);
    }

    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
            "data"    => true // any value
        ]);
    }
    
    protected function _test_error($response)
    {
        // Check response
        $response->assertStatus(422);
        // Check JSON properties
        $response->assertJson([
            "message" => true, // any value
            "errors"  => true, // any value
        ]);       
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );
        $response->assertJsonPath("errors",
            fn ($errors) => is_array($errors)
        );
    }
    
    protected function _test_notfound($response)
    {
        // Check JSON response
        $response->assertStatus(404);
        // Check JSON properties
        $response->assertJson([
            "success" => false,
            "message" => true // any value
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );   
    }

    public function test_myresource_last()
    {
        // Eliminem l'usuari al darrer test
        self::$testUser->delete();
        // Comprovem que s'ha eliminat
        $this->assertDatabaseMissing('users', [
            'email' => self::$testUser->email,
        ]);
    }
}
