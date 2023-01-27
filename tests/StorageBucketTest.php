<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// TODO: Make StorageClient init with supplied secrets.
// i.e. StorageClient('https://abc.supabase.co/storage/v1', ['Authorization' => 'Bearer ' . 'SECRET'])

final class StorageBucketTest extends TestCase
{

    /**
    * Test Creates a new Storage bucket function.
    *
    * @return void
    */
    private $client;

    public function setup(): void {
        $authHeader = ['Authorization' => 'Bearer ' . 'SECRET'];
        $this->client = new \Supabase\SupabaseClient('https://abc.supabase.co');
    }

     /**
    * Test Retrieves the details of all Storage buckets within an existing project function.
    *
    * @return void
    */

    public function testListBucket(): void
    {
        $result =  $this->client->listBuckets();
        $this->assertGreaterThan(0, count($result['data']));
    }

    /**
     * Test Creates a new Storage bucket function
     *
     * @return void
     */

   public function testCreateBucket(): void
   {
       $storage = new \Supabase\Storage\StorageClient();

       $result = $this->client->createBucket('my-new-storage-bucket');
       $this->assertNull($result['error']);
       $this->assertArrayHasKey('data', $result);
       $this->assertEquals($result['data']['id'], 'my-new-storage-bucket');
   }

   /**
   * Test Retrieves the details of an existing Storage bucket function.
   *
   * @return void
   */

   public function testGetBucketWithId(): void
    {
        $result = $this->client->getBucket('test');

        $this->assertArrayHasKey('data', $result);
        $this->assertNull($result['error']);
    }

   


    /**
    * Test Updates a Storage bucket function.
    *
    * @return void
    */

    public function testUpdateBucket(): void
    {
        $result = $this->client->updateBucket('my-new-storage-bucket-public', ['public' => false]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }

    /**
    * Test Deletes an existing bucket function.
    *
    * @return void
    */

    public function testDeleteBucket()
    {
        $storage = new \Supabase\Storage\StorageClient();

        $result = $storage->deleteBucket('my-new-storage-bucket-public');

        $this->assertNull($result['error']);
    }

    /**
     * Test Removes all objects inside a single bucket function.
    *
    * @return void
    */

    public function testEmptyBucket()
    {
        $result = $this->client->emptyBucket('my-new-storage-bucket-public');
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }
    

    /**
     * Test Invailid bucket id function.
    *
    * @return void
    */

    public function testGetBucketWithInvalidId(): void
    {
        $storage = new \Supabase\Storage\StorageClient();

        $result = $storage->getBucket('not-a-real-bucket-id');

        $this->assertArrayHasKey('error', $result);
        $this->assertNull($result['data']);
    }

    /**
     * Test Creates a new Storage public bucket function.
    *
    * @return void
    */

    public function testCreatePublicBucket(): void
    {

        $storage = new \Supabase\Storage\StorageClient();

        $result = $storage->createBucket('my-new-storage-bucket-public', ['public' => true]);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals($result['data'], 'my-new-storage-bucket-public');
    }
    
}