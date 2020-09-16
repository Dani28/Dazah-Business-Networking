<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 |--------------------------------------------------------------------------
 | DaniWeb Connect OAuth Credentials
 |--------------------------------------------------------------------------
 |
 | Specify your Daniapp's OAuth credentials
 | You can register a new Daniapp application at https://www.daniweb.com/connect/apps/register
 |
 */

$config = array(
    'client_id' => 'b',
    'client_secret' => 'foo bar baz bat blah blah blah',
    'scope' => 'profile_read,conversations_read,conversations_write'            
);