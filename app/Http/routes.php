<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->get('/campaigns', ['as' => 'campaign.index', 'uses' => 'CampaignsController@index']); // show all campaigns
$app->get('/campaigns/{campaignId}', ['as' => 'campaign.get', 'uses'=> 'CampaignsController@get']); // Show tags and the stats for those tags.

$app->get('/campaigns/{campaignId}/tags', ['as' => 'tag.getTag', 'uses' => 'TagsController@getTag']); // Get a pre selected tag
$app->post('/campaigns/{campaignId}/tags', ['as' => 'tag.create', 'uses'=> 'TagsController@create']); // Add tag to campaign
$app->get('/campaigns/{campaignId}/tags/{tagSlug}', ['as' => 'tag.get', 'uses'=> 'TagsController@get']); // Get stats about a tag
$app->post('/campaigns/{campaignId}/tags/{tagSlug}', ['as' => 'tag.post', 'uses'=> 'TagsController@post']); // Increase the stats on a tag
