<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Mymodel;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

class PostTest extends TestCase
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
        // TODO Omplir amb dades vàlides
        self::$validData = [];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [];
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
 
    public function test_post_list()
    {
        // List all files using API web service
        $response = $this->getJson("/api/post");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
    }

    public function test_post_create() : object
    {
        Sanctum::actingAs(self::$testUser);
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $body = 'efefwfew';
        $latitude = 1;
        $longitude = 2;
        $visibility_id = 3;
        $author_id = 1;
        // Upload fake file using API web service
        $response = $this->postJson("/api/post", [
            "upload" => $upload,
            "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id,
        ]);
        // Check OK response
        $this->_test_ok($response, 201);
        // Check validation errors
        $response->assertValid([
            "upload",
            "body",
            "latitude",
            "longitude",
            "visibility_id",
            "author_id",
        ]);
        
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );
        $json = $response->getData();
        return $json->data;
    }

    public function test_post_create_error()
    {
        // Create fake file with invalid max size
        $name  = "avatar.png";
        $size = 5000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/post", [
            "upload" => $upload,
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }

    /**
        * @depends test_post_create
        */
    public function test_post_read(object $file)
    {
        // Read one file
        $response = $this->getJson("/api/post/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON exact values
        $response->assertJsonPath("data.filepath",
            fn ($filepath) => !empty($filepath)
        );
    }

    public function test_post_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/post/{$id}");
        $this->_test_notfound($response);
    }

    /**
        * @depends test_post_create
        */
    public function test_post_update(object $file)
    {
        // Create fake file
        $name  = "photo.jpg";
        $size = 1000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->putJson("/api/post/{$file->id}", [
            "upload" => $upload,
        ]);
        // Check OK response
        $this->_test_ok($response);
        // Check validation errors
        $response->assertValid(["upload"]);
        // Check JSON exact values
        $response->assertJsonPath("data.filesize", $size*1024);
        // Check JSON dynamic values
        $response->assertJsonPath("data.filepath",
            fn ($filepath) => str_contains($filepath, $name)
        );
    }

    /**
        * @depends test_post_create
        */
    public function test_post_update_error(object $file)
    {
        // Create fake file with invalid max size
        $name  = "photo.jpg";
        $size = 3000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->putJson("/api/post/{$file->id}", [
            "upload" => $upload,
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }

    public function test_post_update_notfound()
    {
        $id = "not_exists";
        $response = $this->putJson("/api/post/{$id}", []);
        $this->_test_notfound($response);
    }

    /**
        * @depends test_post_create
        */
    public function test_post_delete(object $file)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/post/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
    }

    public function test_post_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/post/{$id}");
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
        // Check validation errors
        $response->assertInvalid(["upload"]);
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


