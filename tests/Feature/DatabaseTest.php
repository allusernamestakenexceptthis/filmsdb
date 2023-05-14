<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Repositories\MovieRepository;
use App\Repositories\UserRepository;

class DatabaseTest extends TestCase
{
    
    /**
     * Referesh the database before each test
     */
    use RefreshDatabase;


    private MovieRepository $movieRepository;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->movieRepository = new MovieRepository(new Movie());
        $this->userRepository = new UserRepository(new User());
    }


    /**
     * Test that models can be instantiated
     */
    public function test_users_can_be_instantiated(): void
    {

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $this->userRepository->setPerPage(1);
        $records = $this->userRepository->all();

        $this->assertCount(1, $records);
    }

        /**
     * Test that models can be instantiated
     */
    public function test_movies_can_be_instantiated(): void
    {
        $movie = Movie::factory()->create();

        $this->assertInstanceOf(Movie::class, $movie);

        
 
        $this->movieRepository->setPerPage(1);
        $records = $this->movieRepository->all();

        $this->assertCount(1, $records);
    }
    
    /**
     * Test that records can be created
     */
    public function test_records_can_be_created(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 11);
        $this->assertDatabaseCount('movies', 50);
    }

}
