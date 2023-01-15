<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase; 
use Illuminate\Http\UploadedFile; 
use Laravel\Sanctum\Sanctum; 
use App\Models\User;


class ReviewTest extends TestCase
{
    public static User $testUser;
    public static array $validData = [];
    public static array $invalidData = [];

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
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // TODO Omplir amb dades vàlides
        self::$validData = [
            'title' => 'Soy ismael',
            "upload" => $upload,
            'description' => 'me gusta m07',
            'stars'    => '2',
            'visibility_id'   => '2',
        ];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [
            'title' => 38,
            "upload" => $upload,
            'description' => 19,
            'stars'    => '8',
            'visibility_id'   => '2',
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
        $response = $this->getJson("/api/review");
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
        // Llamar servicio API y revisar que no hay errores de validacion
        $response = $this->postJson("/api/review", self::$validData);

        $params = array_keys(self::$validData);
        $response->assertValid($params);
                
        // Check OK response
        $this->_test_ok($response, 201);
    
        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }

    public function test_review_create_error()
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API
        $response = $this->postJson("/api/review", self::$invalidData);

        $params = [
            'name', 'description'
        ];
        $response->assertInvalid($params);
        
        // Check ERROR response
        $this->_test_error($response);
    }

    /**
     * @depends test_review_create
     */
    public function test_review_read(object $review)
    {
        // Read one file
        $response = $this->getJson("/api/review/{$review->id}");
        // Check OK response
        $this->_test_ok($response);
       
    }

    public function test_review_read_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->getJson("/api/review/{$id}");
        $this->_test_notfound($response);
    }

    /**
     * @depends test_review_create
     */
    public function test_review_update(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API y revisar que no hay errores de validacion
        $response = $this->putJson("/api/review/{$review->id}", self::$validData);

        $params = array_keys(self::$validData);
        $response->assertValid($params);
                
        // Check OK response
        $this->_test_ok($response, 201);
    
        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );

        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }

    /**
     * @depends test_review_create
     */

    public function test_review_update_error(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API
        $response = $this->postJson("/api/review", self::$invalidData);

        $params = [
            'name', 'description'
        ];
        $response->assertInvalid($params);
        // Check ERROR response
        $this->_test_error($response);
    }

    public function test_review_update_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->putJson("/api/review/{$id}", []);
        $this->_test_notfound($response);
    }

    /**
    * @depends test_review_create
    */
    public function  test_review_favorite(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        // Delete one file using API web service
        $response = $this->postJson("/api/review/{$review->id}/favorites");
        // Check OK response
        $this->_test_ok($response);
    }
    /**
    * @depends test_review_create
    */
    public function test_review_unfavorite(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        // Delete one file using API web service
        $response = $this->deleteJson("/api/review/{$review->id}/favorites");
        // Check OK response
        $this->_test_ok($response);
    }

    /**
     * @depends test_review_create
     */

    public function test_review_delete(object $review)
    {
        Sanctum::actingAs(self::$testUser);
        // Delete one file using API web service
        $response = $this->deleteJson("/api/review/{$review->id}");
        // Check OK response
        $this->_test_ok($response);
    }

    /**
     * @depends test_review_create
     */

    public function test_review_delete_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->deleteJson("/api/review/{$id}");
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
